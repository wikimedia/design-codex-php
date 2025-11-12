<?php

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class ButtonExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		$default = $codex
			->button()
			->setLabel( "Default" )
			->setAction( "default" )
			->setWeight( "normal" )
			->setSize( "medium" )
			->setIconOnly( false )
			->setId( "example-button-1" )
			->setAttributes( [
				"class" => "foo",
				"id" => "example-button",
				"data-toggle" => "example-action",
			] )
			->build()
			->getHtml();

		$progressiveNormal = $codex
			->button()
			->setLabel( "Progressive" )
			->setAction( "progressive" )
			->setWeight( "normal" )
			->setSize( "medium" )
			->setIconOnly( false )
			->setId( "example-button-2" )
			->setAttributes( [
				"data-toggle" => "example-action",
			] )
			->build()
			->getHtml();

		$destructiveNormal = $codex
			->button()
			->setLabel( "Destructive" )
			->setAction( "destructive" )
			->setWeight( "normal" )
			->setSize( "medium" )
			->setIconOnly( false )
			->setId( "example-button-3" )
			->setAttributes( [
				"data-toggle" => "example-action",
			] )
			->build()
			->getHtml();

		$progressive = $codex
			->button()
			->setLabel( "Progressive primary" )
			->setAction( "progressive" )
			->setWeight( "primary" )
			->setSize( "medium" )
			->setIconOnly( false )
			->setId( "example-button-4" )
			->setAttributes( [
				"data-toggle" => "example-action",
			] )
			->build()
			->getHtml();

		$destructive = $codex
			->button()
			->setLabel( "Destructive primary" )
			->setAction( "destructive" )
			->setWeight( "primary" )
			->setSize( "medium" )
			->setIconOnly( false )
			->setId( "example-button-5" )
			->setAttributes( [
				"data-toggle" => "example-action",
			] )
			->build()
			->getHtml();

		$disabled = $codex
			->button()
			->setLabel( "Disabled" )
			->setDisabled( true )
			->setId( "example-button-6" )
			->build()
			->getHtml();

		$iconOnly = $codex
			->button()
			->setIconOnly( true )
			->setAttributes( [
				// Note that class is used to apply an icon image.
				"class" => "cdx-icon--add",
				"aria-label" => "Icon-only button",
			] )
			->build()
			->getHtml();

		return $default .
			$progressiveNormal .
			$destructiveNormal .
			$progressive .
			$destructive .
			$disabled .
			$iconOnly;
	}
}
