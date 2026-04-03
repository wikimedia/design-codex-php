<?php

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class ProgressBarExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		return (string)$codex->ProgressBar(
			label: 'Loading content...',
			attributes: [
				'class' => 'foo',
				'id' => 'content-loading-progress',
				'data-loading' => 'true',
			]
		);
	}
}
