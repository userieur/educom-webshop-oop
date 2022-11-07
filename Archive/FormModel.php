<?php

    class FormModel extends UserModel {
        public $form;

        public function __construct($pageModel, $crud) {
            PARENT::__construct($pageModel, $crud);
            $this->getForm();
        }

        private function getForm() {
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