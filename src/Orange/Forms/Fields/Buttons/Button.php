<?php

namespace Orange\Forms\Fields\Buttons;

class Button extends \Orange\Forms\Fields\FieldGeneric {

    protected $type = 'button';

    public function getHTML($value, $HTMLBuilder){
        $output = '<button type="'.$this->type.'"';
        if ($this->disabled){
            $output .= ' disabled="disabled"';
        }
        $output .= $this->buildAttributes($this->attributes);
        $output .= '>'.$this->label.'</button>';
        return $output;
    }

    public function getClasses(){
        $classes = parent::getClasses();
        $classes[] = 'orange-forms-field-button';
        $classes[] = 'orange-forms-field-button-'.$this->type;
        return $classes;
    }

}