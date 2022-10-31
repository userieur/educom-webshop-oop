<?php
    require_once("Business/business.php");

    class SessionManager {
        function doLoginUser($user) {
            $_SESSION['user'] = $user['userName'];
            $_SESSION['userId'] = $user['userId'];
            $_SESSION['email'] = $user['email'];
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
    }
