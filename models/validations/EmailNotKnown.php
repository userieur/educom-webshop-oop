<?php
require_once("EmailValidate.php");

class EmailNotKnown extends EmailValidate {

    protected $crud;

    public function __construct($value, object $crud)
    {
        PARENT::__construct($value);
        $this->crud = $crud;
    }
    
    protected function validateInput()
    {
        parent::validateInput();
        if ($this->no_err) 
        {
            $userInfo = $this->crud->findUserByEmail($this->value);
            if (!empty($userInfo))
            {
                $this->error = "This e-mail has already registered";
                $this->no_err = false;
            }
        }
    }
}       