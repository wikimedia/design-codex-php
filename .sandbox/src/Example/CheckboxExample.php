<?php
declare( strict_types = 1 );

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class CheckboxExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		$defaultCheckbox = $codex->Checkbox(
			inputId: 'password-reset-checkbox',
			label: $codex->Label(
				labelText: 'Send password reset emails only when both email address and username are provided.',
				description: 'This improves privacy and helps prevent unsolicited emails.',
				descriptionId: 'password-reset-checkbox-description',
			),
			name: 'password-reset',
			value: '1',
			wrapperAttributes: [
				'class' => 'foo',
			],
			inputAttributes: [
				'class' => 'bar',
				'data-toggle' => 'checkbox-option',
			],
		);

		// Checked checkbox, ticked by default.
		$checkedCheckbox = $codex->Checkbox(
			inputId: 'checked-checkbox',
			label: $codex->Label(
				labelText: 'This checkbox is checked by default.',
			),
			checked: true,
		);

		// Disabled checkbox.
		$disabledCheckbox = $codex->Checkbox(
			inputId: 'disabled-checkbox',
			label: $codex->Label(
				labelText: 'This checkbox is disabled.',
			),
			disabled: true,
		);

		// Inline checkbox.
		$inlineCheckbox = $codex->Checkbox(
			inputId: 'inline-checkbox',
			label: $codex->Label(
				labelText: 'This checkbox is inline.',
			),
			inline: true,
		);

		return $defaultCheckbox .
			$checkedCheckbox .
			$disabledCheckbox .
			$inlineCheckbox;
	}
}
