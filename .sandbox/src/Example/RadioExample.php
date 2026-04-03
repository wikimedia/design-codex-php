<?php
declare( strict_types = 1 );

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class RadioExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		$inputAttrs = [
			'class' => 'foo',
			'data-toggle' => 'radio-option',
		];
		$wrapperAttrs = [
			'class' => 'bar',
		];
		$defaultRadio = $codex->Radio(
			inputId: 'password-reset-radio-1',
			name: 'password-reset-options',
			label: $codex->Label(
				labelText: 'Send password reset emails only when both email address and username are provided.',
				description: 'This improves privacy and helps prevent unsolicited emails.',
				descriptionId: 'password-reset-radio-description-1'
			),
			value: 'option1',
			checked: false,
			inline: false,
			inputAttributes: $inputAttrs,
			wrapperAttributes: $wrapperAttrs
		);
		$selectedRadio = $codex->Radio(
			inputId: 'password-reset-radio-selected',
			name: 'password-reset-options',
			label: $codex->Label(
				labelText: 'This radio is selected by default'
			),
			value: 'option2',
			checked: true,
			inline: false,
			inputAttributes: $inputAttrs,
			wrapperAttributes: $wrapperAttrs
		);
		$disabledRadio = $codex->Radio(
			inputId: 'password-reset-radio-disabled',
			name: 'password-reset-options',
			label: $codex->Label(
				labelText: 'This radio is disabled'
			),
			value: 'option3',
			checked: false,
			inline: false,
			disabled: true,
			inputAttributes: $inputAttrs,
			wrapperAttributes: $wrapperAttrs
		);
		$inlineRadio1 = $codex->Radio(
			inputId: 'password-reset-radio-inline-1',
			name: 'password-reset-options-inline',
			label: $codex->Label(
				labelText: 'Inline option (true)'
			),
			value: 'option4',
			checked: false,
			inline: true,
			inputAttributes: $inputAttrs,
			wrapperAttributes: $wrapperAttrs
		);
		$inlineRadio2 = $codex->Radio(
			inputId: 'password-reset-radio-inline-2',
			name: 'password-reset-options-inline',
			label: $codex->Label(
				labelText: 'Inline option (false)'
			),
			value: 'option5',
			checked: false,
			inline: true,
			inputAttributes: $inputAttrs,
			wrapperAttributes: $wrapperAttrs
		);
		return '<div>' . $defaultRadio . '</div>' .
				'<div>' . $selectedRadio . '</div>' .
				'<div>' . $disabledRadio . '</div>' .
				'<div>' . $inlineRadio1 . '</div>' .
				'<div>' . $inlineRadio2 . '</div>';
	}
}
