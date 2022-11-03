<?php
    class SessionManager {
        function doLoginUser($user) {
            $_SESSION['user'] = $user->username;
            $_SESSION['userId'] = $user->id;
            $_SESSION['email'] = $user->email;
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
