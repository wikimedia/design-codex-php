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
		'vendor/mustache/mustache',
		'vendor/phpunit/phpunit',
		'vendor/ezyang/htmlpurifier',
	]
);

// TODO: Fix and remove
$cfg['suppress_issue_types'][] = 'SecurityCheck-DoubleEscaped';

return $cfg;
