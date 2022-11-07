<?php
/**
 * @author Geert Weggemans - geert@man-kind.nl
 * @date jan 8 2020
 */
require_once("models/objects/FieldInfo.php");
require_once("models/validations/BaseInputField.php");
class EmailField extends BaseInputField
{
	
    public function __construct(FieldInfo $fieldinfo)
    {
        parent::__construct($fieldinfo);
        $this->filter = FILTER_VALIDATE_EMAIL;
        $this->flags = FILTER_FLAG_EMAIL_UNICODE;
        $this->empty_err = "E-Mail address is required";
        $this->value_err = "Please enter a correct e-mail address";
    }
}