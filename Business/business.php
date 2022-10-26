<?php
    require_once("constants.php");
    require_once("session.php");
    require_once("tosort.php");
    require_once("utils.php");
    require_once("validation.php");

    function amphMetamine($data) {
        // Meta-data for all pages
        $data['mainPages'] = [HOME, ABOUT, CONTACT, WEBSHOP];
        if (isUserLoggedIn()) {
            $data['sessionPages'] = [USERPAGE, CART, LOGUIT];
            $data['allowedToBuy'] = true;
        } else {
            $data['sessionPages'] = [REGISTRATIE, LOGIN];
            $data['allowedToBuy'] = false;
        }
        // Meta-data for form-pages
        switch($data['page']) {
            case 'contact':
            case 'registratie':
            case 'login':
            case 'userpage':
                $data['form'] = getForm($data);
                break;
            default:
                break;
        }
        return($data);
    }

    function processRequest($data) {
        $data = amphMetamine($data);

        switch ($data['page']) {
            case 'contact':
            case 'register':
            case 'login':
            case 'userpage':
                // Actions for form-pages    
                if (isPostRequest()) {
                    $data['form'] = validateForm($data['form']);
                }
                break;
            case 'webshop':
            case 'detail':
            case 'cart':
                // Actions for product-pages
                $products = getItems($data);
                $data['products'] = $products['products'];
                $data['productsClass'] = $products['class'];
                handleActions();
                break;
        }

        if (isset($data['form']) && $data['form']['validForm']) {
            // Redirects for form-pages, when form is valid
            switch ($data['page']) {
                case 'contact':
                    $data['page'] = 'thanks';
                    $data = amphMetamine($data);
                    break;
                case 'registratie':
                    storeUser($data);
                    $data['page'] = 'login';
                    $data = amphMetamine($data);
                    break;
                case 'login':
                    doLoginUser($data);
                    $data['page'] = 'home';
                    $data = amphMetamine($data);
                    break;
                case 'userpage':
                    updatePassword($data);
                    $data['page'] = 'updated';
                    $data = amphMetamine($data);
                    break;
            }
        }
        return $data;
    }

    function handleActions() {
        $name = getVar('id');
        $action = getVar("action");
        switch($action) {
            case ACTION_ADD_TO_CART:
                if (array_key_exists($name, $_SESSION['cart'])) {
                    $_SESSION['cart'][$name] += 1; 
                } else {
                    $_SESSION['cart'] += [$name => 1];
                }
                break;
            case ACTION_REMOVE_FROM_CART:
                if (!isset($_SESSION['cart'][$name])) {
                    // do nothing;
                } elseif ($_SESSION['cart'][$name] == 1) {
                    unset($_SESSION['cart'][$name]); 
                } else {
                    $_SESSION['cart'][$name] -= 1;
                }
                break;
            case ACTION_ORDER:
                if ($_SESSION['cart']) {
                    placeOrder();
                    $_SESSION['cart'] = [];
                } else {
                    echo 'Mandje is leeg G'; 
                }
                break;
        }
    }

    function getForm($data) {
        switch($data['page']) {
            case 'contact':
                $formArray = ['validForm' => false, 'css' => "contactform",
                'sex' => getFormLine(key:'sex', type:'select', label:'Aanhef:', placeholder:'Kies', options:['man|Dhr', 'woman|Mevr']),
                'fname' => getFormLine(key:'fname', type:'text', label:'Voornaam:', placeholder:'Jan', checks:[VALIDATE_NAME]),
                'lname' => getFormLine(key:'lname', type:'text', label:'Achternaam:', placeholder:'van der Steen', checks:[VALIDATE_NAME]),
                'email' => getFormLine(key:'email', type:'email', label:'E-Mail:', placeholder:'jan.v.d.steen@provider.com', checks:[VALIDATE_EMAIL]),
                'phone' => getFormLine(key:'phone', type:'phone', label:'Telefoon:', placeholder:'0612345678 / 0101234567', checks:[VALIDATE_PHONE]),
                'pref' => getFormLine(key:'pref', type:'radio', label:'Ik word het liefst benaderd via:', options:['tel|Telefoon','mail|E-Mail']),
                'story' => getFormLine(key:'story', type:'textbox', label:'Reden van contact:', placeholder:'Vul hier iets in')];
                break;
            case 'registratie':
                $formArray = ['validForm' => false, 'css' => "form",
                'uname' => getFormLine(key:'uname', type:'text', label:'Gebruikersnaam:', placeholder:'Kies', checks:[VALIDATE_NAME]),
                'email' => getFormLine(key:'email', type:'email', label:'E-mail:', placeholder:'j.v.d.steen@provider.com', checks:[VALIDATE_EMAIL, USER_EMAIL_NOT_KNOWN]),
                'pword' => getFormLine(key:'pword', type:'password', label:'Wachtwoord:', placeholder:'vul wachtwoord in', checks:[VALIDATE_PASSWORD]),
                'pwordcheck' => getFormLine(key:'pwordcheck', type:'password', label:'Herhaal wachtwoord:', placeholder:'herhaal wachtwoord', checks:[VALIDATE_PASSWORD_EQUAL_ENTRY])];
                break;
            case 'login':
                $formArray = ['validForm' => false, 'css' => "form",
                'email' => getFormLine(key:'email', type:'email', label:'E-mail:', placeholder:'j.v.d.steen@provider.com', checks:[VALIDATE_EMAIL, USER_EMAIL_KNOWN]),
                'pword' => getFormLine(key:'pword', type:'password', label:'Wachtwoord:', placeholder:'vul wachtwoord in', checks:[VALIDATE_PASSWORD, USER_AUTHENTICATE])];
                break;
            case 'userpage':
                $formArray = ['validForm' => false, 'css' => "form",
                'opword' => getFormLine(key:'opword', type:'password', label:'Oude wachtwoord:', placeholder:'vul wachtwoord in', checks:[VALIDATE_PASSWORD, USER_AUTHENTICATE]),
                'pword' => getFormLine(key:'pword', type:'password', label:'Nieuwe Wachtwoord:', placeholder:'vul wachtwoord in', checks:[VALIDATE_PASSWORD]),
                'pwordcheck' => getFormLine(key:'pwordcheck', type:'password', label:'Herhaal nieuwe wachtwoord:', placeholder:'herhaal wachtwoord', checks:[VALIDATE_PASSWORD_EQUAL_ENTRY])];
                break;
            default:
                break;
        }
        return $formArray;
    }

    function splitOptions (array $options) {
        $output = [];
        foreach($options as $option) {
            $array = explode("|", $option);
            $output += [$array[0] => $array[1]];
        }
        return $output;
    }

    function getFormLine(string $key, string $type, string $label, string $placeholder="", $options=array(), $checks=array()) {
        $options = splitOptions($options);
        return ['key' => $key, 'type' => $type, 'label' => $label, 'placeholder' => $placeholder, 'options' => $options, 'checks' => $checks];
    }


    function getItems($data) {
        switch ($data['page']) {
            case 'webshop':
                $output['products'] = getAllProducts();
                $output['class'] = "";
                break;
            case 'detail':
                $id = getVar('id');
                $output['products'][$id] = getProductById($id);
                $output['class'] = "big";
                break;
            case 'cart':
                // var_dump($_SESSION['cart']);
                $output['products'] = getProductsByIdArray($_SESSION['cart']);
                // var_dump($output['products']);
                $output['products'] = getCartContent($output['products']);
                var_dump($output['products']);
                // $output['cart'] = getCartContent($output['products']);
                $output['class'] = "cart";
                break;
        }
        return $output ?? NULL;
    }



    