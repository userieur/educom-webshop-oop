<?php
    function validName($value) {
        if (empty($value)) {
            $error = "Name is required";
        } elseif (!preg_match("/^[a-zA-Z-' ]*$/",$value)) {
            $error = "Only letters and white space allowed"; 
        }
        return $error ?? NULL;
    }

    function validEmail($value) {
        if (empty($value)) {
            $error = "E-mail address is required";
        } elseif (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $error = "Please enter a correct e-mail address";
        }
        return $error ?? NULL;
    }

    function validPhone($value) {
        if (empty($value)) {
            $error = "Phone is required";
        } elseif (!is_numeric($value)) {
            $error = "Please enter a correct phone number";
        }
        return $error ?? NULL;
    }

    function validComment($value) {
        if (empty($value)) {
            $error = "Please enter reasons";
        }
        return $error ?? NULL;
    }

    function validPassword($value) {
        if (empty($value)) {
            $error = "Please enter password";
        } elseif (!preg_match("/^[a-zA-Z-' ]*$/",$value)) {
            $error = "Only letters and white space allowed"; 
        }
        return $error ?? NULL;
    }

    function equalTo($value, $functionVar="") {
        $comparable = cleanInput($_POST[$functionVar]);
        if (empty($value)) {
            $error = "Please repeat input";
        } elseif ($value != $comparable) {
            $error = "Input does not match"; 
        }  
        return $error ?? NULL;
    }

    function emailNotKnown($value) {
        $exists = doesEmailExist($value);
        if ($exists) {
            $error = "E-Mail already exists";
        }
        return $error ?? NULL;
    }

    function emailKnown($value) {
        $exists = doesEmailExist($value);
        if (!$exists) {
            $error = "E-Mail not known";
        }
        return $error ?? NULL;
    }

    function authenticateUser($value) {
        if (!isUserLoggedIn()) {
            $email = cleanInput($_POST['email']);
        } else {
            $email = $_SESSION['email'];
        }
        $userInfo = findUserByEmail($email);
            if ($value != cleanInput($userInfo['password'])) {
                $error = "Password incorrect";
            }
        return $error ?? NULL;  
        }

    function checkForError ($value, $check) {
        $param = $param ?? array();
        $checkArray = explode(":", $check);
        $functionName = $checkArray[0] ?? $check;
        $functionVar = $checkArray[1] ?? NULL;
        $error = call_user_func_array($functionName, array($value, $functionVar));
        return $error;
    }

    function cleanInput ($value) {
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);
        return $value;
    }

    function validateInput($key, $items) {
        var_dump($key);
        $checks = $items['checks'] ?? NULL;
        $value = cleanInput($_POST[$key]) ?? "";
        var_dump($value);
        $output = ['value' => $value];
        if ($checks != NULL) {
            foreach($checks as $check) {
                $error = checkForError($value, $check);
                if ($error != NULL) {
                    $output += ['error' => $error];
                    break;
                }
            }
        }
        return $output;
    }           

    function validateForm($data) {
        $output = $data;
        // var_dump($output);
        $noErrors = true;
        foreach($data as $key => $items) {
            switch($key) {
                case 'validForm':
                case 'css':
                    break;
                default:
                    $checkedInput = validateInput($key, $items);
                    $output[$key] += ['value' => $checkedInput['value']];
                    if (isset($checkedInput['error'])) {
                        $noErrors = false;
                        $output[$key] += ['error' => $checkedInput['error']];
                    }
                }
        }
        if ($noErrors) {
            $output['validForm'] = true;
        }
        return $output;
    }
?>