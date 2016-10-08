<?php

namespace Orange\Forms\Fields\Inputs;

class Text extends \Orange\Forms\Fields\FieldGeneric {

    protected $type = 'text';

    public function getHTML($value, $HTMLBuilder){
        $output = $this->label ? $HTMLBuilder->getLabelHTML($this->label, $this->id) : '';
        $output .= '<input type="' . $this->type . '"';
        $output .= ' value="' . htmlspecialchars($value) . '"';
        $output .= $this->buildAttributes($this->attributes);
        $output .= ' />';
        return $output;
    }

    public function getClasses(){
        $classes = parent::getClasses();
        $classes[] = 'orange-forms-field-input';
        $classes[] = 'orange-forms-field-input-'.$this->type;
        return $classes;
    }

}