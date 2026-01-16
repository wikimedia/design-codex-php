<?php
require __DIR__ . '/../vendor/autoload.php';

use Wikimedia\Codex\Tests\Integration\SnapshotTest;
use Wikimedia\Codex\Utility\Codex;

SnapshotTest::writeSnapshots( new Codex() );
