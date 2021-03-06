<?php

namespace Orange\Forms;

use Orange\Forms\Components\Multirow;
use Orange\Forms\Components\Fieldset;

abstract class Form
{

    const METHOD_GET = 'get';
    const METHOD_POST = 'post';
    const XSRF_FIELD_NAME = '_xsrf_protection_code';

    protected $action = '';
    protected $method = self::METHOD_POST;
    protected $datatype = 'multipart/form-data';
    protected $attributes = [];

    protected $HTMLBuilder;

    protected $scheme = [];
    protected $errors = [];
    protected $values = [];

    protected $xsrf_protection = false;

    public static $errors_text = [
        'EMPTY' => 'Field is empty',
    ];

    public function __construct($params = [], $HTMLBuilder = null)
    {
        $this->HTMLBuilder = is_null($HTMLBuilder) ? new HTMLBuilder() : $HTMLBuilder;
        $this->init($params);
    }

    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    public function setDatatype($datatype)
    {
        $this->datatype = $datatype;
        return $this;
    }

    public function setValues($values)
    {
        $this->values = $values;
        return $this;
    }

    public function enableXSRFProtection(){
        $this->xsrf_protection = true;
        return $this;
    }

    public function disableXSRFProtection(){
        $this->xsrf_protection = false;
        return $this;
    }

    public function checkXSRF($key = null){
        if (!$this->xsrf_protection){
            return true;
        }
        if (is_null($key)){
            if (isset($this->values[self::XSRF_FIELD_NAME])){
                $key = $this->values[self::XSRF_FIELD_NAME];
            } else {
                if ($this->method === self::METHOD_GET) {
                    if (isset($_GET[self::XSRF_FIELD_NAME])) {
                        $key = $_GET[self::XSRF_FIELD_NAME];
                    }
                } else if ($this->method === self::METHOD_POST){
                    if (isset($_POST[self::XSRF_FIELD_NAME])){
                        $key = $_POST[self::XSRF_FIELD_NAME];
                    }
                }
            }
        }
        return XSRFProtection::getInstance()->check($key, [get_class($this)]);
    }

    public function validateValues()
    {
        foreach ($this->scheme as $region_id => $region) {
            foreach ($region as $field) {
                if (($field instanceof Multirow) || ($field instanceof Fieldset)){
                    $errors = $field->validate($this->values);
                    $this->errors = array_merge($this->errors, $errors);
                } else {
                    $errors = $field->validate(isset($this->values[$field->getName()]) ? $this->values[$field->getName()] : null);
                    $this->errors[$field->getName()] = $errors;
                }
                $this->errors = array_filter($this->errors, function($v) {
                    return !empty($v);
                });
            }
        }
        return $this;
    }

    public function getValues()
    {
        return $this->values;
    }

    public function getValuesWithXSRFCheck()
    {
        if (!$this->checkXSRF()){
            throw new XSRFException('XSRF protection key is invalid');
        }
        return $this->getValues();
    }

    public function getErrors()
    {
        return $this->errors;
    }

    abstract protected function init($params);

    protected function addField($field, $region = '___')
    {
        if (!isset($this->scheme[$region])) {
            $this->scheme[$region] = [];
        }
        $this->scheme[$region][] = $field;
        return $this;
    }

    public function setError($name, $error)
    {
        $this->errors[$name] = [$error];
    }

    public function addError($name, $error)
    {
        if (!isset($this->errors[$name])) {
            $this->errors[$name] = [];
        }
        $this->errors[$name][] = $error;
        return $this;
    }

    public function getHTML()
    {
        $output = '<form';
        if ($this->action) {
            $output .= ' action="' . $this->action . '"';
        }
        if ($this->method) {
            $output .= ' method="' . $this->method . '"';
        }
        if ($this->datatype) {
            $output .= ' enctype="' . $this->datatype . '"';
        }
        if (!array_key_exists('class', $this->attributes)){
            $this->attributes['class'] = '';
        }
        $this->attributes['class'] .= ' orange-forms-form';
        $this->attributes['class'] = trim($this->attributes['class']);
        if ($this->attributes) {
            foreach ($this->attributes as $attribute => $value) {
                $output .= ' ' . $attribute . '="' . htmlspecialchars($value) . '"';
            }
        }
        $output .= '>';
        foreach ($this->scheme as $region_id => $region) {
            $output .= $this->HTMLBuilder->getRegionWrapperStart($region_id);
            foreach ($region as $field) {
                $multi = ($field instanceof Multirow) || ($field instanceof Fieldset);
                $name = rtrim($field->getName(), '[]');
                if ($multi){
                    $output .= $this->HTMLBuilder->wrapField(
                        $field->getHTML(
                            $this->values,
                            $this->HTMLBuilder,
                            $this->errors
                        ),
                        $field->getClasses()
                    );
                } else {
                    $output .= $this->HTMLBuilder->wrapField(
                        $field->getHTML(
                            isset($this->values[$name]) ? $this->values[$name] : $field->getDefault(),
                            $this->HTMLBuilder
                        ),
                        $field->getClasses(),
                        isset($this->errors[$field->getName()]) ? $this->errors[$field->getName()] : []
                    );
                }
            }
            $output .= $this->HTMLBuilder->getRegionWrapperEnd($region_id);
        }
        if ($this->xsrf_protection){
            $output .= '<input type="hidden" name="' . self::XSRF_FIELD_NAME . '" value="' . XSRFProtection::getInstance()->key([get_class($this)]) . '" />';
        }
        $output .= '</form>';
        return $output;
    }

}