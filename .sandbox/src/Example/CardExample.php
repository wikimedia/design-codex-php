<?php
declare( strict_types = 1 );

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class CardExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		// Card with URL.
		$cardWithUrl = $codex->Card(
			title: 'Codex Card Example',
			description: $codex->htmlSnippet(
				'This is an <strong>example</strong> card using the Codex design system.'
			),
			supportingText: 'Additional supporting text goes here.',
			thumbnail: $codex->Thumbnail(
				backgroundImage: 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/21/' .
					'64_365_Color_Macro_%285498808099%29.jpg/' .
					'200px-64_365_Color_Macro_%285498808099%29.jpg',
				),
			url: 'https://www.example.com',
			attributes: [
				'class' => 'foo',
				'bar' => 'baz',
			]
		);

		// Card without a URL.
		$cardWithoutUrl = $codex->Card(
			title: 'Codex Card Example (No URL)',
			description: $codex->htmlSnippet(
				'This is an <strong>example</strong> card without a URL set.'
			),
			supportingText: 'This card is not clickable.'
		);

		return $cardWithUrl .
			$cardWithoutUrl;
	}
}
