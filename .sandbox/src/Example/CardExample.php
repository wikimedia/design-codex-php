<?php

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class CardExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		return $codex
			->Card()
			->setTitle( "Codex Card Example" )
			->setDescription(
				"This is an example card using the Codex design system."
			)
			->setSupportingText( "Additional supporting text goes here." )
			->setThumbnail( $codex->Thumbnail()
			->setBackgroundImage(
				"https://upload.wikimedia.org/wikipedia/commons/thumb/2/21/64_365_Color_Macro_%285498808099%29.jpg/" .
				"200px-64_365_Color_Macro_%285498808099%29.jpg"
			)
				->build()
			)
			->setUrl( "https://www.example.com" )
			->setAttributes( [
				"class" => "foo",
				"bar" => "baz",
			] )
			->build()
			->getHtml();
	}
}
