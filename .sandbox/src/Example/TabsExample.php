<?php
declare( strict_types = 1 );

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
			->Tab(
				name: 'tab1',
				label: 'Tab 1',
				content: $codex->htmlSnippet( '<p>Content 1.</p>' ),
				selected: true
			);

		$tab2 = $codex
			->Tab(
				name: 'tab2',
				label: 'Tab 2',
				content: $codex->htmlSnippet( '<p>Content 2.</p>' )
			);

		$tab3 = $codex
			->Tab(
				name: 'tab3',
				label: 'Tab 3',
				content: $codex->htmlSnippet( '<p>Content 3.</p>' )
			);

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
