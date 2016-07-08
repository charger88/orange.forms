<?php

namespace Orange\Forms;

class HTMLBuilder
{

    public function getRegionWrapperStart($region_id)
    {
        return '';
    }

    public function getRegionWrapperEnd($region_id)
    {
        return '';
    }

    public function wrapFieldsRow($row_html)
    {
        return '<div class="orange-forms-row-wrapper">' . $row_html . '</div>';
    }

    public function wrapField($field_html, $field_classes = [])
    {
        $field_classes[] = 'orange-forms-field-wrapper';
        return '<div class="' . implode(' ', $field_classes) . '">' . $field_html . '</div>';
    }

    public function getLabelHTML($label, $for_id)
    {
        return '<label' . ($for_id ? ' for="' . htmlspecialchars($for_id) . '"' : '') . '>' . htmlspecialchars($label) . '</label>';
    }

}