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
            $output .= '<div class="orange-forms-field-radio-item-wrapper">';
            $output .= '<label for="' . $this->id . '"><input type="radio"';
            if (''.$key === ''.$value){
                $output .= ' checked="checked"';
            }
            $output .= $this->buildAttributes($this->attributes);
            $output .= ' value="' . addslashes($key) . '" />';
            $output .= ' '.$label.'</label></div>';
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