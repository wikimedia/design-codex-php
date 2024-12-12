<?php

$cfg = require __DIR__ . '/../vendor/mediawiki/mediawiki-phan-config/src/config-library.php';

// Parse only a subset of dependencies
$cfg['directory_list'] = array_diff( $cfg['directory_list'], [ 'vendor/' ] );

$cfg['directory_list'] = array_merge(
	$cfg['directory_list'],
	[
		'tests',
		'vendor/krinkle/intuition',
		'vendor/psr/log',
		'vendor/psr/http-message',
		'vendor/guzzlehttp/psr7',
		'vendor/zordius/lightncandy',
		'vendor/phpunit/phpunit',
		'vendor/wikimedia/services',
		'.phan/stubs',
	]
);

$cfg['strict_method_checking'] = true;
$cfg['strict_object_checking'] = true;
$cfg['strict_property_checking'] = true;

return $cfg;
