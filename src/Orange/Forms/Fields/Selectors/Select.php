<?php

namespace Orange\Forms\Fields\Selectors;

class Select extends SelectorGeneric {

    const EMPTY_OPTION_NO = 0;
    const EMPTY_OPTION_NULL_VALUE_ONLY = 1;
    const EMPTY_OPTION_ALWAYS = 2;

    protected $emptyOptionPolicy = self::EMPTY_OPTION_NULL_VALUE_ONLY;
    protected $emptyOptionText = '';

    public function getHTML($value, $HTMLBuilder){
        $output = $this->label ? $HTMLBuilder->getLabelHTML($this->label, $this->id) : '';
        $output .= '<select';
        $output .= ' '.$this->buildAttributes().' ';
        $output .= $this->buildAttributes($this->attributes);
        $output .= '>';
        $selected = false;
        if (
            ($this->emptyOptionPolicy == self::EMPTY_OPTION_ALWAYS)
                ||
            (($this->emptyOptionPolicy == self::EMPTY_OPTION_NULL_VALUE_ONLY) && (is_null($value) || ($value === '')))
        ){
            $output .= '<option>' . $this->emptyOptionText . '</option>';
        }
        foreach ($this->options as $key => $label) {
            $output .= '<option';
            if ((string)$key === (string)$value){
                $output .= ' selected="selected"';
                $selected = true;
            }
            $output .= ' value="' . $key . '">' . $label . '</option>';
        }
        if (!$selected && (''.$value !== '')){
            $output .= '<option selected="selected" value="' . $value . '">' . $value . '</option>';
        }
        $output .= '</select>';
        return $output;
    }

    public function setEmptyOption($policy,$text = ''){
        $this->emptyOptionPolicy = $policy;
        $this->emptyOptionText = $text;
        return $this;
    }

    public function getClasses(){
        $classes = parent::getClasses();
        $classes[] = 'orange-forms-field-select';
        return $classes;
    }

}