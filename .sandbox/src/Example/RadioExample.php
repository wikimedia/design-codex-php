<?php

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class RadioExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		return $codex
			->Radio()
			->setInputId( "password-reset-radio-1" )
			->setName( "password-reset-options" )
			->setLabel(
				$codex
					->Label()
					->setLabelText(
						"Send password reset emails only when both email address and username are provided."
					)
					->setDescription(
						"This improves privacy and helps prevent unsolicited emails."
					)
					->setDescriptionId( "password-reset-radio-description-1" )
					->build()
			)
			->setValue( "option1" )
			->setChecked( false )
			->setInline( false )
			->setInputAttributes( [
				"class" => "foo",
				"data-toggle" => "radio-option",
			] )
			->setWrapperAttributes( [
				"class" => "bar",
			] )
			->build()
			->getHtml();
	}
}
