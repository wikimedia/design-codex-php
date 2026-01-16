<?php

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class ThumbnailExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		$thumbnail = $codex->Thumbnail(
			backgroundImage: "https://upload.wikimedia.org/wikipedia/commons/thumb/2/21/" .
				"64_365_Color_Macro_%285498808099%29.jpg/200px-64_365_Color_Macro_%285498808099%29.jpg",
			attributes: [
				"class" => "foo",
				"bar" => "baz",
			]
		);

		$thumbnailPlaceholder = $codex->Thumbnail(
			attributes: [
				"class" => "foo",
				"bar" => "baz",
			]
		);

		return $thumbnail . $thumbnailPlaceholder;
	}
}
