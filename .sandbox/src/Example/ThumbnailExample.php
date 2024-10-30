<?php

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class ThumbnailExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		$thumbnail = $codex
			->Thumbnail()
			->setBackgroundImage(
				"https://upload.wikimedia.org/wikipedia/commons/thumb/2/21/64_365_Color_Macro_%285498808099%29.jpg/" .
				"200px-64_365_Color_Macro_%285498808099%29.jpg"
			)
			->setAttributes( [
				"class" => "foo",
				"bar" => "baz",
			] )
			->build()
			->getHtml();

		$thumbnailPlaceholder = $codex
			->Thumbnail()
			->setAttributes( [
				"class" => "foo",
				"bar" => "baz",
			] )
			->build()
			->getHtml();

		return $thumbnail . $thumbnailPlaceholder;
	}
}
