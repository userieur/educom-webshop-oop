<?php
    require_once("session.php");
    require_once("utils.php");

    class UserModel extends PageModel {
        public $form = [];
        public $user = [];

        public function __construct($pageModel) {
            PARENT::__construct($pageModel, NULL);
        }

        public function doLoginUser() {
            $this->sessionManager->doLoginUser($this->user);
        }

        public function doLogoutUser() {
            $this->sessionManager->doLogoutUser();
        }

        public function authenticateUser() {
            if (empty($this->form['email']['error'])) {
                $userInfo = $this->findUserByEmail($this->form['email']['value']);
            } else {return NULL;}

            if (empty($userInfo)) {
                $this->form['email']['error'] = "E-Mail not found";
                $this->form['validForm'] = false;
            } elseif (!empty($userInfo) && ($this->form['pword']['value'] != Utils::cleanInput($userInfo['password']))) {
                $this->form['pword']['error'] = "Password incorrect";
            } else {
                $this->user['userName'] = $userInfo['username'];
                $this->user['email'] = $userInfo['email'];
                $this->user['userId'] = $userInfo['id'];
                return true;
            }
            return NULL;
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
    
        public function doesEmailExist($email) {
            $userInfo = self::findUserByEmail($email);
            return !empty($userInfo);
        }

        public function findUserByEmail($email) {      
            $conn = DataRepository::connectDatabase();
            try { 
                $sql = "SELECT * from users WHERE email = '" . $email . "'";
                $output = DataRepository::readData($conn, $sql);
                return empty($output) ? NULL : array_shift($output); 
            }
            finally {
                mysqli_close($conn);        
            }
        }
    }


