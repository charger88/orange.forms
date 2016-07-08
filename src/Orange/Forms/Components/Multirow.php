<?php

namespace Orange\Forms\Components;

class Multirow implements \Orange\Forms\Fields\FieldInterface
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
        if (is_null($value)) {
            $value = [];
            foreach ($this->fields as $fieldOrg) {
                $value[$fieldOrg->getName()] = [];
            }
        }
        foreach ($value as $column => $values) {
            $values[] = null;
            $value[$column] = $values;
        }
        $one_empty = false;
        $firstcolumn = array_keys($value[key($value)]);
        foreach ($firstcolumn as $index) {
            $not_empty = false;
            $current = '';
            foreach ($this->fields as $fieldOrg) {
                $field = clone $fieldOrg;
                $field->setID($this->id . '-' . $field->getName() . '-' . $index)->setName($this->id . '[' . $field->getName() . '][]');
                $field_value = $value[$fieldOrg->getName()][$index];
                $not_empty = $not_empty || !empty($field_value);
                $current .= $HTMLBuilder->wrapField($field->getHTML($field_value, $HTMLBuilder), $field->getClasses());
            }
            if ($not_empty || !$one_empty) {
                $output .= $HTMLBuilder->wrapFieldsRow($current);
                if (!$not_empty && !$one_empty) {
                    $one_empty = true;
                }
            }
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

}