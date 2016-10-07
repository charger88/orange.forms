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
        $output = '<fieldset id="fieldset-'.addslashes($this->id).'">';
        if ($this->label) {
            $output .= '<legend>' . $this->label . '</legend><div class="orange-forms-fieldset-data">';
        }
        foreach ($this->fields as $field) {
            $name = rtrim($field->getName(), '[]');
            $field_value = isset($value[$name]) ? $value[$name] : $field->getDefault();
            $output .= $HTMLBuilder->wrapField($field->getHTML($field_value, $HTMLBuilder), $field->getClasses());
        }
        $output .= '</div></fieldset>';
        return $output;
    }

    public function getClasses()
    {
        return [
            'orange-forms-fieldset'
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