<?php

namespace Orange\Forms\Fields\Selectors;

class Radio extends SelectorGeneric {

    public function getHTML($value, $HTMLBuilder){
        $output = '';
        $n = 0;
        $id = $this->id;
        foreach ($this->options as $key => $label) {
            $n++;
            $this->id = $id . '-' . $n;
            $output .= '<input type="radio"';
            if (''.$key === ''.$value){
                $output .= ' checked="checked"';
            }
            $output .= $this->buildAttributes($this->attributes);
            $output .= ' value="' . $key . '" />';
            $output .= '<label for="' . $this->id . '-' . $n . '">'.$label.'</label>';
        }
        $this->id = $id;
        return $output;
    }

    public function getClasses(){
        $classes = parent::getClasses();
        $classes[] = 'orange-forms-field-radio';
        return $classes;
    }

}