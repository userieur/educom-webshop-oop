<?php
foreach(glob("models/validations/*") as $filename)
{
    include_once $filename;
}
require_once("FormField.php");

abstract class BaseForm
{ 
    public function validate()
    {
        $this->validateInput();
    }
//==============================================================================
    private function validateInput() 
    {
        foreach($this->formFields as $key => $formField)
        {
            $validated = $this->validateFactory($formField);
            $this->formFields[$key]->setValue($validated->getValue());
            if (!$validated->getNoErr())
            {
                $this->formFields[$key]->setError($validated->getError());
                $this->setValidForm(false);
            }
        }
    }
//==============================================================================  
    private function validateFactory($field)
    {
        $check = $field->getCheck();
        $key = $field->getKey();
        if ($check)
        {
            switch ($check)
            {
                case VALIDATE_NAME:
                    $validated = new NameValidate($_POST[$key]);
                    break;
                case VALIDATE_PHONE:
                    $validated = new PhoneValidate($_POST[$key]);
                    break;
                case VALIDATE_EMAIL:
                    $validated = new EmailValidate($_POST[$key]);
                    break;
                case VALIDATE_PASSWORD:
                    $validated = new PasswordValidate($_POST[$key]);
                    break;
                case VALIDATE_PASSWORD_EQUAL_ENTRY:
                    $validated = new EqualToInput($_POST[$key], 'pword');
                    break;
            }
        }
        else
        {
             $validated = new BaseValidate($_POST[$key]);
        }
        return $validated;
    }
//==============================================================================  
    public function getCss()
    {
        return $this->css;
    }
//==============================================================================  
    public function getValidForm()
    {
        return $this->validForm;
    }
//==============================================================================  
    public function setValidForm($validForm) : void
    {
        $this->validForm = $validForm;
    }
//==============================================================================  
    public function getFormFields()
    {
        return $this->formFields;
    }

}