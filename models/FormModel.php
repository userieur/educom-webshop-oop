<?php

    class FormModel extends UserModel {
            public $form = [];

            public function __construct($pageModel, $crud) {
                PARENT::__construct($pageModel, $crud);
                $this->crud = $crud;
            }

            public function getForm($page) {
                switch($page) {
                    case 'contact':
                        $formArray = ['validForm' => false, 'css' => "contactform",
                        'sex' => self::getFormLine(key:'sex', type:'select', label:'Aanhef:', placeholder:'Kies', options:['man|Dhr', 'woman|Mevr']),
                        'fname' => self::getFormLine(key:'fname', type:'text', label:'Voornaam:', placeholder:'Jan', checks:[VALIDATE_NAME]),
                        'lname' => self::getFormLine(key:'lname', type:'text', label:'Achternaam:', placeholder:'van der Steen', checks:[VALIDATE_NAME]),
                        'email' => self::getFormLine(key:'email', type:'email', label:'E-Mail:', placeholder:'jan.v.d.steen@provider.com', checks:[VALIDATE_EMAIL]),
                        'phone' => self::getFormLine(key:'phone', type:'phone', label:'Telefoon:', placeholder:'0612345678 / 0101234567', checks:[VALIDATE_PHONE]),
                        'pref' => self::getFormLine(key:'pref', type:'radio', label:'Ik word het liefst benaderd via:', options:['tel|Telefoon','mail|E-Mail']),
                        'story' => self::getFormLine(key:'story', type:'textbox', label:'Reden van contact:', placeholder:'Vul hier iets in')];
                        break;
                    case 'registratie': 
                        $formArray = ['validForm' => false, 'css' => "contactform",
                        'uname' => self::getFormLine(key:'uname', type:'text', label:'Gebruikersnaam:', placeholder:'Kies', checks:[VALIDATE_NAME]),
                        'email' => self::getFormLine(key:'email', type:'text', label:'E-mail:', placeholder:'j.v.d.steen@provider.com', checks:[VALIDATE_EMAIL, USER_EMAIL_NOT_KNOWN]),
                        'pword' => self::getFormLine(key:'pword', type:'password', label:'Wachtwoord:', placeholder:'vul wachtwoord in', checks:[VALIDATE_PASSWORD]),
                        'pwordcheck' => self::getFormLine(key:'pwordcheck', type:'password', label:'Herhaal wachtwoord:', placeholder:'herhaal wachtwoord', checks:[VALIDATE_PASSWORD_EQUAL_ENTRY])];
                        break;
                    case 'login':
                        $formArray = ['validForm' => false, 'css' => "contactform",
                        'email' => self::getFormLine(key:'email', type:'text', label:'E-mail:', placeholder:'j.v.d.steen@provider.com', checks:[VALIDATE_EMAIL]),
                        'pword' => self::getFormLine(key:'pword', type:'password', label:'Wachtwoord:', placeholder:'vul wachtwoord in', checks:[VALIDATE_PASSWORD])];
                        break;
                    case 'userpage':
                        $formArray = ['validForm' => false, 'css' => "contactform",
                        'opword' => self::getFormLine(key:'opword', type:'password', label:'Oude wachtwoord:', placeholder:'vul wachtwoord in', checks:[VALIDATE_PASSWORD]),
                        'pword' => self::getFormLine(key:'pword', type:'password', label:'Nieuwe Wachtwoord:', placeholder:'vul wachtwoord in', checks:[VALIDATE_PASSWORD]),
                        'pwordcheck' => self::getFormLine(key:'pwordcheck', type:'password', label:'Herhaal nieuwe wachtwoord:', placeholder:'herhaal wachtwoord', checks:[VALIDATE_PASSWORD_EQUAL_ENTRY])];
                        break;
                    default:
                        break;
                }
                return $formArray;
            }
    
            private function getFormLine(string $key, string $type, string $label, string $placeholder="", $options=array(), $checks=array()) {
                $options = self::splitOptions($options);
                return ['key' => $key, 'type' => $type, 'label' => $label, 'placeholder' => $placeholder, 'options' => $options, 'checks' => $checks];
            }
    
            private function splitOptions (array $options) {
                $output = [];
                foreach($options as $option) {
                    $array = explode("|", $option);
                    $output += [$array[0] => $array[1]];
                }
                return $output;
            }
        }