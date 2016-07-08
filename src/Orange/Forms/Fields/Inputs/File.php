<?php

namespace Orange\Forms\Fields\Inputs;

class File extends Text {

    protected $type = 'file';

    public function getHTML($value, $HTMLBuilder){
        $output = $this->label ? $HTMLBuilder->getLabelHTML($this->label, $this->id) : '';
        $output .= '<input type="' . $this->type . '"';
        $output .= $this->buildAttributes($this->attributes);
        $output .= ' />';
        return $output;
    }

}