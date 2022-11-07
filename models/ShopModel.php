<?php
    require_once("data/objects/invoice.php");
    require_once("data/objects/order.php");

    class ShopModel extends PageModel {
        public $products = [];
        public $productsClass = NULL;
        public $order;

        public function __construct($pageModel, $crud) {
            PARENT::__construct($pageModel, $crud);
            $this->crud = $crud;
            $invoice = new Invoice();
            $this->order = new Order($invoice);
            $this->handleActions();
            $this->getItems();
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
                    if ($this->sessionManager->getCart())
                    {
                        $this->products = $this->getProductsByIdArray($this->sessionManager->getCart());
                        $this->addCartItemCount();
                        $this->createInvoiceLines();
                        $this->productsClass = "cart";
                    }
                    break;
            }
            $this->addCartItemCount();
        }

        public function handleActions() {
            $id = Utils::getVar('id');
            $action = Utils::getVar("action");
            $count = $this->sessionManager->getCartItemCount($id) ?? Null;
            switch($action) {
                case ACTION_ADD_TO_CART:
                    if ($count) {
                        $count += 1;
                    } else {$count = 1;}
                    $this->sessionManager->setCartItemCount($id, $count);
                    break;
                case ACTION_REMOVE_FROM_CART:
                    if ($count && $count == 1) {
                        $this->sessionManager->removeCartItem($id);
                    } else {
                        $count -= 1;
                        echo($count);
                        $this->sessionManager->setCartItemCount($id, $count);
                    }
                    break;
                case ACTION_ORDER:
                    if ($this->sessionManager->getCart()) {
                        $this->products = $this->getProductsByIdArray($this->sessionManager->getCart());
                        $this->addCartItemCount();
                        $this->createInvoiceLines();
                        $this->placeOrder();
                        $this->sessionManager->emptyCart();
                        $this->products = [];
                    }
                    break;
            }
        }

        private function placeOrder() {
            $this->order = $this->crud->createOrder($this->order);
            var_dump($this->order);
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

        private function addCartItemCount () {
            foreach($this->sessionManager->getCart() as $id => $count) {
                $this->products[$id]->count = $count;
            }
        }

        private function createInvoiceLines () {
            $this->order->invoice->setUserId($this->sessionManager->getLoggedInUserId());
            foreach($this->products as $id => $info) {
                $invoiceline = new InvoiceLine();
                $invoiceline->setArticleId($info->id);
                $invoiceline->setSalesAmount($info->count);
                $invoiceline->setSalesPrice($info->price);
                $this->order->addInvoiceLine($invoiceline, $info->id);
            }
        }

    }
