<?php

namespace Orange\Forms\Fields\Selectors;

class Select extends SelectorGeneric {

    const EMPTY_OPTION_NO = 0;
    const EMPTY_OPTION_NULL_VALUE_ONLY = 1;
    const EMPTY_OPTION_ALWAYS = 2;

    protected $emptyOptionPolicy = self::EMPTY_OPTION_NULL_VALUE_ONLY;
    protected $emptyOptionText = '';
    protected $multiple = false;

    public function getHTML($value, $HTMLBuilder){
        $output = $this->label ? $HTMLBuilder->getLabelHTML($this->label, $this->id) : '';
        $output .= '<select';
        $output .= ' '.$this->buildAttributes().' ';
        if ($this->multiple){
            $output .= ' multiple="multiple" ';
        }
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
            $checked = (is_array($value) && in_array(''.$key, $value)) || (!is_array($value) && (''.$key === ''.$value));
            if ($checked){
                $output .= ' selected="selected"';
                $selected = true;
            }
            $output .= ' value="' . $key . '">' . $label . '</option>';
        }
        if (!$selected && ((is_array($value) && empty($value)) || (!is_array($value) && (''.$value !== '')))){
            $values = is_array($value) ? $value : [$value];
            foreach ($values as $v) {
                if (!isset($this->options[$v])) {
                    $output .= '<option selected="selected" value="' . $v . '">' . $v . '</option>';
                }
            }
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
        if ($this->multiple){
            $classes[] = 'orange-forms-field-select-multiple';
        }
        return $classes;
    }

    public function setMultiple($value = true){
        $this->multiple = $value;
        if ($value){
            $this->name .= '[]';
        } else {
            $sl = strlen($this->name) - 2;
            $this->name = strpos($this->name, '[]') === $sl ? substr($this->name, 0, $sl) : $this->name;
        }
        return $this;
    }

}