<?php

    class Crud {
        private $pdo;
        private $stmt;
        private $servername = "127.0.0.1";
        private $username   = "r_webshop_usr";
        private $password   = "Z6zFwtYvjGGq5Y";
        private $dbname     = "r_webshop";

        public function __construct() 
        {
            try {
                $this->pdo = new PDO("mysql:host=".$this->servername.";dbname=".$this->dbname, $this->username, $this->password);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    // do something; this->model->err?
                }

        }

        private function prepareAndBind($sql, $params) 
        {
            foreach ($params as $key => $value) 
            {
                if (!is_array($value))
                {
                    continue;
                }
                else 
                {
                    $sql_replacement = '';
                    foreach($value as $index => $content)
                    {
                        $new_key = $key . "_" . $index; // creates "ids_
                        if (!empty($sql_replacement)) 
                        {
                            $sql_replacement .=  ", ";
                        }
                        $sql_replacement .= ":" . $new_key; // ":ids_0, :ids_1"
                        $params[$new_key] = $index;
                    }
                    $sql = str_replace(":" . $key, $sql_replacement, $sql);
                    unset($params[$key]);
                }
                
            }

            $this->stmt = $this->pdo->prepare($sql);
            foreach ($params as $key => $value) 
            {
                $this->stmt->bindValue($key, $value);
            }           
        }
     
        function createRow($sql, $params) 
        {
            $this->prepareAndBind($sql, $params);
            $this->stmt->execute();
            $last_id = $this->pdo->lastInsertId();
            return $last_id;
        }
        
        function readOneRow($sql, $params, $className) 
        {
            $this->prepareAndBind($sql, $params);
            $this->stmt->setFetchMode(PDO::FETCH_CLASS, $className);
            $this->stmt->execute();
            $result = $this->stmt->fetch();
            return $result;
        }

        function readMultipleRows($sql, $params, $className) 
        {
            $this->prepareAndBind($sql, $params);
            $this->stmt->setFetchMode(PDO::FETCH_CLASS, $className);
            $this->stmt->execute();
            $rows = $this->stmt->fetchAll();
            $result = [];
            foreach ($rows as $row)
            {
                $result[$row->id] = $row;
            }
            return $result;
        }

        function updateRow($sql, $params) 
        {
            $this->prepareAndBind($sql, $params);
            $this->stmt->execute();
        }

        function deleteRow($sql, $params) 
        {
            $stmt = $this->prepareAndBind($sql, $params);
            $stmt->execute();
        }

    }