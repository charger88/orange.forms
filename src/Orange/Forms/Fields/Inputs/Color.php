<?php

namespace Orange\Forms\Fields\Inputs;

class Color extends Text {

    protected $type = 'color';

    public function getClasses(){
        $classes = parent::getClasses();
        $classes[] = 'orange-forms-field-'.$this->type;
        return $classes;
    }

}