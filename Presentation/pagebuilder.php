<?php
    // Identifying the requested page + all functions
    require_once("Business/basics.php");
    require_once("Business/validation.php");
    require_once("Business/utils.php");
    require_once("Business/business.php");

    function showResponsePage($data) {
        $view = NULL;
        switch($data['page']){
            case 'home':
                require_once('views/HomeDoc.php');
                $view = new HomeDoc($data);
                break;
            case 'about':
                require_once('views/AboutDoc.php');
                $view = new AboutDoc($data);;
                break;
            case 'contact':
                require_once('views/ContactDoc.php');
                $view = new ContactDoc($data);
                break;
            case 'registratie':
                require_once('views/RegisterDoc.php');
                $view = new RegisterDoc($data);
                break;
            case 'thanks':
                require_once('views/ThanksDoc.php');
                $view = new ThanksDoc($data);
                break;
            case 'login':
                require_once('views/LoginDoc.php');
                $view = new LoginDoc($data);
                break;
            case 'userpage':
                require_once('views/UserpageDoc.php');
                $view = new UserpageDoc($data);
                break;
            case 'updated':
                require_once('views/UpdatedDoc.php');
                $view = new UpdatedDoc($data);
                break;
            case 'webshop':
                require_once('views/WebshopDoc.php');
                $view = new WebshopDoc($data);
                break;
            case 'detail':
                require_once('views/DetailDoc.php');
                $view = new DetailDoc($data);
                break;
            case 'cart':
                require_once('views/CartDoc.php');
                $view = new CartDoc($data);
                break;
            default:
                require_once('views/UnknownPage.php');
                $view = new UnknownPage($data);
                break;
        }
        $view->show();
    }

