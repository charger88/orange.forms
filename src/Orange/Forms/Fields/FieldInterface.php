<?php

namespace Orange\Forms\Fields;

interface FieldInterface {

    public function getHTML($value,$HTMLBuilder);

    public function getClasses();

    public function getName();

}