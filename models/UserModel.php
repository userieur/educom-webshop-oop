<?php

    class UserModel extends PageModel {
        public $email = '';  // or $meta = array();
        public $name = '';  // of $values = array();
        public $password = '';
        public $emailErr = '';     
        private $userId = 0;
        public $valid = false;

        public function __construct($pageModel) {
            PARENT::__construct($pageModel);
        }

        public function validateLogin() {
            $this->valid = true;
            }

        private function authenticateUser() {
            require_once "db_repositor.php";
            $user = findUserByEmail($this->email);
            // password validatie

            $this->name = $user['name']; 
            // $this->values['name'] = $user['name'];
            $this->userId = $user['id'];
        }

        public function doLoginUser() {
            $this->sessionManager->doLoginUser($this->name, $this->userId);
            $this->genericErr = "Login successvol";
            // $this->errors['genericError'] = "Login successvol";
        }

    }


