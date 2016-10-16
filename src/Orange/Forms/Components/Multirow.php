<?php

namespace Orange\Forms\Components;

class Multirow implements \Orange\Forms\Fields\FieldInterface
{

    protected $id = null;
    protected $label = null;

    public $fields = [];

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
        $value = isset($value[$this->getName()]) ? $value[$this->getName()] : $this->getDefault();
        $output = '<fieldset id="multirow-'.htmlspecialchars($this->id).'">';
        if ($this->label) {
            $output .= '<legend>' . $this->label . '</legend><div class="orange-forms-rows-container">';
        }
        if (empty($value)) {
            $value = [];
            foreach ($this->fields as $fieldOrg) {
                $value[$fieldOrg->getName()] = [];
            }
        }
        foreach ($value as $column => $values) {
            $values[] = null; // It is about empty row
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
                $field_value = isset($value[$fieldOrg->getName()]) && isset($value[$fieldOrg->getName()][$index])
                    ? $value[$fieldOrg->getName()][$index]
                    : $fieldOrg->getDefault();
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
        $output .= '</div></fieldset>';
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