<?php

namespace Orange\Forms\Fields\Inputs;

class Hidden extends Text {

    protected $type = 'hidden';

    public function __construct($id){
        $this->id = $this->name = $id;
    }

    public function getClasses(){
        $classes = parent::getClasses();
        $classes[] = 'orange-forms-field-'.$this->type;
        return $classes;
    }

}