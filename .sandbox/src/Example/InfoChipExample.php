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
			status: 'notice',
			attributes: [
				'class' => 'foo',
				'bar' => 'baz',
			],
		);

		$infoChipWarning = $codex->InfoChip(
			text: 'Warning',
			status: 'warning',
			attributes: [
				'class' => 'foo',
				'bar' => 'baz',
			],
		);

		$infoChipError = $codex->InfoChip(
			text: 'Error',
			status: 'error',
			attributes: [
				'class' => 'foo',
				'bar' => 'baz',
			],
		);

		$infoChipSuccess = $codex->InfoChip(
			text: 'Success',
			status: 'success',
			attributes: [
				'class' => 'foo',
				'bar' => 'baz',
			],
		);

		$infoChipNormalWithCustomIcon = $codex->InfoChip(
			text: $codex->htmlSnippet( 'With <em>Custom</em> Icon' ),
			status: 'notice',
			icon: 'cdx-table__table__sort-icon--asc',
			attributes: [
				'class' => 'foo',
				'bar' => 'baz',
			],
		);

		return $infoChip . $infoChipNormal . $infoChipWarning . $infoChipError . $infoChipSuccess .
			$infoChipNormalWithCustomIcon;
	}
}
