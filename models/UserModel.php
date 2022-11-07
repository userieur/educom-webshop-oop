<?php
    require_once("session.php");
    require_once("utils.php");
    require_once("data/objects/user.php");
    require_once("data/CrudUser.php");
    require_once("models/forms/ContactForm.php");
    require_once("models/forms/RegisterForm.php");
    require_once("models/forms/LoginForm.php");
    require_once("models/forms/UserpageForm.php");

    class UserModel extends PageModel {
        public $form;
        public $user;

        public function __construct($pageModel, $crud) 
        {
            PARENT::__construct($pageModel, $crud);
            $this->getForm();
            $this->crud = $crud;
        }

        public function doLoginUser() 
        {
            $this->sessionManager->doLoginUser($this->user);
        }

        public function doLogoutUser() 
        {
            $this->sessionManager->doLogoutUser();
        }

        public function authenticateUser() 
        {
            if (empty($this->form->formFields['email']->getError())) 
            {
                $userInfo = $this->crud->findUserByEmail($this->form->formFields['email']->getValue());;
            } else {return NULL;}

            if (empty($userInfo)) 
            {
                $this->form->formFields['email']->setError("E-Mail not found");
                // $this->form->setValidForm(false);
            } 
            elseif (!empty($userInfo) && ($this->form->formFields['pword']->getValue() != $userInfo->getPassword())) 
            {
                $this->form->formFields['pword']->setError("Password incorrect");
            } 
            else 
            {
                $this->user = $userInfo;
                return true;
            }

            return NULL;
        }

        public function doesEmailExist() 
        {
            echo 'helloooo';
            if (empty($this->form->formFields['email']->getError())) 
            {
                $userInfo = $this->crud->findUserByEmail($this->form->formFields['email']->getValue());
            } else {return NULL;}

            if (!empty($userInfo)) 
            {
                $this->form->formFields['email']->setError("E-Mail is already registered");
                return true;
            }
            else {return false;}

            return NULL;
        }

        public function storeUser() 
        {
            $newUser = new User();
            $newUser->setEmail($this->form->formFields['email']->getValue());
            $newUser->setUsername($this->form->formFields['uname']->getValue());
            $newUser->setPassword($this->form->formFields['pword']->getValue());
            $newUserId = $this->crud->createUser($newUser);
        }

        public function updateUserPassword() 
        {
            $user = new User();
            $user->setEmail($this->sessionManager->getLoggedInUserEmail());
            $user->setPassword($this->form->formFields['pword']->getValue());
            $this->crud->updateUser($user);
        }

        public function getForm() {
            switch($this->page) {
                case 'contact':
                    $this->form = new ContactForm($this->crud);
                    break;
                case 'registratie': 
                    $this->form = new RegisterForm($this->crud);
                    break;
                case 'login':
                    $this->form = new LoginForm($this->crud);
                    break;
                case 'userpage':
                    $this->form = new UserpageForm($this->crud);
                    break;
                default:
                    break;
            }
        }
    }