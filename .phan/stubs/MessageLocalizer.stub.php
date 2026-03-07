<?php
// phpcs:ignoreFile
namespace MediaWiki\Language;

use MediaWiki\Message\Message;

interface MessageLocalizer {
	public function msg( string $key, ...$params ): Message;
}
