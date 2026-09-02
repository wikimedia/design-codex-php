<?php
declare( strict_types = 1 );

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class TextInputExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		return (string)$codex->TextInput(
			type: "text",
			name: "username",
			inputId: "username-input",
			placeholder: "Enter your username",
			disabled: false,
			status: 'default',
			inputAttributes: [
				"class" => "bar",
				"autocomplete" => "username",
				"aria-label" => "Username",
			],
			wrapperAttributes: [
				'class' => 'foo',
				'data-toggle' => 'example-action',
			],
			hasStartIcon: true,
			hasEndIcon: false,
			// Icon image is set in this page's CSS via this class.
			startIconClass: 'cdx-icon--login',
		);
	}
}
