<?php

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
			hasStartIcon: true,
			// Icon image is set in this page's CSS via this class.
			startIconClass: 'cdx-icon--login',
			hasEndIcon: false,
			disabled: false,
			status: 'default',
			wrapperAttributes: [
				"class" => "foo",
				"data-toggle" => "example-action",
			],
			inputAttributes: [
				"class" => "bar",
				"autocomplete" => "username",
				"aria-label" => "Username",
			]
		);
	}
}
