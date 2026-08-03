<?php
declare( strict_types = 1 );

$cfg = require __DIR__ . '/../vendor/mediawiki/mediawiki-phan-config/src/config-library.php';

$cfg['strict_method_checking'] = true;
$cfg['strict_object_checking'] = true;
$cfg['strict_property_checking'] = true;

// guzzlehttp/psr7 >= 2.11 pulls in symfony/polyfill-php80. We require PHP 8.2+, so the
// polyfill's stubs are never loaded at runtime, but Phan parses everything under vendor/
// and reports the duplicate \Stringable declaration against Contract\Component.
$cfg['exclude_file_list'][] = 'vendor/symfony/polyfill-php80/Resources/stubs/Stringable.php';

return $cfg;
