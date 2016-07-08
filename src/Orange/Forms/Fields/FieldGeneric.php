<?php

namespace Orange\Forms\Fields;

abstract class FieldGeneric implements FieldInterface
{

    protected $id = '';
    protected $name = '';
    protected $label = null;
    protected $attributes = [];
    protected $required = false;
    protected $disabled = false;
    protected $readonly = false;

    public function __construct($id, $label = null)
    {
        $this->id = $this->name = $id;
        $this->label = $label;
    }

    public function placeholder()
    {
        $this->attributes['placeholder'] = $this->label;
        $this->label = null;
    }

    public function getClasses()
    {
        return ['orange-forms-field'];
    }

    public function setID($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function requireField()
    {
        $this->required = true;
        return $this;
    }

    public function notRequireField()
    {
        $this->required = false;
        return $this;
    }

    public function enable()
    {
        $this->disabled = false;
        return $this;
    }

    public function disable()
    {
        $this->disabled = true;
        return $this;
    }

    public function setReadonly()
    {
        $this->readonly = true;
        return $this;
    }

    public function setNotReadonly()
    {
        $this->readonly = false;
        return $this;
    }

    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    public function addAttributes($attributes)
    {
        $this->attributes += $attributes;
        return $this;
    }

    public function setAttribute($attribute, $value)
    {
        $this->attributes[$attribute] = $value;
        return $this;
    }

    public function buildAttributes()
    {
        $output = ' name="' . $this->name . '"';
        if ($this->id) {
            $output .= ' id="' . $this->id . '"';
        }
        if ($this->disabled) {
            $output .= ' disabled="disabled"';
        }
        if ($this->readonly) {
            $output .= ' readonly="readonly"';
        }
        if ($this->required) {
            $output .= ' required="required"';
        }
        foreach ($this->attributes as $key => $value) {
            $output .= ' ' . $key . '="' . htmlspecialchars($value) . '"';
        }
        return $output;
    }

}