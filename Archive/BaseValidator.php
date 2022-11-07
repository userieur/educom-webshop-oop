<?php

class BaseValidator
{
	protected array $fields;
    protected bool $result;
//==============================================================================
	public function __construct(array $fields)
	{
            $this->fields = $fields;
	}
//==============================================================================
	final public function validate() : bool
	{
            $this->result = true;
            $this->validateFields();
            return $this->result;
	}
//==============================================================================
	protected function validateFields() : void
	{
            foreach ($this->fields as $field)
            {
                if ($field instanceof FieldInfo === false || !$field->validate() )
                {    
                    $this->result = false;
		}
            }
	}
//==============================================================================
}
