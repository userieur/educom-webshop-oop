<?php 

    class UserCrud {

        private $crud;

        function __construct($crud) {

        }

        function createUser(User $user) {
            $sql = "INSERT INTO users (email, username, password) VALUES (:email, :username, :password)";
            $params = array('password'  => $user->password, 
                            'email'     => $user->email,
                            'username'  => $user->username);
            $new_id = $this->crud->createRow($sql, $params);
            return $new_id;
        }

        function readUserByEmail($email) {
            $sql = "SELECT * FROM users WHERE email = :email";
            $params = array('email' => $email);
            return $this->crud->readOneRow($sql, $params);
            }

        function updateUser(int $id, User $user) {
            $sql = "UPDATE users SET password= :password WHERE email= :email";
            $params = array('password' => $user->password, 'email' => $user->email);
            $this->crud->updateRow($sql, $params);
        }

        function deleteUser(int $id) {

        }
    

    }