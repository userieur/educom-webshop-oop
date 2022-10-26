<?php
    require_once("constants.php");
    require_once("data.php");

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
        $string = "'".implode("','",array_keys($array))."'";
        $sql = "SELECT * from products WHERE id IN (".$string.")";
        $output = readData($conn, $sql);
        mysqli_close($conn);
        return $output;
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

    function getCartContent ($productArray) {
        $output = $productArray;
        foreach($_SESSION['cart'] as $id => $count) {
            $output[$id]['count']=$count;
        }
        return $output;
    }


    // function getInvoiceLines() {
        
    //     $invoiceLines = []
    //     $cartContent = $_SESSION['cart'];
    //     $_SESSION['invoicelines'];
        
    // }

    function placeOrder() {
        $date = currentDate();
        $conn = connectDatabase();
        $invoiceLines = getInvoiceLines();
        $userId = $_SESSION['userId'];
                
        // Create invoice
        $sql = "INSERT INTO invoices (invoice_num) VALUES ('".$date.'0000'."')";
        $output = writeData($conn, $sql);

        $sql = "SELECT invoice_num from invoices ORDER BY invoice_num DESC LIMIT 1";
        $output = readData($conn, $sql);
        
        $invoiceNum = intval($output) + 1;
            
        $sql = "UPDATE invoices SET user_id='".$userId."', invoice_num='".$invoiceNum."') WHERE invoice_num='".$date.'0000'."')";
        updateData($conn, $sql);
        
        // Retrieve invoice ID number of created invoice from database
        $sql = "SELECT id from invoices WHERE invoice_num='".$invoiceNum."'";
        $output = readData($conn, $sql);
        
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