<?php

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class RadioExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		return $codex->Radio(
			inputId: "password-reset-radio-1",
			name: "password-reset-options",
			label: $codex->Label(
				labelText: "Send password reset emails only when both email address and username are provided.",
				description: "This improves privacy and helps prevent unsolicited emails.",
				descriptionId: "password-reset-radio-description-1"
			),
			value: "option1",
			checked: false,
			inline: false,
			inputAttributes: [
				"class" => "foo",
				"data-toggle" => "radio-option",
			],
			wrapperAttributes: [
				"class" => "bar",
			]
		);
	}
}
