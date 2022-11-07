<?php
include_once("BaseForm.php");

class ContactForm extends BaseForm
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
            'sex'   => new FormField(key:'sex', type:'select', label:'Aanhef:', placeholder:'Kies', options:['man|Dhr', 'woman|Mevr']),
            'fname' => new FormField(key:'fname', type:'text', label:'Voornaam:', placeholder:'Jan', check:VALIDATE_NAME),
            'lname' => new FormField(key:'lname', type:'text', label:'Achternaam:', placeholder:'van der Steen', check:VALIDATE_NAME),
            'email' => new FormField(key:'email', type:'email', label:'E-Mail:', placeholder:'jan.v.d.steen@provider.com', check:VALIDATE_EMAIL),
            'phone' => new FormField(key:'phone', type:'phone', label:'Telefoon:', placeholder:'0612345678 / 0101234567', check:VALIDATE_PHONE),
            'pref'  => new FormField(key:'pref', type:'radio', label:'Ik word het liefst benaderd via:', options:['tel|Telefoon','mail|E-Mail']),
            'story' => new FormField(key:'story', type:'textbox', label:'Reden van contact:', placeholder:'Vul hier iets in')
        ];
    }
}
