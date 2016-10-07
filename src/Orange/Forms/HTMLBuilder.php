<?php

namespace Orange\Forms;

class HTMLBuilder
{

    public function getRegionWrapperStart($region_id)
    {
        return !is_null($region_id) ? '<div class="orange-forms-region" id="form-region-' . addslashes($region_id) . '">' : '';
    }

    public function getRegionWrapperEnd($region_id)
    {
        return !is_null($region_id) ? '</div>' : '';
    }

    public function wrapFieldsRow($row_html)
    {
        return '<div class="orange-forms-row-wrapper">' . $row_html . '</div>';
    }

    public function wrapField($field_html, $field_classes = [], $errors = [])
    {
        $field_classes[] = 'orange-forms-field-wrapper';
        return '<div class="' . implode(' ', $field_classes) . '">' . $field_html . ($errors ? '<ul class="orange-forms-field-errors"><li>' . implode('</li><li>', $errors) . '</li></li></ul>' : '') . '</div>';
    }

    public function getLabelHTML($label, $for_id)
    {
        return '<label' . ($for_id ? ' for="' . htmlspecialchars($for_id) . '"' : '') . '>' . htmlspecialchars($label) . '</label>';
    }

}