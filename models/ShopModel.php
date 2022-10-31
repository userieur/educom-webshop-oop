<?php
    require_once("./Business/session.php");
    require_once("./Business/data.php");

    class ShopModel extends PageModel {
        public $products = [];
        public $productsClass = NULL;

        public function __construct($pageModel) {
            PARENT::__construct($pageModel);
            $items = $this->getItems();
            $this->products = $items['products'];
            $this->productsClass = $items['class'];
        }

        public function getItems() {
            switch ($this->page) {
                case 'webshop':
                    $output['products'] = self::getAllProducts();
                    $output['class'] = "";
                    break;
                case 'detail':
                    $id = Utils::getVar('id');
                    $output['products'][$id] = self::getProductById($id);
                    $output['class'] = "big";
                    break;
                case 'cart':
                    $output['products'] = self::getProductsByIdArray($_SESSION['cart']);
                    $output['products'] = self::getCartContent($output['products']);
                    $output['class'] = "cart";
                    break;
            }
            return $output ?? NULL;
        }

        public function handleActions() {
            $id = Utils::getVar('id');
            $action = Utils::getVar("action");
            switch($action) {
                case ACTION_ADD_TO_CART:
                    if (array_key_exists($id, $_SESSION['cart'])) {
                        $_SESSION['cart'][$id] += 1; 
                    } else {
                        $_SESSION['cart'] += [$id => 1];
                    }
                    break;
                case ACTION_REMOVE_FROM_CART:
                    if (!isset($_SESSION['cart'][$id])) {
                        // do nothing;
                    } elseif ($_SESSION['cart'][$id] == 1) {
                        unset($_SESSION['cart'][$id]); 
                    } else {
                        $_SESSION['cart'][$id] -= 1;
                    }
                    break;
                    // CASE ITEM WEG => unset
                case ACTION_ORDER:
                    if ($_SESSION['cart']) {
                        self::placeOrder();
                        $_SESSION['cart'] = [];
                    } else {
                        echo 'Mandje is leeg G'; 
                    }
                    break;
            }
        }

        private function placeOrder() {
            $date = Utils::currentDate();
            $conn = DataRepository::connectDatabase();
            $userId = $_SESSION['userId'];
            $invoiceLines = [];    

            // Create invoice
            $sql = "INSERT INTO invoices (invoice_num) VALUES ('".$date.'0000'."')";
            $output = DataRepository::writeData($conn, $sql);
    
            $sql = "SELECT invoice_num from invoices ORDER BY invoice_num DESC LIMIT 1";
            $output = DataRepository::readData($conn, $sql);
            
            $invoiceNum = intval($output) + 1;
                
            $sql = "UPDATE invoices SET user_id='".$userId."', invoice_num='".$invoiceNum."') WHERE invoice_num='".$date.'0000'."')";
            DataRepository::updateData($conn, $sql);
            
            // Retrieve invoice ID number of created invoice from database
            $sql = "SELECT id from invoices WHERE invoice_num='".$invoiceNum."'";
            $output = DataRepository::readData($conn, $sql);
            
            $invoiceId = array_shift($output);
    
            // Create SQL-strings for each invoice-line and insert them in invoice_lines database
            foreach ($invoiceLines as $line) {
                $columnString = "invoice_id, ";
                $valueString = "'".$invoiceId."', ";
                $count = 0;
                foreach ($line as $column => $value) {
                    if ((count($line)-$count) > 1) {
                        $columnString.=$column.", ";
                        $valueString.="'".$value."', ";
                        $count += 1;
                    } else {
                        $columnString.=$column;
                        $valueString.="'".$value."'";
                    }
                }
                $sql = "INSERT INTO invoice_lines (".$columnString.") VALUES (".$valueString.")";
                DataRepository::writeData($conn, $sql);
            }
            mysqli_close($conn);
        }

        private function getAllProducts() {
            $conn = DataRepository::connectDatabase();
            try { 
                $sql = $sql = "SELECT * from products";
                $items = DataRepository::readData($conn, $sql);
                return $items; 
            }
            finally {
                mysqli_close($conn);    
            }
        }
    
        private function getProductsByIdArray($array) {
            $conn = DataRepository::connectDatabase();
            $string = "'".implode("','",array_keys($array))."'";
            $sql = "SELECT * from products WHERE id IN (".$string.")";
            $output = DataRepository::readData($conn, $sql);
            mysqli_close($conn);
            return $output;
        }
    
        private function getProductById($id) {
            $conn = DataRepository::connectDatabase();
            $sql = "SELECT * from products WHERE id='".$id."'";
            $items = DataRepository::readData($conn, $sql);
            $values = array_values($items);
            $output = $values[0];
            mysqli_close($conn);
            return $output;
        }

        private function getCartContent ($productArray) {
            $output = $productArray;
            foreach($_SESSION['cart'] as $id => $count) {
                $output[$id]['count']=$count;
            }
            return $output;
        }

    }
