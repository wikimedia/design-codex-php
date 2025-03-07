<?php

$cfg = require __DIR__ . '/../vendor/mediawiki/mediawiki-phan-config/src/config-library.php';

$cfg['strict_method_checking'] = true;
$cfg['strict_object_checking'] = true;
$cfg['strict_property_checking'] = true;

return $cfg;
