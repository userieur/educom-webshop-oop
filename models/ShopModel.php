<?php

    class ShopModel extends PageModel {
        public $products = [];
        public $productsClass = NULL;

        public function __construct($pageModel, $crud) {
            PARENT::__construct($pageModel, $crud);
            $this->crud = $crud;
            $this->getItems();
            // $this->products = $items['products'];
            // $this->productsClass = $items['class'];
        }



        private function getItems() {
            switch ($this->page) {
                case 'webshop':
                    $this->products = $this->getAllProducts();
                    $this->productsClass = "";
                    break;
                case 'detail':
                    $id = Utils::getVar('id');
                    $this->products[$id] = $this->getProductById($id);
                    $this->productsClass = "big";
                    break;
                case 'cart':
                    $products = $this->getProductsByIdArray($this->sessionManager->getCart());
                    // var_dump($products);
                    $this->products = $this->addCartItemCount($products);
                    $this->productsClass = "cart";
                    break;
            }
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
                        $this->placeOrder();
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
            return $this->crud->readAllProducts();
        }
    
        private function getProductsByIdArray($array) {
            return $this->crud->readManyProducts($array);
        }
    
        private function getProductById($id) 
        {
            return $this->crud->readProductWithId($id);
        }

        private function addCartItemCount ($productArray) {
            $output = $productArray;
            // var_dump($output);
            // var_dump($this->sessionManager->getCart());
            foreach($this->sessionManager->getCart() as $id => $count) {
                $output[$id]->count=$count;
            }
            return $output;
        }

    }
