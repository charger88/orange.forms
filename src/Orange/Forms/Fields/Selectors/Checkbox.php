<?php

namespace Orange\Forms\Fields\Selectors;

use \Orange\Forms\Fields\FieldGeneric;

class Checkbox extends FieldGeneric {

    protected $default_value = 'on';

    public function getHTML($value, $HTMLBuilder){
        $output = '<div class="orange-forms-field-checkbox-item-wrapper">';
        $output .= '<label for="' . $this->id . '"><input type="checkbox"';
        if (''.$this->default_value === ''.$value){
            $output .= ' checked="checked"';
        }
        $output .= $this->buildAttributes($this->attributes);
        $output .= ' value="' . $this->default_value . '" />';
        $output .= ' ' . $this->label . '</label></div>';
        return $output;
    }

    public function getClasses(){
        $classes = parent::getClasses();
        $classes[] = 'orange-forms-field-checkbox';
        return $classes;
    }

    public function getDefault(){
        return null;
    }

}