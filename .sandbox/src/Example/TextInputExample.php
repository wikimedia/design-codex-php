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
			->setInputId( "usernameInput" )
			->setPlaceholder( "Enter your username" )
			->setHasStartIcon( false )
			->setHasEndIcon( false )
			->setDisabled( false )
			->setHasError( false )
			->setWrapperAttributes( [
				"class" => "foo",
				"data-toggle" => "example-action",
			] )
			->setInputAttributes( [
				"class" => "bar",
				"autocomplete" => "username",
			] )
			->build()
			->getHtml();
	}
}
