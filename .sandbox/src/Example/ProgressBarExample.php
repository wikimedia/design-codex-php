<?php

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class ProgressBarExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		return $codex
			->ProgressBar()
			->setLabel( "Loading content..." )
			->setInline( false )
			->setDisabled( false )
			->setAttributes( [
				"class" => "foo",
				"id" => "content-loading-progress",
				"data-loading" => "true",
			] )
			->build()
			->getHtml();
	}
}
