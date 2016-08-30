<?php

namespace Orange\Forms\Fields\Selectors;

abstract class SelectorGeneric extends \Orange\Forms\Fields\FieldGeneric {

    protected $options = [];

    public function __construct($id,$label = null,$options = []){
        $this->id = $this->name = $id;
        $this->label = $label;
        $this->setOptions($options);
    }

    public function setOptions($options){
        $this->options = $options;
        return $this;
    }

    public function addOptions($options){
        $this->options += $options;
        return $this;
    }

    public function setOption($value, $label){
        $this->options[$value] = $label;
        return $this;
    }

}