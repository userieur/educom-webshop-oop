<?php
    require_once("session.php");
    require_once("utils.php");
    require_once("data/CrudUser.php");

    class UserModel extends PageModel {
        public $form = [];
        public $user = [];

        public function __construct($pageModel, $crud) {
            PARENT::__construct($pageModel, $crud);
            $this->crud = $crud;
        }

        public function doLoginUser() {
            $this->sessionManager->doLoginUser($this->user);
        }

        public function doLogoutUser() {
            $this->sessionManager->doLogoutUser();
        }

        public function authenticateUser() {
            if (empty($this->form['email']['error'])) {
                $userInfo = $this->crud->findUserByEmail($this->form['email']['value']);
                // var_dump($userInfo);
            } else {return NULL;}

            if (empty($userInfo)) {
                $this->form['email']['error'] = "E-Mail not found";
                $this->form['validForm'] = false;
            } elseif (!empty($userInfo) && ($this->form['pword']['value'] != Utils::cleanInput($userInfo->password))) {
                $this->form['pword']['error'] = "Password incorrect";
            } else {
                $this->user = $userInfo;
                return true;
            }
            return NULL;
        }

        public function doesEmailExist($email) {
            $userInfo = $this->crud->findUserByEmail($email);
            return !empty($userInfo);
        }

        private function emailNotKnown($value) {
            $exists = User::doesEmailExist($value);
            if ($exists) {
                $error = "E-Mail already exists";
            }
            return $error ?? NULL;
        }
    
        private function emailKnown($value) {
            $exists = User::doesEmailExist($value);
            if (!$exists) {
                $error = "E-Mail not known";
            }
            return $error ?? NULL;
        }


    }


