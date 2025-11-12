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
			->setDescription( $codex->htmlSnippet( 'Accordion <em>description</em>' ) )
			->setContent( $codex->htmlSnippet(
				"<p>This is the <strong>content</strong> of the accordion.</p>"
			) )
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
