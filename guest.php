<?php

require_once('helpers.php');
require_once('init.php');

$page_content = include_template('guest_main.php');


$layout_content = include_template('layout.php', [
	'content' => $page_content,
	'title' => 'Document'

]);

print($layout_content);



			   
