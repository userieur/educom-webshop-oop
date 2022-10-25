<?php
    //Actions
    define("ACTION_ADD_TO_CART", "addToCart");
    define("ACTION_REMOVE_FROM_CART", "removeFromCart");
    define("ACTION_ORDER", "order");

    //Validations
    define("VALIDATE_NAME", "validName");
    define("VALIDATE_EMAIL", "validEmail");
    define("VALIDATE_PHONE", "validPhone");
    define("VALIDATE_PASSWORD", "validPassword");
    define("VALIDATE_PASSWORD_EQUAL_ENTRY", "equalTo:pword");

    //User validations
    define("USER_AUTHENTICATE", "authenticateUser");
    define("USER_EMAIL_KNOWN", "emailKnown");
    define("USER_EMAIL_NOT_KNOWN", "emailNotKnown");

    //Pages
    define("HOME", ['home' => 'Home']);
    define("ABOUT", ['about' => 'About']);
    define("CONTACT", ['contact' => 'Contact']);
    define("WEBSHOP", ['webshop' => 'Webshop']);
    define("LOGIN", ['login' => 'Login']);
    define("LOGUIT", ['loguit' => 'Loguit']);
    define("CART", ['cart' => 'Cart']);
    define("REGISTRATIE", ['registratie' => 'Registratie']);
    define("USERPAGE", ['userpage' => 'Userpage']);