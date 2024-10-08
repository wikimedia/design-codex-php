<?php

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class AccordionExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		return $codex
			->accordion()
			->setTitle( "Accordion Example" )
			->setDescription( "This is an example of an accordion." )
			->setContentHtml(
				$codex
					->htmlSnippet()
					->setContent( "<p>This is the content of the accordion.</p>" )
					->build()
			)
			->setOpen( false )
			->setAttributes( [
				"class" => "foo bar baz",
				"foo" => "bar",
				"baz" => "qux",
			] )
			->build()
			->getHtml();
	}
}
