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

        function createOrder($order) {

        }

        function readAllProducts() {
            $sql = "SELECT * FROM products";
            $params = array();
            return $this->crud->readMultipleRows($sql, $params, 'Product');
        }

        function readManyProducts($array) {
            $sql = "SELECT * FROM products WHERE id IN (:id)";
            $string = implode(",",array_keys($array));
            echo($string);
            $params = array('id' => "");
            return $this->crud->readMultipleRows($sql, $params, 'Product');
        }

        function readProductWithId($id) {
            $sql = "SELECT * FROM products WHERE id = :id";
            $params = array('id' => $id);
            return $this->crud->readOneRow($sql, $params, 'Product');
        }


}

// private function getProductsByIdArray($array) {
//     $conn = DataRepository::connectDatabase();
//     $string = "'".implode("','",array_keys($array))."'";
//     $sql = "SELECT * from products WHERE id IN (".$string.")";
//     $output = DataRepository::readData($conn, $sql);
//     mysqli_close($conn);
//     return $output;