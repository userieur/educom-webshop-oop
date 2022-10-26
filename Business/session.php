<?php

    function doLoginUser($data) {
        var_dump($data['form']['email']);
        $userInfo = findUserByEmail($data['form']['email']['value']);
        $_SESSION['user'] = $userInfo['username'];
        $_SESSION['userId'] = $userInfo['id'];
        $_SESSION['email'] = $userInfo['email'];
        $_SESSION['cart'] = array();
    }

    function isUserLoggedIn() {
        return isset($_SESSION['user']);
    }

    function getLoggedInUser() {
        return $_SESSION('user');
    }

    function doLogoutUser() {
        session_unset();
}