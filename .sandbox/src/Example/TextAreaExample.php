<?php

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class TextAreaExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		return (string)$codex->TextArea(
			name: 'user-message',
			placeholder: 'Enter your message...',
			value: 'This is a default message.',
			inputId: 'user-message',
			inputAttributes: [
				'class' => 'foo',
				'data-category' => 'feedback',
				'aria-label' => 'Message',
			],
			wrapperAttributes: [
				'class' => 'bar',
				'some-attribute' => 'some-value',
			]
		);
	}
}
