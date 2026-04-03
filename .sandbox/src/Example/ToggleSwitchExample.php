<?php
declare( strict_types = 1 );

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class ToggleSwitchExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		$inputAttrs = [
			'foo' => 'bar',
			'data-toggle' => 'toggle-switch',
		];
		$defaultToggle = $codex->ToggleSwitch(
			inputId: 'visual-editing-mode',
			label: $codex->Label(
				labelText: 'Visual editing mode',
				description: 'Turn on to use the visual editor. You can switch back to source mode at any time',
				descriptionId: 'visual-editing-mode-description'
			),
			checked: false,
			disabled: false,
			inputAttributes: $inputAttrs
		);

		$checkedToggle = $codex->ToggleSwitch(
			inputId: 'toggle-checked',
			label: $codex->Label(
				labelText: 'This is a pre-checked Toggle Switch'
			),
			checked: true,
			disabled: false,
			inputAttributes: $inputAttrs
		);

		$disabledToggle = $codex->ToggleSwitch(
			inputId: 'toggle-disabled',
			label: $codex->Label(
				labelText: 'This is a disabled Toggle Switch'
			),
			checked: false,
			disabled: true,
			inputAttributes: $inputAttrs
		);
		return '<div>' . $defaultToggle . '</div>' .
				'<div>' . $checkedToggle . '</div>' .
				'<div>' . $disabledToggle . '</div>';
	}
}
