<?php

class LoginForm extends BaseForm
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
            'email' => new FormField(key:'email', type:'email', label:'E-Mail:', placeholder:'jan.v.d.steen@provider.com', check:VALIDATE_EMAIL),
            'pword' => new FormField(key:'pword', type:'password', label:'Voer wachtwoord in:', placeholder:'herhaal wachtwoord', check:VALIDATE_PASSWORD)
        ];
    }
}