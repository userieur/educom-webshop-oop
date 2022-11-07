<?php

class EmailValidate extends BaseValidate {

    public function __construct($value)
    {
        PARENT::__construct($value);
    }
         
    protected function validateInput()
    {
        if (empty($this->value)) 
        {
            $this->error = "E-mail address is required";
            $this->no_err = false;
        }
        elseif (!filter_var($this->value, FILTER_VALIDATE_EMAIL))
        {
            $this->error = "Please enter a correct e-mail address";
            $this->no_err = false; 
        }
    }
}       