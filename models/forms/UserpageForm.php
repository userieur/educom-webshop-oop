<?php

class UserpageForm extends BaseForm
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
            'opword' => new FormField(key:'opword', type:'password', label:'Oude wachtwoord:', placeholder:'vul wachtwoord in', check:VALIDATE_PASSWORD),
            'pword' => new FormField(key:'pword', type:'password', label:'Nieuwe Wachtwoord:', placeholder:'vul wachtwoord in', check:VALIDATE_PASSWORD),
            'pwordcheck' => new FormField(key:'pwordcheck', type:'password', label:'Herhaal wachtwoord:', placeholder:'herhaal wachtwoord', check:VALIDATE_PASSWORD_EQUAL_ENTRY)
        ];
    }
}