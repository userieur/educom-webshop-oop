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

        private function prepareAndBind($sql, $bindParameters) {
            // var_dump($sql);
            // var_dump($bindParameters);
            $this->stmt = $this->pdo->prepare($sql);
            foreach ($bindParameters as $key => $value) {
                $this->stmt->bindValue($key, $value);
            }
        }
     
        function createRow($sql, $params) {
            $this->prepareAndBind($sql, $params);
            // var_dump($this->stmt);
            $this->stmt->execute();
            $last_id = $this->pdo->lastInsertId();
            return $last_id;
        }
        
        function readOneRow($sql, $params, $className) {
            $this->prepareAndBind($sql, $params);
            $this->stmt->setFetchMode(PDO::FETCH_CLASS, $className);
            $this->stmt->execute();
            $result = $this->stmt->fetch();
            return $result;
        }

        function readMultipleRows($sql, $params, $className) {
            $this->prepareAndBind($sql, $params);
            $this->stmt->setFetchMode(PDO::FETCH_CLASS, $className);
            $this->stmt->execute();
            // Stukje over loopen
            $result = $this->stmt->fetch();
            return $result;
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