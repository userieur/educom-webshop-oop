<?php
    require_once("constants.php");
    require_once("session.php");
    require_once("utils.php");
    require_once("validation.php");
    require_once("data.php");

    class Form {
        static public function getForm($page) {
            switch($page) {
                case 'contact':
                    $formArray = ['validForm' => false, 'css' => "contactform",
                    'sex' => self::getFormLine(key:'sex', type:'select', label:'Aanhef:', placeholder:'Kies', options:['man|Dhr', 'woman|Mevr']),
                    'fname' => self::getFormLine(key:'fname', type:'text', label:'Voornaam:', placeholder:'Jan', checks:[VALIDATE_NAME]),
                    'lname' => self::getFormLine(key:'lname', type:'text', label:'Achternaam:', placeholder:'van der Steen', checks:[VALIDATE_NAME]),
                    'email' => self::getFormLine(key:'email', type:'email', label:'E-Mail:', placeholder:'jan.v.d.steen@provider.com', checks:[VALIDATE_EMAIL]),
                    'phone' => self::getFormLine(key:'phone', type:'phone', label:'Telefoon:', placeholder:'0612345678 / 0101234567', checks:[VALIDATE_PHONE]),
                    'pref' => self::getFormLine(key:'pref', type:'radio', label:'Ik word het liefst benaderd via:', options:['tel|Telefoon','mail|E-Mail']),
                    'story' => self::getFormLine(key:'story', type:'textbox', label:'Reden van contact:', placeholder:'Vul hier iets in')];
                    break;
                case 'registratie': 
                    $formArray = ['validForm' => false, 'css' => "contactform",
                    'uname' => self::getFormLine(key:'uname', type:'text', label:'Gebruikersnaam:', placeholder:'Kies', checks:[VALIDATE_NAME]),
                    'email' => self::getFormLine(key:'email', type:'text', label:'E-mail:', placeholder:'j.v.d.steen@provider.com', checks:[VALIDATE_EMAIL, USER_EMAIL_NOT_KNOWN]),
                    'pword' => self::getFormLine(key:'pword', type:'password', label:'Wachtwoord:', placeholder:'vul wachtwoord in', checks:[VALIDATE_PASSWORD]),
                    'pwordcheck' => self::getFormLine(key:'pwordcheck', type:'password', label:'Herhaal wachtwoord:', placeholder:'herhaal wachtwoord', checks:[VALIDATE_PASSWORD_EQUAL_ENTRY])];
                    break;
                case 'login':
                    $formArray = ['validForm' => false, 'css' => "contactform",
                    'email' => self::getFormLine(key:'email', type:'text', label:'E-mail:', placeholder:'j.v.d.steen@provider.com', checks:[VALIDATE_EMAIL]),
                    'pword' => self::getFormLine(key:'pword', type:'password', label:'Wachtwoord:', placeholder:'vul wachtwoord in', checks:[VALIDATE_PASSWORD])];
                    break;
                case 'userpage':
                    $formArray = ['validForm' => false, 'css' => "contactform",
                    'opword' => self::getFormLine(key:'opword', type:'password', label:'Oude wachtwoord:', placeholder:'vul wachtwoord in', checks:[VALIDATE_PASSWORD]),
                    'pword' => self::getFormLine(key:'pword', type:'password', label:'Nieuwe Wachtwoord:', placeholder:'vul wachtwoord in', checks:[VALIDATE_PASSWORD]),
                    'pwordcheck' => self::getFormLine(key:'pwordcheck', type:'password', label:'Herhaal nieuwe wachtwoord:', placeholder:'herhaal wachtwoord', checks:[VALIDATE_PASSWORD_EQUAL_ENTRY])];
                    break;
                default:
                    break;
            }
            return $formArray;
        }

        static private function getFormLine(string $key, string $type, string $label, string $placeholder="", $options=array(), $checks=array()) {
            $options = self::splitOptions($options);
            return ['key' => $key, 'type' => $type, 'label' => $label, 'placeholder' => $placeholder, 'options' => $options, 'checks' => $checks];
        }

        static private function splitOptions (array $options) {
            $output = [];
            foreach($options as $option) {
                $array = explode("|", $option);
                $output += [$array[0] => $array[1]];
            }
            return $output;
        }
    
    }

    // class Shop {
    //     static public function getItems($data) {
    //         switch ($data['page']) {
    //             case 'webshop':
    //                 $output['products'] = self::getAllProducts();
    //                 $output['class'] = "";
    //                 break;
    //             case 'detail':
    //                 $id = Utils::getVar('id');
    //                 $output['products'][$id] = self::getProductById($id);
    //                 $output['class'] = "big";
    //                 break;
    //             case 'cart':
    //                 $output['products'] = self::getProductsByIdArray($_SESSION['cart']);
    //                 $output['products'] = self::getCartContent($output['products']);
    //                 $output['class'] = "cart";
    //                 break;
    //         }
    //         return $output ?? NULL;
    //     }

    //     static public function handleActions() {
    //         $id = Utils::getVar('id');
    //         $action = Utils::getVar("action");
    //         switch($action) {
    //             case ACTION_ADD_TO_CART:
    //                 if (array_key_exists($id, $_SESSION['cart'])) {
    //                     $_SESSION['cart'][$id] += 1; 
    //                 } else {
    //                     $_SESSION['cart'] += [$id => 1];
    //                 }
    //                 break;
    //             case ACTION_REMOVE_FROM_CART:
    //                 if (!isset($_SESSION['cart'][$id])) {
    //                     // do nothing;
    //                 } elseif ($_SESSION['cart'][$id] == 1) {
    //                     unset($_SESSION['cart'][$id]); 
    //                 } else {
    //                     $_SESSION['cart'][$id] -= 1;
    //                 }
    //                 break;
    //                 // CASE ITEM WEG => unset
    //             case ACTION_ORDER:
    //                 if ($_SESSION['cart']) {
    //                     self::placeOrder();
    //                     $_SESSION['cart'] = [];
    //                 } else {
    //                     echo 'Mandje is leeg G'; 
    //                 }
    //                 break;
    //         }
    //     }

    //     static private function placeOrder() {
    //         $date = Utils::currentDate();
    //         $conn = DataRepository::connectDatabase();
    //         $userId = $_SESSION['userId'];
    //         $invoiceLines = [];    

    //         // Create invoice
    //         $sql = "INSERT INTO invoices (invoice_num) VALUES ('".$date.'0000'."')";
    //         $output = DataRepository::writeData($conn, $sql);
    
    //         $sql = "SELECT invoice_num from invoices ORDER BY invoice_num DESC LIMIT 1";
    //         $output = DataRepository::readData($conn, $sql);
            
    //         $invoiceNum = intval($output) + 1;
                
    //         $sql = "UPDATE invoices SET user_id='".$userId."', invoice_num='".$invoiceNum."') WHERE invoice_num='".$date.'0000'."')";
    //         DataRepository::updateData($conn, $sql);
            
    //         // Retrieve invoice ID number of created invoice from database
    //         $sql = "SELECT id from invoices WHERE invoice_num='".$invoiceNum."'";
    //         $output = DataRepository::readData($conn, $sql);
            
    //         $invoiceId = array_shift($output);
    
    //         // Create SQL-strings for each invoice-line and insert them in invoice_lines database
    //         foreach ($invoiceLines as $line) {
    //             $columnString = "invoice_id, ";
    //             $valueString = "'".$invoiceId."', ";
    //             $count = 0;
    //             foreach ($line as $column => $value) {
    //                 if ((count($line)-$count) > 1) {
    //                     $columnString.=$column.", ";
    //                     $valueString.="'".$value."', ";
    //                     $count += 1;
    //                 } else {
    //                     $columnString.=$column;
    //                     $valueString.="'".$value."'";
    //                 }
    //             }
    //             $sql = "INSERT INTO invoice_lines (".$columnString.") VALUES (".$valueString.")";
    //             DataRepository::writeData($conn, $sql);
    //         }
    //         mysqli_close($conn);
    //     }

    //     private static function getAllProducts() {
    //         $conn = DataRepository::connectDatabase();
    //         try { 
    //             $sql = $sql = "SELECT * from products";
    //             $items = DataRepository::readData($conn, $sql);
    //             return $items; 
    //         }
    //         finally {
    //             mysqli_close($conn);    
    //         }
    //     }
    
    //     private static function getProductsByIdArray($array) {
    //         $conn = DataRepository::connectDatabase();
    //         $string = "'".implode("','",array_keys($array))."'";
    //         $sql = "SELECT * from products WHERE id IN (".$string.")";
    //         $output = DataRepository::readData($conn, $sql);
    //         mysqli_close($conn);
    //         return $output;
    //     }
    
    //     private static function getProductById($id) {
    //         $conn = DataRepository::connectDatabase();
    //         $sql = "SELECT * from products WHERE id='".$id."'";
    //         $items = DataRepository::readData($conn, $sql);
    //         $values = array_values($items);
    //         $output = $values[0];
    //         mysqli_close($conn);
    //         return $output;
    //     }

    //     private static function getCartContent ($productArray) {
    //         $output = $productArray;
    //         foreach($_SESSION['cart'] as $id => $count) {
    //             $output[$id]['count']=$count;
    //         }
    //         return $output;
    //     }

    // }

    class User {
        public static function storeUser($input) {
            $conn = DataRepository::connectDatabase();
            $username = Utils::cleanSQLInput($conn, $input['uname']['value']);
            $password = Utils::cleanSQLInput($conn, $input['pword']['value']);
            $email = Utils::cleanSQLInput($conn, $input['email']['value']);
            $sql = "INSERT INTO users (email, username, password) VALUES ('".$email."','".$username."','".$password."')";
            DataRepository::writeData($conn, $sql);
            mysqli_close($conn);
        }
    
        public static function updatePassword($input) {
            $conn = DataRepository::connectDatabase();
            $email = Utils::cleanSQLInput($conn, $input['email']['value']);
            $password = Utils::cleanSQLInput($conn, $input['password']['value']);
            $sql = "UPDATE users SET password='".$password."' WHERE email='".$email."'";
            DataRepository::updateData($conn, $sql);
            mysqli_close($conn);
        }    
    
        public static function doesEmailExist($email) {
            $userInfo = self::findUserByEmail($email);
            return !empty($userInfo);
        }

        public static function findUserByEmail($email) {      
            $conn = DataRepository::connectDatabase();
            try { 
                $sql = "SELECT * from users WHERE email = '" . $email . "'";
                $output = DataRepository::readData($conn, $sql);
                return empty($output) ? NULL : array_shift($output); 
            }
            finally {
                mysqli_close($conn);        
            }
        }
    }

    