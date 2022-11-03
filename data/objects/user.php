<?php

    class User {
        public $id;
        public $email;
        public $username;
        public $password; // Moet deze (of allemaal) private?

        // public function __construct($id = "", $email = "", $username = "", $password = "") {
        //         $this->id = $id;
        //         $this->email = $email;
        //         $this->username = $username;
        //         $this->password = $password;
        //     }
            
        public function getId() {
            return $this->id;
        }

        public function getEmail() {
            return $this->email;
        }

        public function getUsername() {
            return $this->username;
        }

        public function getPassword() {
            return $this->password;
        }
        

        
    }