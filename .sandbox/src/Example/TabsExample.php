<?php

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class TabsExample {
	/**
	 * @param Codex $codex
	 *
	 * @return string
	 */
	public static function create(
		Codex $codex
	): string {
		$tab1 = $codex
			->Tab()
			->setName( "tab1" )
			->setLabel( "Tab 1" )
			->setContentHtml(
				$codex
					->htmlSnippet()
					->setContent( "<p>Content 1.</p>" )
					->build()
			)
			->setSelected( true )
			->build();

		$tab2 = $codex
			->Tab()
			->setName( "tab2" )
			->setLabel( "Tab 2" )
			->setContentHtml(
				$codex
					->htmlSnippet()
					->setContent( "<p>Content 2.</p>" )
					->build()
			)
			->build();

		$tab3 = $codex
			->Tab()
			->setName( "tab3" )
			->setLabel( "Tab 3" )
			->setContentHtml(
				$codex
					->htmlSnippet()
					->setContent( "<p>Content 3.</p>" )
					->build()
			)
			->build();

		return $codex
			->Tabs()
			->setTab( [ $tab1, $tab2, $tab3 ] )
			->setAttributes( [
				"class" => "foo",
				"bar" => "baz",
				"id" => "example-tabs",
				"data-category" => "feedback",
			] )
			->build()
			->getHtml();
	}
}
