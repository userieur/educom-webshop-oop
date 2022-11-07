<?php
    class SessionManager {
        function doLoginUser($user) {
            $_SESSION['user'] = $user->getUsername();
            $_SESSION['userId'] = $user->getId();
            $_SESSION['email'] = $user->getEmail();
            $_SESSION['cart'] = array();
        }
    
        function isUserLoggedIn() {
            return isset($_SESSION['user']);
        }
    
        function getLoggedInUser() {
            return $_SESSION['user'];
        }

        function getLoggedInUserId() {
            return $_SESSION['userId'];
        }

        function getLoggedInUserEmail() {
            return $_SESSION['email'];
        }

        function getCart() {
            return $_SESSION['cart'];
        }
    
        function getCartItemCount($id) {
            return $_SESSION['cart'][$id] ?? Null;
        }

        function setCartItemCount($id, $count) {
            $_SESSION['cart'][$id] = $count;
        }

        function removeCartItem ($id) {
            unset($_SESSION['cart'][$id]);
        }

        function emptyCart() {
            $_SESSION['cart'] = [];
        }

        function doLogoutUser() {
            session_unset();
        }
        
    }
