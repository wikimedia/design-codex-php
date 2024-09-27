<?php
return [
	'directory_list' => [
		'src',
		'tests',
		'vendor/krinkle/intuition',
		'vendor/psr/log',
		'vendor/mustache/mustache',
		'vendor/phpunit/phpunit',
		'vendor/ezyang/htmlpurifier',
	],
	'exclude_analysis_directory_list' => [
		'vendor/',
	],
	'file_list' => [
		'vendor/autoload.php',
	],
];
