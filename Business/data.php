<?php

    class DataRepository {

        static function connectDatabase($dbname="r_webshop") {
            $servername = "127.0.0.1";
            $username = "r_webshop_usr";
            $password = "Z6zFwtYvjGGq5Y";
            $dbname = $dbname;
    
            $conn = mysqli_connect($servername, $username, $password, $dbname);
    
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
                }
            return $conn;
        }
    
        static function readData($conn, $sql) {
            $output = array();
            $result = mysqli_query($conn, $sql);
    
            while($row = mysqli_fetch_assoc($result)) {
                if (isset($row['id'])) {
                    $output[$row['id']] = $row;
                } else {
                    $output[] = $row;
                }
            }
            return $output;
        }
    
        static function writeData($conn, $sql) {
            if (!mysqli_query($conn, $sql)) {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn); // Exception
            }
        }
    
        static function updateData($conn, $sql) {
            if (!mysqli_query($conn, $sql)) {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn); // Exception
            }
        }
    }


