<?php

class NameValidate extends BaseValidate {

    public function __construct($value)
    {
        PARENT::__construct($value);
    }
         
    protected function validateInput()
    {
        if (empty($this->value)) 
        {
            $this->error =  "Name is required";
            $this->no_err = false;
        }
        elseif (!preg_match("/^[a-zA-Z-' ]*$/",$this->value))
        {
            $this->error = "Only letters and white space allowed";
            $this->no_err = false; 
        }
    }
}       