<?php

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class ThumbnailExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		return $codex
			->Thumbnail()
			->setAttributes( [
				"class" => "foo",
				"bar" => "baz",
			] )
			->build()
			->getHtml();
	}
}
