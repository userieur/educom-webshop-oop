<?php


    class Crud {
        private $pdo;
        private $stmt;
        private $servername = "127.0.0.1";
        private $username   = "r_webshop_usr";
        private $password   = "Z6zFwtYvjGGq5Y";
        private $dbname     = "r_webshop";

        public function __construct() {
            try {
                $this->pdo = new PDO("mysql:host=".$this->servername.";dbname=".$this->dbname, $this->username, $this->password);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    // do something; this->model->err?
                }

        }

        public function getPDO() {
            return $this->pdo;
        }

        private function prepareAndBind($sql, $bindParameters) {
            $this->stmt = $this->pdo->prepare($sql);
            foreach ($bindParameters as $key => $value) {
                $this->stmt->bindValue($key, $value);
            }
            $this->stmt->setFetchMode(PDO::FETCH_CLASS);


            // INSERT/DELETE/UPDATE bovenstaande voldoene
            // return $pdo -> lastInsertId();
            
            // SELECT
            //icm setFetchMode 
            // $result = $stmt -> fetch();
            // $result = $stmt -> fetch_all();
        }
     
        function createRow($sql, $params) {
            $this->prepareAndBind($sql, $params);
            $this->stmt->execute();
            $last_id = $this->pdo->lastInsertId();
            return $last_id;
        }
        
        function readOneRow($sql, $params) {
            $stmt = $this->prepareAndBind($sql, $params);
            $stmt->setFetchMode(PDO::FETCH_CLASS);
        }

        function readMultipleRows($sql, $params) {
            $stmt = $this->prepareAndBind($sql, $params);
            $stmt->setFetchMode(PDO::FETCH_CLASS);
        }

        function updateRow($sql, $params) {
            $stmt = $this->prepareAndBind($sql, $params);
            $stmt->execute();
        }

        function deleteRow($sql, $params) {
            $stmt = $this->prepareAndBind($sql, $params);
            $stmt->execute();
        }

    }