<?php

class EqualToInput extends BaseValidate 
{
    protected $comparable = "";
    protected $key_of_comparable = "";

    public function __construct($value, $key_of_comparable)
    {
        $this->key_of_comparable = $key_of_comparable;
        PARENT::__construct($value);
    }
         
    protected function validateInput()
    {
        parent::validateInput();
        if ($this->no_err) 
        {
            $this->comparable = new BaseValidate($_POST[$this->key_of_comparable]);
            if (empty($this->value))
            {
                $this->error = "Please repeat input";
                $this->no_err = false;
            }
            elseif ($this->value != $this->comparable->getValue())
            {
                $this->error = "Input does not match";
                $this->no_err = false;
            }
        }
    }
}