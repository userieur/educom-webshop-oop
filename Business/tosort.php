<?php
    require_once("constants.php");

    function getAllProducts() {
        $conn = connectDatabase();
        try { 
            $sql = $sql = "SELECT * from products";
            $items = readData($conn, $sql);
            return $items; 
        }
        finally {
            mysqli_close($conn);    
        }
    }

    function getProductsByIdArray($array) {
        $conn = connectDatabase();
        $idString = "";
        $count = 0;
        if ($array){
            foreach ($array as $id => $amount) {
                if ((count($array)-$count) > 1) {
                    $idString.="'".$id."', ";
                    $count += 1;
                } else {
                    $idString.="'".$id."'";
                }
            }
            $sql = "SELECT * from products WHERE name IN (".$idString.")";
            $output = readData($conn, $sql);
            mysqli_close($conn);
            return $output;
        }
    }

    function getProductById($id) {
        $conn = connectDatabase();
        $sql = "SELECT * from products WHERE id='".$id."'";
        $items = readData($conn, $sql);
        $values = array_values($items);
        $output = $values[0];
        mysqli_close($conn);
        return $output;
    }
       
    function storeUser($data) {
        $conn = connectDatabase();
        $input = $data['form'];
        $username = cleanSQLInput($conn, $input['uname']['value']);
        $password = cleanSQLInput($conn, $input['pword']['value']);
        $email = cleanSQLInput($conn, $input['email']['value']);
        $sql = "INSERT INTO users (email, username, password) VALUES ('".$email."','".$username."','".$password."')";
        writeData($conn, $sql);
        mysqli_close($conn);
    }

    function updatePassword($data) {
        $conn = connectDatabase();
        $input = $data['form'];
        $email = cleanSQLInput($conn, $input['email']['value']);
        $password = cleanSQLInput($conn, $input['password']['value']);
        $sql = "UPDATE users SET password='".$password."' WHERE email='".$email."'";
        updateData($conn, $sql);
        mysqli_close($conn);
    }    

    function createInvoiceNumber() {
        $date = currentDate();
        $conn = connectDatabase();
        $sql = "SELECT invoice_num from invoices ORDER BY ID DESC LIMIT 1";
        $output = readData($conn, $sql);
        
        $values = array_values($output);
        $string = $values[0]['invoice_num'];

        if (str_contains($string, $date)) {
            $count = substr($string, -4);
            $int = intval($count);
            $int += 1;
            $count = str_pad(strval($int), 4, '0', STR_PAD_LEFT);
            $invoiceNumber = $date.$count;
        } else {
            $invoiceNumber = $date."0001";
        }
        echo($invoiceNumber);
        return $invoiceNumber;
    }

    function placeOrder() {
        $conn = connectDatabase();
        $invoiceLines = $_SESSION['invoicelines'];
        $userId = $_SESSION['userId'];
        $invoiceNum = createInvoiceNumber();
        
        // Create invoice
        $sql = "INSERT INTO invoices (user_id, invoice_num) VALUES ('".$userId."', '".$invoiceNum."')";
        writeData($conn, $sql);
        
        // Retrieve invoice number of created invoice from database
        $sql = "SELECT id from invoices ORDER BY ID DESC LIMIT 1";
        $output = readData($conn, $sql);
        
        $values = array_values($output);
        $invoiceId = $values[0]['id'];

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
            writeData($conn, $sql);
        }

        mysqli_close($conn);
    }

   
    function findUserByEmail($email) {      
        $conn = connectDatabase();
        try { 
            $sql = "SELECT * from users WHERE email = '" . $email . "'";
            $output = readData($conn, $sql);
            return empty($output) ? NULL : array_shift($output); 
        }
        finally {
            mysqli_close($conn);        
        }
    }