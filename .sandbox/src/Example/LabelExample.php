<?php

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class LabelExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		return (string)$codex->Label(
			labelText: 'Username',
			optional: true,
			description: 'Please enter your username.',
			attributes: [
				'id' => 'username',
				'class' => 'foo',
				'data-info' => 'username-input-label',
			],
			isLegend: false,
			inputId: 'usernameInput'
		);
	}
}
