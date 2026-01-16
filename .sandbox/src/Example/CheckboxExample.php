<?php

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class CheckboxExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		return $codex->Checkbox(
			inputId: 'password-reset-checkbox',
			label: $codex->Label(
				labelText: 'Send password reset emails only when both email address and username are provided.',
				description: 'This improves privacy and helps prevent unsolicited emails.',
				descriptionId: 'password-reset-checkbox-description'
			),
			wrapperAttributes: [
				'class' => 'foo',
			],
			inputAttributes: [
				'class' => 'bar',
				'data-toggle' => 'checkbox-option',
			]
		);
	}
}
