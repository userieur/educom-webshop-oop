<?php

class PhoneValidate extends BaseValidate {

    public function __construct($value)
    {
        PARENT::__construct($value);
    }
         
    protected function validateInput()
    {
        if (empty($this->value)) 
        {
            $this->error = "Phone is required";;
            $this->no_err = false;
        }
        elseif (!is_numeric($this->value))
        {
            $this->error = "Please enter a correct phone number";
            $this->no_err = false; 
        }
    }
}       