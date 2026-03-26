<?php
declare( strict_types = 1 );

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class ButtonExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		$default = $codex->button(
			label: 'Default',
			attributes: [
				'class' => 'foo',
				'id' => 'example-button-1',
				'data-toggle' => 'example-action',
			]
		);

		$progressiveNormal = $codex->button(
			label: 'Progressive',
			action: 'progressive',
			attributes: [
				'id' => 'example-button-2',
				'data-toggle' => 'example-action',
			]
		);

		$destructiveNormal = $codex->button(
			label: 'Destructive',
			action: 'destructive',
			attributes: [
				'id' => 'example-button-3',
				'data-toggle' => 'example-action',
			]
		);

		$progressive = $codex->button(
			label: 'Progressive primary',
			action: 'progressive',
			weight: 'primary',
			attributes: [
				'id' => 'example-button-4',
				'data-toggle' => 'example-action',
			]
		);

		$destructive = $codex->button(
			label: 'Destructive primary',
			action: 'destructive',
			weight: 'primary',
			attributes: [
				'id' => 'example-button-5',
				'data-toggle' => 'example-action',
			]
		);

		$disabled = $codex->button(
			label: 'Disabled',
			disabled: true,
			attributes: [
				'id' => 'example-button-6',
			]
		);

		$iconOnly = $codex->button(
			iconOnly: true,
			attributes: [
				// Note that class is used to apply an icon image.
				'class' => 'cdx-icon--add',
				'aria-label' => 'Icon-only button',
			]
		);

		// Large button.
		$large = $codex->button(
			label: 'Large',
			size: 'large',
			attributes: [
				'id' => 'example-button-8',
				'data-toggle' => 'example-action',
			]
		);

		// Small button.
		$small = $codex->button(
			label: 'Small',
			size: 'small',
			attributes: [
				'id' => 'example-button-9',
				'data-toggle' => 'example-action',
			]
		);

		// Quiet button.
		$quiet = $codex->button(
			label: 'Quiet',
			weight: 'quiet',
			attributes: [
				'id' => 'example-button-10',
				'data-toggle' => 'example-action',
			]
		);

		// Link buttons
		$linkButton = $codex->button(
			label: 'Link button',
			attributes: [
				'id' => 'example-button-11',
			],
			href: '#'
		);

		$progressiveLinkButton = $codex->button(
			label: 'Progressive link button',
			action: 'progressive',
			href: 'https://www.example.com',
			attributes: [
				'id' => 'example-button-12',
			]
		);

		// Disabled link button.
		$disabledLinkButton = $codex->button(
			label: 'Disabled link button',
			href: 'https://www.example.com',
			disabled: true,
			attributes: [
				'id' => 'example-button-13',
			]
		);

		return $default .
			$progressiveNormal .
			$destructiveNormal .
			$progressive .
			$destructive .
			$disabled .
			$iconOnly .
			$large .
			$small .
			$quiet .
			$linkButton .
			$progressiveLinkButton .
			$disabledLinkButton;
	}
}
