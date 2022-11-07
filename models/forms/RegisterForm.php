<?php

class RegisterForm extends BaseForm
{
    protected $css; // is string
    protected $validForm; //is boolean
    public $formFields; //is array of objects FormField

    public function __construct() {
        $this->css = "contactform";
        $this->validForm = true;
        $this->formFields = [];
        $this->buildForm();
    }

    private function buildForm()
    {
        $this->formFields = 
        [
            'uname' => new FormField(key:'uname', type:'text', label:'Gebruikersnaam:', placeholder:'Kies', check:VALIDATE_NAME),
            'email' => new FormField(key:'email', type:'email', label:'E-Mail:', placeholder:'jan.v.d.steen@provider.com', check:VALIDATE_EMAIL),
            'pword' => new FormField(key:'pword', type:'password', label:'Wachtwoord:', placeholder:'vul wachtwoord in', check:VALIDATE_PASSWORD),
            'pwordcheck' => new FormField(key:'pwordcheck', type:'password', label:'Herhaal wachtwoord:', placeholder:'herhaal wachtwoord', check:VALIDATE_PASSWORD_EQUAL_ENTRY)
        ];
    }
}