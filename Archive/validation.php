<?php
    require_once ("./data/data.php");
    require_once ("utils.php");

    class Validate {

        private $output;
        private $noErrors;

        public function __construct() {
            $this->output = [];
            $this->noErrors = true;
        }

        // private function validName($value) {
        //     if (empty($value)) {
        //         $error = "Name is required";
        //     } elseif (!preg_match("/^[a-zA-Z-' ]*$/",$value)) {
        //         $error = "Only letters and white space allowed"; 
        //     }
        //     return $error ?? NULL;
        // }
    
        // private function validEmail($value) {
        //     if (empty($value)) {
        //         $error = "E-mail address is required";
        //     } elseif (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
        //         $error = "Please enter a correct e-mail address";
        //     }
        //     return $error ?? NULL;
        // }
    
        // private function validPhone($value) {
        //     if (empty($value)) {
        //         $error = "Phone is required";
        //     } elseif (!is_numeric($value)) {
        //         $error = "Please enter a correct phone number";
        //     }
        //     return $error ?? NULL;
        // }
    
        // private function validComment($value) {
        //     if (empty($value)) {
        //         $error = "Please enter reasons";
        //     }
        //     return $error ?? NULL;
        // }
    
        // private function validPassword($value) {
        //     if (empty($value)) {
        //         $error = "Please enter password";
        //     } elseif (!preg_match("/^[a-zA-Z-' ]*$/",$value)) {
        //         $error = "Only letters and white space allowed"; 
        //     }
        //     return $error ?? NULL;
        // }
    
        private function equalTo($value, $functionVar="") {
            $comparable = Utils::cleanInput($_POST[$functionVar]);
            if (empty($value)) {
                $error = "Please repeat input";
            } elseif ($value != $comparable) {
                $error = "Input does not match"; 
            }  
            return $error ?? NULL;
        }
    
        private function checkForError ($value, $check) {
            $param = $param ?? array();
            $checkArray = explode(":", $check);
            $functionName = $checkArray[0] ?? $check;
            $functionVar = $checkArray[1] ?? NULL;
            $error = call_user_func_array(array($this, $functionName), array($value, $functionVar));
            return $error;
        }

    
        private function validateInput($key, $items) {
            $checks = $items['checks'] ?? NULL;
            $value = Utils::cleanInput($_POST[$key]) ?? "";
            $output = ['value' => $value];
            if ($checks != NULL) {
                foreach($checks as $check) {
                    $error = self::checkForError($value, $check);
                    if ($error != NULL) {
                        $output += ['error' => $error];
                        break;
                    }
                }
            }
            return $output;
        }           
    
        public function validateForm($data) {
            $this->output = $data;
            foreach($data as $key => $items) {
                switch($key) {
                    case 'validForm':
                    case 'css':
                        break;
                    default:
                        $checkedInput = self::validateInput($key, $items);
                        $this->output[$key] += ['value' => $checkedInput['value']];
                        if (isset($checkedInput['error'])) {
                            $this->noErrors = false;
                            $this->output[$key] += ['error' => $checkedInput['error']];
                        }
                }
            }
            if ($this->noErrors) {
                $this->output['validForm'] = true;
            }
            $output = $this->output;
            $this->output = [];
            return $output;
        }
    }

    