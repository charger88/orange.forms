<?php

namespace Orange\Forms\Components;

class Fieldset implements \Orange\Forms\Fields\FieldInterface
{

    protected $id = null;
    protected $label = null;
    protected $fields = [];

    public function __construct($id, $label = null)
    {
        $this->id = $this->name = $id;
        $this->label = $label;
    }

    public function addField($field)
    {
        $this->fields[] = $field;
        return $this;
    }

    public function getHTML($value, $HTMLBuilder)
    {
        $output = '<fieldset>';
        if ($this->label) {
            $output .= '<legend>' . $this->label . '</legend>';
        }
        foreach ($this->fields as $field) {
            $field_value = isset($value[$field->getName()]) ? $value[$field->getName()] : $field->getDefault();
            $output .= $HTMLBuilder->wrapField($field->getHTML($field_value, $HTMLBuilder), $field->getClasses());
        }
        $output .= '</fieldset>';
        return $output;
    }

    public function getClasses()
    {
        return [
            'orange-forms-multirow'
        ];
    }

    public function getName()
    {
        return $this->id;
    }

    public function getDefault(){
        return [];
    }

}