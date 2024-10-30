<?php

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class FieldExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		$checkbox1 = $codex
			->Checkbox()
			->setInputId( "email-allow-others" )
			->setLabel(
				$codex
					->Label()
					->setLabelText(
						"Allow other users to email me"
					)
					->build()
			)
			->build()
			->getHtml();

		$checkbox2 = $codex
			->Checkbox()
			->setInputId( "email-allow-new" )
			->setLabel(
				$codex
					->Label()
					->setLabelText(
						"Allow emails from brand-new users"
					)
					->build()
			)
			->build()
			->getHtml();

		return $codex
			->Field()
			->setLabel(
				$codex
					->Label()
					->setLabelText( "Email confirmation" )
					->setDescription( "Specify an email address in your preferences for these features to work." )
					->setOptional( true )
					->build()
			)
			->setFields( [ $checkbox1, $checkbox2 ] )
			->setIsFieldset( true )
			->setAttributes( [
				"class" => "foo",
				"bar" => "baz",
				"id" => "email-confirmation-fieldset",
				"data-category" => "email-options",
			] )
			->build()
			->getHtml();
	}
}
