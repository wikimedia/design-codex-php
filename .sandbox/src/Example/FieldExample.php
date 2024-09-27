<?php

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class FieldExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		$checkbox = $codex
			->Checkbox()
			->setInputId( "checkbox-description-css-only-2" )
			->setLabel(
				$codex
					->Label()
					->setId( "label-test" )
					->setLabelText(
						"Send password reset emails only when both email address and username are provided."
					)
					->setDescription(
						"This improves privacy and helps prevent unsolicited emails."
					)
					->setAttributes( [
						"class" => "foo",
						"bar" => "baz",
					] )
					->setDescriptionId( "cdx-description-css-2" )
					->build()
			)
			->setInputAttributes( [
				"class" => "foo",
				"bar" => "baz",
			] )
			->setWrapperAttributes( [
				"class" => "foo",
				"bar" => "baz",
			] )
			->build()
			->getHtml();

		return $codex
			->Field()
			->setLabel(
				$codex
					->Label()
					->setLabelText( "User Information" )
					->setDescription( "Please fill out the details below." )
					->setOptional( true )
					->build()
			)
			->setFields( [ $checkbox ] )
			->setIsFieldset( true )
			->setAttributes( [
				"class" => "foo",
				"bar" => "baz",
				"id" => "user-info-fieldset",
				"data-category" => "user-data",
				"aria-labelledby" => "legend-user-info",
			] )
			->build()
			->getHtml();
	}
}
