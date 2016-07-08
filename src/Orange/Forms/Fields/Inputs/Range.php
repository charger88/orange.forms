<?php

namespace Orange\Forms\Fields\Inputs;

class Range extends Text {

    protected $type = 'range';

    public function getClasses(){
        $classes = parent::getClasses();
        $classes[] = 'orange-forms-field-'.$this->type;
        return $classes;
    }

}