<?php
/**
 * @author Wil ik dit doen? - blabl@.nl / wat kan ik nog meer doen
 * @date nov 2022
 */
class FormField
{
    protected $key;
    protected $type;
    protected $label;
    protected $placeholder;
    protected $options;
    protected $check;
    protected $value = null;
    protected $error = null;
//==============================================================================  
    public function __construct(string $key, string $type, string $label, string $placeholder="", $options=array(), mixed $check="")
    {
        $this->key = $key;
        $this->type = $type;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->options = $options ? $this->splitOptions($options) : NULL;
        $this->check = $check ? : NULL;
    }
//==============================================================================  
    private function splitOptions($options)
    {
        $output = [];
        foreach($options as $option) {
            $array = explode("|", $option);
            $output += [$array[0] => $array[1]];
            }
        return $output;
    }
//==============================================================================    
    public function getKey()
    {
        return $this->key;
    }
//==============================================================================    
    public function getType()
    {
        return $this->type;
    }
//==============================================================================    
    public function getLabel()
    {
        return $this->label;
    }
//==============================================================================    
    public function getPlaceholder()
    {
        return $this->placeholder;
    }
//==============================================================================    
    public function getOptions()
    {
        return $this->options;
    }
//==============================================================================    
    public function getCheck()
    {
        return $this->check;
    }
//==============================================================================    
    public function getValue()
    {
        return $this->value;
    }
//==============================================================================    
    public function setValue($value)
    {
        $this->value = $value;
    }
//==============================================================================    
    public function getError()
    {
        return $this->error;
    }
//==============================================================================    
    public function setError($error)
    {
        $this->error = $error;
    }
}