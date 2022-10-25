<?php
    require_once("constants.php");

    function amphMetamine($data) {
        $data['mainPages'] = [HOME, ABOUT, CONTACT, WEBSHOP];
        if (isUserLoggedIn()) {
            $data['sessionPages'] = [USERPAGE, CART, LOGUIT];
            $data['allowedToBuy'] = true;
        } else {
            $data['sessionPages'] = [REGISTRATIE, LOGIN];
            $data['allowedToBuy'] = false;
        }
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
                if (isPostRequest()) {
                    $data['form'] = validateForm($data['form']);
                }
                break;
            case 'webshop':
            case 'detail':
            case 'cart':
                handleActions();
                break;
        }

        if (isset($data['form']) && $data['form']['validForm']) {
            switch ($data['page']) {
                case 'contact':
                    $data['page'] = 'thanks';
                    break;
                case 'registratie':
                    storeUser($data);
                    $data['page'] = 'login';
                    break;
                case 'login':
                    doLoginUser($data);
                    $data['page'] = 'home';
                    break;
                case 'userpage':
                    updatePassword($data);
                    $data['page'] = 'updated';
                    break;
            }
        }
        return $data;
    }

    function handleActions() {
        $name = getVar('name');
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
                $formArray = ['validForm' => false, 'css' => "form",
                getFormLine(key:'sex', type:'select', label:'Aanhef:', placeholder:'Kies', options:['man|Dhr', 'woman|Mevr']),
                getFormLine(key:'fname', type:'text', label:'Voornaam:', placeholder:'Jan', checks:[VALIDATE_NAME]),
                getFormLine(key:'lname', type:'text', label:'Achternaam:', placeholder:'van der Steen', checks:[VALIDATE_NAME]),
                getFormLine(key:'email', type:'email', label:'E-Mail:', placeholder:'jan.v.d.steen@provider.com', checks:[VALIDATE_EMAIL]),
                getFormLine(key:'phone', type:'phone', label:'Telefoon:', placeholder:'0612345678 / 0101234567', checks:[VALIDATE_PHONE]),
                getFormLine(key:'pref', type:'radio', label:'Ik word het liefst benaderd via:', options:['tel|Telefoon','mail|E-Mail']),
                getFormLine(key:'story', type:'textbox', label:'Reden van contact:', placeholder:'Vul hier iets in')];
                break;
            case 'registratie':
                $formArray = ['validForm' => false, 'css' => "form",
                getFormLine(key:'uname', type:'text', label:'Gebruikersnaam:', placeholder:'Kies', checks:[VALIDATE_NAME]),
                getFormLine(key:'email', type:'email', label:'E-mail:', placeholder:'j.v.d.steen@provider.com', checks:[VALIDATE_EMAIL, USER_EMAIL_NOT_KNOWN]),
                getFormLine(key:'pword', type:'password', label:'Wachtwoord:', placeholder:'vul wachtwoord in', checks:[VALIDATE_PASSWORD]),
                getFormLine(key:'pwordcheck', type:'password', label:'Herhaal wachtwoord:', placeholder:'herhaal wachtwoord', checks:[VALIDATE_PASSWORD_EQUAL_ENTRY])];
                break;
            case 'login':
                $formArray = ['validForm' => false, 'css' => "form",
                getFormLine(key:'email', type:'email', label:'E-mail:', placeholder:'j.v.d.steen@provider.com', checks:[VALIDATE_EMAIL, USER_EMAIL_KNOWN]),
                getFormLine(key:'pword', type:'password', label:'Wachtwoord:', placeholder:'vul wachtwoord in', checks:[VALIDATE_PASSWORD, USER_AUTHENTICATE])];
                break;
            case 'userpage':
                $formArray = ['validForm' => false, 'css' => "form",
                getFormLine(key:'opword', type:'password', label:'Oude wachtwoord:', placeholder:'vul wachtwoord in', checks:[VALIDATE_PASSWORD, USER_AUTHENTICATE]),
                getFormLine(key:'pword', type:'password', label:'Nieuwe Wachtwoord:', placeholder:'vul wachtwoord in', checks:[VALIDATE_PASSWORD]),
                getFormLine(key:'pwordcheck', type:'password', label:'Herhaal nieuwe wachtwoord:', placeholder:'herhaal wachtwoord', checks:[VALIDATE_PASSWORD_EQUAL_ENTRY])];
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
        return [$key => ['key' => $key, 'type' => $type, 'label' => $label, 'placeholder' => $placeholder, 'options' => $options, 'checks' => $checks]];
    }


    function showItems($data) {
        
        $data['products']=[];





        echo '<div class="container">';
        foreach($data as $key => $info) {
            $id = $key;
            $name = $info['name'];
            $imageurl = $info['imageurl'];
            $price = $info['price'];
            $description = $info['description'];
            echo '
            <div class="webshop">
                <img src="Images/'.$imageurl.'" alt="'.$name.'"><br>
                <p class="name"><a href="index.php?page=detail&id='.$id.'">'.$name.'</a></p><br>
                <p class="id">Productnr. = '.$id.'</p>
                <p class="price">€ '.$price.'</p>
                <p class="description">'.$description.'</p><br>';
            if (isset($_SESSION['user'])) {
                addActionForm(ACTION_ADD_TO_CART, $page, $name, $id);
            }
            echo '</div>';
        echo '</div>';
        }
        return $data
    }

    function showDetailItem(string $page, array $info) {
        $id = $info['id'];
        $name = $info['name'];
        $imageurl = $info['imageurl'];
        $price = $info['price'];
        $description = $info['description'];
        echo '
        <div class="webshop">
            <img class="big" src="Images/'.$imageurl.'" alt="'.$name.'"><br>
            <p class="name">'.$name.'</a></p><br>
            <p class="id">Productnr. = '.$id.'</p>
            <p class="price">€ '.$price.'</p>
            <p class="description">'.$description.'</p><br>';
        if (isset($_SESSION['user'])) {
            addToCartForm($page, $name, $id);
            removeFromCartForm($page, $name, $id);
        }
        echo '</div>';
    }

    function showCartItems($page, $data) {
        echo '<div class="container">';
        $grandTotal = 0;
        $_SESSION['invoicelines'] = [];
        if ($data) {
            foreach($data as $key => $info) {
                $id = $key;
                $name = $info['name'];
                $imageurl = $info['imageurl'];
                $price = $info['price'];
                $description = $info['description'];
                $count = $_SESSION['cart'][$name];
                $_SESSION['invoicelines'] += [$name => array()];
                $_SESSION['invoicelines'][$name] += ['sales_amount' => $count];
                $_SESSION['invoicelines'][$name] += ['sales_price' => $price];
                $_SESSION['invoicelines'][$name] += ['article_id' => $id];
                echo '
                <div class="webshop">
                    <img class="cart" src="Images/'.$imageurl.'" alt="'.$name.'"><br>
                    <p class="name"><a href="index.php?page=detail&id='.$id.'">'.$name.'</a></p><br>
                    <p class="count">Items'.$count.'</p>
                    <p class="price">€ '.$price.'</p>
                    <p class="subtotal">€ '.$count*$price.'</p>
                    <p class="description">'.$description.'</p><br>';
                if (isset($_SESSION['user'])) {
                    addToCartForm($page, $name, $id);
                    removeFromCartForm($page, $name, $id);
                }
                $grandTotal += ($count*$price);
                echo '</div>';
            echo '</div>';
            }
            echo '<p class="total">Total = € '.$grandTotal.'</p><br>';
            addActionForm("order", $page);
        } 
         else {
            echo 'cart is empty G';
            unset($_SESSION['invoicelines']);
        }
    }

    