<?php

    class User {
        protected $id;
        protected $email;
        protected $username;
        protected $password; // Moet deze (of allemaal) private?

        public function getId() {
            return $this->id;
        }

        public function getEmail() {
            return $this->email;
        }

        public function setEmail($email) {
            $this->email = $email;
        }

        public function getUsername() {
            return $this->username;
        }

        public function setUsername($username) {
            $this->username = $username;
        }

        public function getPassword() {
            return $this->password;
        }

        public function setPassword($password) {
            $this->password = $password;
        }
    }