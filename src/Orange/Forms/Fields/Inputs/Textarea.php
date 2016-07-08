<?php

namespace Orange\Forms\Fields\Inputs;

class Textarea extends \Orange\Forms\Fields\FieldGeneric {

    protected $type = 'textarea';

    public function getHTML($value, $HTMLBuilder){
        $output = $this->label ? $HTMLBuilder->getLabelHTML($this->label, $this->id) : '';
        $output .= '<textarea';
        $output .= $this->buildAttributes($this->attributes);
        $output .= '>' . $value . '</textarea>';
        return $output;
    }

    public function getClasses(){
        $classes = parent::getClasses();
        $classes[] = 'orange-forms-field-textarea';
        return $classes;
    }

}