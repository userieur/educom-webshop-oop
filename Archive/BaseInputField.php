<?php

require_once("models/validations/BaseField.php");
abstract class BaseInputField extends BaseField
{
    public function __construct(FieldInfo $fieldinfo)
    {
        parent::__construct($fieldinfo);
        $this->inputtype = $fieldinfo->type;
    }
//==============================================================================    

 
}
