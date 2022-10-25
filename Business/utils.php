<?php
    function getRequestedPage() {     
        $requested_type = $_SERVER['REQUEST_METHOD']; 
        if ($requested_type == 'POST') { 
            $requested_page = getPostVar('page','home'); 
        } else { 
            $requested_page = getUrlVar('page','home'); 
        } 
        return $requested_page;
    }

    function getVar($key, $default='') {
        $requested_type = $_SERVER['REQUEST_METHOD']; 
        if ($requested_type == 'POST') { 
            $var = getPostVar($key,'postvar'); 
        } else { 
            $var = getUrlVar($key,'getvar'); 
        } 
        return $var;
    }

    function getPostVar($key, $default='') { 
        $value = filter_input(INPUT_POST, $key); 
        return isset($value) ? $value : $default; 
    } 

    function getUrlVar($key, $default='') { 
        $value = filter_input(INPUT_GET, $key);
        return isset($value) ? $value : $default;  
    }

    function isPostRequest() {
        $type = $_SERVER['REQUEST_METHOD'];
        return ($type == 'POST') ? true : false;
    }

    function currentDate () {
        date_default_timezone_set('Europe/Amsterdam');
        $date = date('Ymd');
        return $date;
    }
    
    function cleanSQLInput($conn, $value) {
        return mysqli_real_escape_string($conn, $value);
    }

    function doesEmailExist($email) {
        $userInfo = findUserByEmail($email);
        return !empty($userInfo);
    }