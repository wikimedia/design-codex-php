<?php

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class InfoChipExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		$infoChip = $codex
			->InfoChip()
			->setText( "Info Chip" )
			->setAttributes( [
				"class" => "foo",
				"bar" => "baz",
			] )
			->build()
			->getHtml();

		$infoChipNormal = $codex
			->InfoChip()
			->setText( "Notice" )
			->setAttributes( [
				"class" => "foo",
				"bar" => "baz",
			] )
			->setStatus( "notice" )
			->build()
			->getHtml();

		$infoChipWarning = $codex
			->InfoChip()
			->setText( "Warning" )
			->setAttributes( [
				"class" => "foo",
				"bar" => "baz",
			] )
			->setStatus( "warning" )
			->build()
			->getHtml();

		$infoChipError = $codex
			->InfoChip()
			->setText( "Error" )
			->setAttributes( [
				"class" => "foo",
				"bar" => "baz",
			] )
			->setStatus( "error" )
			->build()
			->getHtml();

		$infoChipSuccess = $codex
			->InfoChip()
			->setText( "Success" )
			->setAttributes( [
				"class" => "foo",
				"bar" => "baz",
			] )
			->setStatus( "success" )
			->build()
			->getHtml();

		$infoChipNormalWithCustomIcon = $codex
			->InfoChip()
			->setText(
				$codex->htmlSnippet( "With <em>Custom</em> Icon" )
			)
			->setAttributes( [
				"class" => "foo",
				"bar" => "baz",
			] )
			->setStatus( "notice" )
			->setIcon( 'cdx-table__table__sort-icon--asc' )
			->build()
			->getHtml();

		return $infoChip . $infoChipNormal . $infoChipWarning . $infoChipError . $infoChipSuccess .
			$infoChipNormalWithCustomIcon;
	}
}
