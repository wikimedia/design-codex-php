<?php

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
			action: 'default',
			weight: 'normal',
			size: 'medium',
			iconOnly: false,
			attributes: [
				'class' => 'foo',
				'id' => 'example-button-1',
				'data-toggle' => 'example-action',
			]
		);

		$progressiveNormal = $codex->button(
			label: 'Progressive',
			action: 'progressive',
			weight: 'normal',
			size: 'medium',
			iconOnly: false,
			attributes: [
				'id' => 'example-button-2',
				'data-toggle' => 'example-action',
			]
		);

		$destructiveNormal = $codex->button(
			label: 'Destructive',
			action: 'destructive',
			weight: 'normal',
			size: 'medium',
			iconOnly: false,
			attributes: [
				'id' => 'example-button-3',
				'data-toggle' => 'example-action',
			]
		);

		$progressive = $codex->button(
			label: 'Progressive primary',
			action: 'progressive',
			weight: 'primary',
			size: 'medium',
			iconOnly: false,
			attributes: [
				'id' => 'example-button-4',
				'data-toggle' => 'example-action',
			]
		);

		$destructive = $codex->button(
			label: 'Destructive primary',
			action: 'destructive',
			weight: 'primary',
			size: 'medium',
			iconOnly: false,
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
		$linkButton = $codex->button(
			label: 'Link Button Example',
			attributes: [
				'id' => 'example-button-7',
			],
			href: '#'
		);

		return $default .
			$progressiveNormal .
			$destructiveNormal .
			$progressive .
			$destructive .
			$disabled .
			$iconOnly .
			$linkButton;
	}
}
