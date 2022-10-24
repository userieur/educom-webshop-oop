<?php

    function processRequest($data) {
        switch ($data['page']) {
            case 'home':
            case 'about':
            case 'thanks':
                break;
            case 'contact':
                require_once "../views/ContactDoc.php";
                $data['form'] = getForm();
                if (isPostRequest()) {
                    $data['form'] = validateForm($data['form']);
                    if ($data['form']['validForm']) {
                        $data['page'] = 'thanks';
                    }
                } 
                break;
            case 'registratie':
                require_once "../views/RegisterDoc.php";
                $data['form'] = getForm();
                if (isPostRequest()) {
                    $data['form'] = validateForm($data['form']);
                    if ($data['form']['validForm']) {
                        storeUser($data);
                        $data['page'] = 'login';
                    }
                } 
                break;
            case 'login':
                require_once "../views/LoginDoc.php";
                $data['form'] = getForm();
                if (isPostRequest()) {
                    $data['form'] = validateForm($data['form']);
                    if ($data['form']['validForm']) {
                        doLoginUser($data);
                        $data['page'] = 'home';
                    }
                } 
                break;
            case 'userpage':
                require_once "../views/UserpageDoc.php";
                $data['form'] = getForm();
                if (isPostRequest()) {
                    $data['form'] = validateForm($data['form']);
                    if ($data['form']['validForm']) {
                        updatePassword($data);
                        $data['page'] = 'updated';
                    }
                }
                break;
            case 'webshop':
            case 'detail':
            case 'cart':
                handleActions();
                break;
            default:
                break;
            }
        showResponsePage($data);
    }

    function handleActions() {
        $name = getVar('name');
        $action = getPostVar("action");
        switch($action) {
            case "addToCart":
                if (array_key_exists($name, $_SESSION['cart'])) {
                    $_SESSION['cart'][$name] += 1; 
                } else {
                    $_SESSION['cart'] += [$name => 1];
                }
                break;
            case "removeFromCart":
                if (!isset($_SESSION['cart'][$name])) {
                    // do nothing;
                } elseif ($_SESSION['cart'][$name] == 1) {
                    unset($_SESSION['cart'][$name]); 
                } else {
                    $_SESSION['cart'][$name] -= 1;
                }
                break;
            case "order":
                if ($_SESSION['cart']) {
                    placeOrder();
                    unset($_SESSION['cart']);
                    $_SESSION['cart'] = [];
                } else {
                    echo 'Mandje is leeg G'; 
                }
                break;
        }
    }

    function buildMenu($data) {
        $class = 'menu';
        //        page         label
        $pages = ['home'    => 'Home'
                 ,'about'   => 'About'
                 ,'contact' => 'Contact'
                 ,'webshop' => 'Webshop'];
        buildMenuItems($data, $pages, $class);
    }

    function buildSessionMenu($data) {
        $class = 'menu';
        if (isUserLoggedIn()) {
            //        page             label
            $pages = ['userpage'    => 'UserPage'
                     ,'loguit'      => 'Loguit'
                     ,'cart'        => 'Cart'];
        } else {
            //        page             label
            $pages = ['registratie' => 'Registratie'
                     ,'login'       => 'Login'];
        }
        buildMenuItems($data, $pages, $class);

    function buildMenuItems($data, $pages, $class) {
        echo '
        <ul class="'.$class.'">';
        foreach ($pages as $page => $label) {
            echo'
            <li><a class="' . (($data['page'] == $page) ? "active" : "") . '"href="index.php?page='.$page.'">'.$label.'</a></li>';
        }
        echo '
        </ul>';
    }

    function showItems($page, $data) {
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
                addToCartForm($page, $name, $id);
                removeFromCartForm($page, $name, $id);
            }
            echo '</div>';
        echo '</div>';
        }
    }

    function showDetailItem($page, $info) {
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
            orderForm($page, $name, $id);
        }
         else {
            echo 'cart is empty G';
            unset($_SESSION['invoicelines']);
        }
    }