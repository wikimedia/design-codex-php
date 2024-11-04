<?php
// phpcs:ignoreFile
namespace MediaWiki\Context;

use MediaWiki\Message\Message;

class RequestContext {

	/**
	 * Get the main request context.
	 *
	 * @return RequestContext
	 */
	public static function getMain(): RequestContext {
		return new self();
	}

	/**
	 * Get a localized message.
	 *
	 * This method returns a mock message object for testing purposes.
	 *
	 * @param string $key Message key.
	 * @param mixed ...$params Optional parameters for message replacements.
	 * @return Message A stubbed message with a text() method.
	 */
	public function msg( string $key, ...$params ): Message {
		return new Message();
	}
}
