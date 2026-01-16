<?php

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class CardExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		return $codex->Card(
			title: 'Codex Card Example',
			description: $codex->htmlSnippet(
				'This is an <strong>example</strong> card using the Codex design system.'
			),
			supportingText: 'Additional supporting text goes here.',
			thumbnail: $codex->Thumbnail()
				->setBackgroundImage(
					'https://upload.wikimedia.org/wikipedia/commons/thumb/2/21/' .
					'64_365_Color_Macro_%285498808099%29.jpg/ ' .
					'200px-64_365_Color_Macro_%285498808099%29.jpg'
				)->build(),
			url: 'https://www.example.com',
			attributes: [
				'class' => 'foo',
				'bar' => 'baz',
			]
		);
	}
}
