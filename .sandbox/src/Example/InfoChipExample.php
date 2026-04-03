<?php
declare( strict_types = 1 );

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class InfoChipExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		$infoChip = $codex->InfoChip(
			text: 'Info Chip',
			attributes: [
				'class' => 'foo',
				'bar' => 'baz',
			]
		);

		$infoChipNormal = $codex->InfoChip(
			text: 'Notice',
			attributes: [
				'class' => 'foo',
				'bar' => 'baz',
			],
			status: 'notice'
		);

		$infoChipWarning = $codex->InfoChip(
			text: 'Warning',
			attributes: [
				'class' => 'foo',
				'bar' => 'baz',
			],
			status: 'warning'
		);

		$infoChipError = $codex->InfoChip(
			text: 'Error',
			attributes: [
				'class' => 'foo',
				'bar' => 'baz',
			],
			status: 'error'
		);

		$infoChipSuccess = $codex->InfoChip(
			text: 'Success',
			attributes: [
				'class' => 'foo',
				'bar' => 'baz',
			],
			status: 'success'
		);

		$infoChipNormalWithCustomIcon = $codex->InfoChip(
			text: $codex->htmlSnippet( 'With <em>Custom</em> Icon' ),
			attributes: [
				'class' => 'foo',
				'bar' => 'baz',
			],
			status: 'notice',
			icon: 'cdx-table__table__sort-icon--asc'
		);

		return $infoChip . $infoChipNormal . $infoChipWarning . $infoChipError . $infoChipSuccess .
			$infoChipNormalWithCustomIcon;
	}
}
