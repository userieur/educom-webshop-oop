<?php

require_once("models/objects/FieldInfo.php");
abstract class BaseField
{
    protected           $info;
    protected string    $id;
    protected mixed     $value;
    protected string    $error_msg;
    protected int       $filter;
    protected array|int $flags;
    protected bool      $readonly;
    protected string    $css_classes;
//==============================================================================
    public function __construct(FieldInfo $fieldinfo)
    {
        $this->info      = $fieldinfo; 
        $this->id        = 'id_'.$fieldinfo->name;
        $this->error_msg = '';
        $this->value     = '';
        $this->filter    = FILTER_DEFAULT;
        $this->flags     = FILTER_FLAG_NO_ENCODE_QUOTES;      
        $this->empty_err = "This field is required.";
        $this->value_err = "Value is invalid";
    }
//==============================================================================
    public function validate() : bool
    {
        $result = false;
        $this->error_msg = '';
        $this->value = filter_input(INPUT_POST,$this->info->name,$this->filter, $this->flags);
        if (is_null($this->value)) // Not found
        {
            $this->error_msg = $this->info->name.' not found.';
        }
        elseif ($this->value===false) // Filter failed
        {    
            $this->error_msg = $this->value_err;
        }				
        else
        {
            $this->value = trim($this->value);
            if (empty($this->value) && $this->info->required)
            {
                $this->error_msg = $this->empty_err;
            }    
            else
            {
                $result = true;
            }    
        }
        return $result;
    }
//==============================================================================  
}