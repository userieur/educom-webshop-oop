<?php

    class Utils {
        public static function getVar($key, $default='') {
            $requested_type = $_SERVER['REQUEST_METHOD']; 
            if ($requested_type == 'POST') { 
                $var = Utils::getPostVar($key,'postvar'); 
            } else { 
                $var = Utils::getUrlVar($key,'getvar'); 
            } 
            return $var;
        }

        public static function getPostVar($key, $default='') { 
            $value = filter_input(INPUT_POST, $key); 
            return isset($value) ? $value : $default; 
        } 

        public static function getUrlVar($key, $default='') { 
            $value = filter_input(INPUT_GET, $key);
            return isset($value) ? $value : $default;  
        }

        public static function isPostRequest() {
            $type = $_SERVER['REQUEST_METHOD'];
            return ($type == 'POST') ? true : false;
        }

        public static function currentDate () {
            date_default_timezone_set('Europe/Amsterdam');
            $date = date('Ymd');
            return $date;
        }
        
        public static function cleanSQLInput($conn, $value) {
            return mysqli_real_escape_string($conn, $value);
        }

        public static function cleanInput ($value) {
            $value = trim($value);
            $value = stripslashes($value);
            $value = htmlspecialchars($value);
            return $value;
        }
    }