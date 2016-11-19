<?php

namespace Orange\Forms;

class XSRFProtection
{

    /**
     * @var XSRFProtection
     */
    private static $instance = null;
    private static $unique_components = [];
    private static $key_life_hours = 3;

    public static function setKeyLifeHours($hours){
        static::$key_life_hours = $hours;
    }

    public static function addUniqueKeyComponent($components){
        static::$unique_components[] = $components;
    }

    public static function getInstance(){
        if (is_null(static::$instance)){
            static::$instance = new XSRFProtection();
        }
        return static::$instance;
    }

    private function __construct(){
    }

    public function key($args = [], $time = null, $ignore_basic_args = false){
        if (is_null($time)){
            $time = time();
        }
        $key_args = [gmdate("YmdH", $time)];
        if (!$ignore_basic_args) {
            $key_args = array_merge($key_args, static::$unique_components);
        }
        $key_args = array_merge($key_args, $args);
        return md5(implode(':', $key_args));
    }

    public function check($key, $args = [], $ignore_basic_args = false){
        $result = false;
        for ($i = 0; $i < static::$key_life_hours; $i++){
            if ($key === $this->key($args, time() - $i * 3600, $ignore_basic_args)){
                $result = true;
                break;
            }
        }
        return $result;
    }

}