<?php
    require_once("./Business/session.php");
    require_once("./Business/utils.php");

    class UserModel extends PageModel {
        public $form = [];
        public $user = [];

        public function __construct($pageModel) {
            PARENT::__construct($pageModel);
        }

        public function doLoginUser() {
            $this->sessionManager->doLoginUser($this->user);
        }

        public function doLogoutUser() {
            $this->sessionManager->doLogoutUser();
        }

        public function authenticateUser() {
            if (empty($this->form['email']['error'])) {
                $userInfo = User::findUserByEmail($this->form['email']['value']);
            } else {
                return NULL;
            }

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
    
    }


