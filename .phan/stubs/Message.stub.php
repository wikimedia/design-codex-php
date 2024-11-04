<?php
// phpcs:ignoreFile
namespace MediaWiki\Message;

class Message {
	/**
	 * Factory method to create a Message instance based on a message key.
	 *
	 * @param string $key The key for the message.
	 * @param array $params Optional parameters for message placeholders.
	 * @return self
	 */
	public static function newFromKey( string $key, array $params = [] ): self {
		return new self();
	}

	/**
	 * Retrieves the text for the message.
	 *
	 * @return string The localized message text.
	 */
	public function text(): string {
		return '';
	}
}
