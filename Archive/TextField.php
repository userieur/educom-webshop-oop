<?php
/**
 * @author Geert Weggemans - geert@man-kind.nl
 * @date jan 8 2020
 */
namespace ManKind\cms\fields;
class TextField extends BaseInputField
{
    public function __construct(FieldInfo $fieldinfo)
    {
        parent::__construct($fieldinfo, 'text');
    }
}