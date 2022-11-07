<?php

class PasswordValidate extends BaseValidate {

    public function __construct($value)
    {
        PARENT::__construct($value);
    }
         
    protected function validateInput()
    {
        if (empty($this->value)) 
        {
            $this->error = "Please enter a password";
            $this->no_err = false;
        }
        elseif (!preg_match("/^[a-zA-Z-' ]*$/",$this->value))
        {
            $this->error = "Only letters and white space allowed";
            $this->no_err = false; 
        }
    }
}