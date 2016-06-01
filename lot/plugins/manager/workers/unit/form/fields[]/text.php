<?php

$attributes += array(
    'class' => 'input-block'
);

Mecha::extend($attributes, $data['attributes']);

$html .= '<label class="grid-group grid-group-' . (isset($attributes['type']) ? $attributes['type'] : $type) . '">';
$html .= '<span class="grid span-2 form-label">' . $title . '</span>';
$html .= '<span class="grid span-4">';
$html .= Form::text('fields[' . $key . '][value]', $value ? Converter::toText($value) : null, $placeholder ? $placeholder : null, $attributes);
$html .= '</span>';
$html .= '</label>';