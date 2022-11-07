<?php 
    require_once("data/objects/invoice.php");
    require_once("data/objects/invoiceline.php");
    require_once("data/objects/product.php");

    class ShopCrud { 

        private $crud;

        function __construct($crud) {
            $this->crud = $crud;
        }

        function  createProduct($product) {

        }

        function createOrder(Order $order) {     
            $date = Utils::currentDate();

            // var_dump($order);

            // Create invoice for invoice_num & invoice_id
            $sql = "INSERT INTO invoices (invoice_num, user_id) VALUES (:invoice_num, :user_id)";
            $params = array('invoice_num' => $date.'0000',
                            'user_id' => $order->invoice->getUserId());
            $order->invoice->setId($this->crud->createRow($sql, $params));

            // Update invoice_num to be latest in the table
            // Select the highest invoice_num currently in table
            $sql = "SELECT * FROM invoices ORDER BY invoice_num DESC LIMIT 1";
            $params = array();
            $temp_num = $this->crud->readOneRow($sql, $params, 'invoice');

            // Add + 1 and set invoice_num to order->invoice
            $invoice_num = intval($temp_num->invoice_num) + 1;
            $order->invoice->setInvoiceNum($invoice_num);

            // Update invoice
            $sql = "UPDATE invoices SET invoice_num=:invoice_num WHERE invoice_num=:old";
            $params = array('invoice_num' => $order->invoice->getInvoiceNum(),
                            'old' => $date.'0000');
            $this->crud->updateRow($sql, $params);

            // Create all the invoicelines in the table
            foreach ($order->invoiceLines as $key => $invoiceline)
            {
                $sql = "INSERT INTO invoice_lines (invoice_id, article_id, sales_amount, sales_price) VALUES (:invoice_id, :article_id, :sales_amount, :sales_price)";
                $params = array('invoice_id'     => $order->invoice->getId(), 
                                'article_id'     => $invoiceline->getArticleId(),
                                'sales_amount'   => $invoiceline->getSalesAmount(),
                                'sales_price'    => $invoiceline->getSalesPrice());
                $returned = $this->crud->createRow($sql, $params);
                $order->invoiceLines[$key]->setId($returned);
                $order->invoiceLines[$key]->setInvoiceId($order->invoice->getId());
                $order->invoiceLines[$returned] = $order->invoiceLines[$key];
                unset($order->invoiceLines[$key]);
            }
            return $order;
        }

        function readAllProducts() {
            $sql = "SELECT * FROM products";
            $params = array();
            return $this->crud->readMultipleRows($sql, $params, 'Product');
        }

        function readManyProducts($array) {
            $sql = "SELECT * FROM products WHERE id IN (:id)";
            $params = array('id' => $array);
            return $this->crud->readMultipleRows($sql, $params, 'Product');
        }

        function readProductWithId($id) {
            $sql = "SELECT * FROM products WHERE id = :id";
            $params = array('id' => $id);
            return $this->crud->readOneRow($sql, $params, 'Product');
        }


}