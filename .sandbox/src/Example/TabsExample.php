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
					->htmlSnippet( "<p>Content 1.</p>" )
			)
			->setSelected( true )
			->build();

		$tab2 = $codex
			->Tab()
			->setName( "tab2" )
			->setLabel( "Tab 2" )
			->setContentHtml(
				$codex
					->htmlSnippet( "<p>Content 2.</p>" )
			)
			->build();

		$tab3 = $codex
			->Tab()
			->setName( "tab3" )
			->setLabel( "Tab 3" )
			->setContentHtml(
				$codex
					->htmlSnippet( "<p>Content 3.</p>" )
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
