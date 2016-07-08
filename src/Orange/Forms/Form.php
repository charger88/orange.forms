<?php

namespace Orange\Forms;

abstract class Form {

    const METHOD_GET  = 'get';
    const METHOD_POST = 'post';

    protected $action = '';
    protected $method = self::METHOD_POST;
    protected $datatype = 'multipart/form-data';
    protected $attributes = [];

    protected $HTMLBuilder;

    protected $scheme = [];
    protected $values = [];

    public function __construct($params = [],$HTMLBuilder = null){
        $this->HTMLBuilder = is_null($HTMLBuilder) ? new HTMLBuilder() : $HTMLBuilder;
        $this->init($params);
    }

    public function setAction($action){
        $this->action = $action;
        return $this;
    }

    public function setMethod($method){
        $this->method = $method;
        return $this;
    }

    public function setAttributes($attributes){
        $this->attributes = $attributes;
        return $this;
    }

    public function setDatatype($datatype){
        $this->datatype = $datatype;
        return $this;
    }

    public function setValues($values){
        $this->values = $values;
        return $this;
    }

    public function validateValues(){
        //TODO
        return $this;
    }

    public function getValues(){
        return $this->values;
    }

    abstract protected function init($params);

    protected function addField($field, $region = null){
        if (!isset($this->scheme[$region])){
            $this->scheme[$region] = [];
        }
        $this->scheme[$region][] = $field;
        return $this;
    }

    public function getHTML(){
        $output = '<form';
        if ($this->action){
            $output .= ' action="' . $this->action . '"';
        }
        if ($this->method){
            $output .= ' method="' . $this->method . '"';
        }
        if ($this->datatype){
            $output .= ' enctype="' . $this->datatype . '"';
        }
        if ($this->attributes){
            foreach ($this->attributes as $attribute => $value) {
                $output .= ' '.$attribute.'="' . $value . '"';
            }
        }
        $output .= '>';
        foreach ($this->scheme as $region_id => $region){
            $output .= $this->HTMLBuilder->getRegionWrapperStart($region_id);
            foreach ($region as $field){
                $output .= $this->HTMLBuilder->wrapField(
                    $field->getHTML(
                        isset($this->values[$field->getName()]) ? $this->values[$field->getName()] : null,
                        $this->HTMLBuilder
                    ),
                    $field->getClasses()
                );
            }
            $output .= $this->HTMLBuilder->getRegionWrapperEnd($region_id);
        }
        $output .= '</form>';
        return $output;
    }

}