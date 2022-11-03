<?php 
    require_once("data/objects/user.php");

    class UserCrud {

        private $crud;

        function __construct($crud) {
            $this->crud = $crud;
        }

        function createUser(User $user) {
            $sql = "INSERT INTO users (email, username, password) VALUES (:email, :username, :password)";
            $params = array('password'  => $user->password, 
                            'email'     => $user->email,
                            'username'  => $user->username);
            $new_id = $this->crud->createRow($sql, $params);
            return $new_id;
        }

        function findUserByEmail($email) {
            $sql = "SELECT * FROM users WHERE email = :email";
            $params = array('email' => $email);
            return $this->crud->readOneRow($sql, $params, 'User');
            }

        function updateUser(int $id, User $user) {
            $sql = "UPDATE users SET password= :password WHERE email= :email";
            $params = array('password' => $user->password, 'email' => $user->email);
            $this->crud->updateRow($sql, $params);
        }

        function deleteUser(int $id) {

        }
    

        // public function storeUser($input) {
        //     $conn = DataRepository::connectDatabase();
        //     $username = Utils::cleanSQLInput($conn, $input['uname']['value']);
        //     $password = Utils::cleanSQLInput($conn, $input['pword']['value']);
        //     $email = Utils::cleanSQLInput($conn, $input['email']['value']);
        //     $sql = "INSERT INTO users (email, username, password) VALUES ('".$email."','".$username."','".$password."')";
        //     DataRepository::writeData($conn, $sql);
        //     mysqli_close($conn);
        // }
    
        // public function updatePassword($pword) {
        //     $conn = DataRepository::connectDatabase();
        //     $email = Utils::cleanSQLInput($conn, $_SESSION['email']);
        //     $password = Utils::cleanSQLInput($conn, $pword);
        //     $sql = "UPDATE users SET password='".$password."' WHERE email='".$email."'";
        //     DataRepository::updateData($conn, $sql);
        //     mysqli_close($conn);
        // }   

    }