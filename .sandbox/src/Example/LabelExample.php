<?php

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class LabelExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		return $codex
			->Label()
			->setLabelText( "Username" )
			->setOptional( true )
			->setDescription( "Please enter a your username." )
			->setId( "username" )
			->setAttributes( [
				"class" => "foo",
				"data-info" => "username-input-label",
			] )
			->setIsLegend( false )
			->setInputId( "usernameInput" )
			->build()
			->getHtml();
	}
}
