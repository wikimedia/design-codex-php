<?php

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class ToggleSwitchExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		return $codex->ToggleSwitch(
			inputId: 'visual-editing-mode',
			label: $codex->Label(
				labelText: 'Visual editing mode',
				description: 'Turn on to use the visual editor. You can switch back to source mode at any time',
				descriptionId: 'visual-editing-mode-description'
			),
			checked: false,
			disabled: false,
			inputAttributes: [
				'foo' => 'bar'
			]
		);
	}
}
