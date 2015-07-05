<?php

use \Michelf\MarkdownExtra;

include PLUGIN . DS . File::B(__DIR__) . DS . 'cargo' . DS . 'Michelf' . DS . 'Markdown.php';
include PLUGIN . DS . File::B(__DIR__) . DS . 'cargo' . DS . 'Michelf' . DS . 'MarkdownExtra.php';

Text::parser('to_html', function($input) {
    if( ! is_string($input)) return $input;
    $state = PLUGIN . DS . File::B(__DIR__) . DS . 'states' . DS;
    $url = File::open($state . 'url.txt')->read();
    $abbr = File::open($state . 'abbr.txt')->read();
    $parser = new MarkdownExtra;
    $parser->empty_element_suffix = ES;
    $parser->table_align_class_tmpl = 'text-%%'; // Define table alignment class, example: `<td class="text-right">`
    return trim($parser->transform($url . "\n\n" . $abbr . "\n\n" . $input));
});