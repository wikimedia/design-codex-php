<?php

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class TextInputExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		return $codex
			->TextInput()
			->setType( "text" )
			->setName( "username" )
			->setInputId( "username-input" )
			->setPlaceholder( "Enter your username" )
			->setHasStartIcon( true )
			// Icon image is set in this page's CSS via this class.
			->setStartIconClass( 'cdx-icon--login' )
			->setHasEndIcon( false )
			->setDisabled( false )
			->setStatus( 'default' )
			->setWrapperAttributes( [
				"class" => "foo",
				"data-toggle" => "example-action",
			] )
			->setInputAttributes( [
				"class" => "bar",
				"autocomplete" => "username",
				"aria-label" => "Username"
			] )
			->build()
			->getHtml();
	}
}
