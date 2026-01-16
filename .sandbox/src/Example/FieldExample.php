<?php

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class FieldExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		$checkbox1 = $codex->Checkbox(
			inputId: 'email-allow-others',
			label: $codex->Label(
				labelText: 'Allow other users to email me'
			)
		);

		$checkbox2 = $codex->Checkbox(
			inputId: 'email-allow-new',
			label: $codex->Label(
				labelText: 'Allow emails from brand-new users'
			)
		);

		return $codex->Field(
			label: $codex->Label(
				labelText: 'Email confirmation',
				description: 'Specify an email address in your preferences for these features to work.',
				optional: true
			),
			fields: [ $checkbox1, $checkbox2 ],
			isFieldset: true,
			attributes: [
				'class' => 'foo',
				'bar' => 'baz',
				'id' => 'email-confirmation-fieldset',
				'data-category' => 'email-options',
			]
		);
	}
}
