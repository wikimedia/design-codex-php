<?php
declare( strict_types = 1 );

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class AccordionExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		$none = $codex->accordion(
			title: 'Accordion Separation - None',
			description: $codex->htmlSnippet( 'Accordion <em>description</em>' ),
			content: $codex->htmlSnippet(
				'<p>This is the <strong>content</strong> of the accordion.</p>'
			),
			open: false,
			attributes: [
				'class' => 'foo bar baz',
				'foo' => 'bar',
				'baz' => 'qux',
			]
		);

		$divider = $codex->accordion(
			title: 'Accordion Separation - Divider',
			description: $codex->htmlSnippet( 'Accordion <em>description</em>' ),
			content: $codex->htmlSnippet(
				'<p>This is the <strong>content</strong> of the accordion.</p>'
			),
			open: false,
			separation:'divider',
			attributes: [
				'class' => 'foo bar baz',
				'foo' => 'bar',
				'baz' => 'qux',
			]
		);

		$outline = $codex->accordion(
			title: 'Accordion Separation - Outline',
			description: $codex->htmlSnippet( 'Accordion <em>description</em>' ),
			content: $codex->htmlSnippet(
				'<p>This is the <strong>content</strong> of the accordion.</p>'
			),
			open: false,
			separation:'outline',
			attributes: [
				'class' => 'foo bar baz',
				'foo' => 'bar',
				'baz' => 'qux',
			]
		);

		return $none .
		   $divider .
		   $outline;
	}
}
