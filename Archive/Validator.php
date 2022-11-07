<?php

require_once("constants.php");
class Validator
{
    protected $form;
//==============================================================================  
    public function __construct($form, $crud)
    {
        $this->form = $form;
    }
//==============================================================================  
    public function validate()
    {
        $this->validateInput();
    }
//==============================================================================
    private function validateInput() 
    {
        foreach($this->form['fields'] as $field)
        {
            $validated = $this->validateFactory($field);
            $this->form['fields'][$field]['value'] = $validated->value;
            if ($validated->error)
            {
                $this->form['fields'][$field]['error'] = $validated->error;
                $this->form->validForm=false;
            }
        }
    }
//==============================================================================  
    private function validateFactory($field)
    {
        switch ($field['checks'])
        {
            case VALIDATE_NAME:
                $validated = new NameValidate($_POST[$field['key']]);
                break;
            case VALIDATE_PHONE:
                $validated = new PhoneValidate($_POST[$field['key']]);
                break;
            case VALIDATE_EMAIL:
                $validated = new EmailValidate($_POST[$field['key']]);
                break;
            case USER_EMAIL_NOT_KNOWN:
                $validated = new EmailNotKnown($_POST[$field['key']], crud: $this->crud);
                break;
            case VALIDATE_PASSWORD:
                $validated = new PasswordValidate($_POST[$field['key']]);
                break;
            case VALIDATE_PASSWORD_EQUAL_ENTRY:
                $validated = new EqualToInput($_POST[$field['key']], 'pword');
                break;
            default:
                $validated = new BaseValidate($_POST[$field['key']]);
        }
        return $validated;
    }
//==============================================================================         
}