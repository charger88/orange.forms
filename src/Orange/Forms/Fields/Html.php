<?php

namespace Orange\Forms\Fields;

class Html implements FieldInterface {

    protected $html = '';

    public function __construct($html = '')
    {
        $this->html = $html;
    }

    public function getHTML($value, $HTMLBuilder){
        return $this->html;
    }

    public function getClasses(){
        return ['orange-forms-html-code'];
    }

    public function getName(){
        return null;
    }

}