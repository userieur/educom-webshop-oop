<?php

class BaseValidate {

    protected $value;
    protected $error = NULL;
    protected $no_err = true;

    public function __construct($value)
    {
        $this->value = $value;
        $this->validate();
    }

    protected function validate()
    {
        $this->cleanInput();
        $this->validateInput();
    }

    protected function cleanInput()
    {
        $this->value = trim($this->value);
        $this->value = stripslashes($this->value);
        $this->value = htmlspecialchars($this->value);
    }
    
    protected function validateInput()
    {
        // empty for standard
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getError()
    {
        return $this->error;
    }

    public function getNoErr()
    {
        return $this->no_err;
    }
}       