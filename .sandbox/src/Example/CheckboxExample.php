<?php

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class CheckboxExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		return $codex
			->Checkbox()
			->setInputId( "checkbox-description-css-only-1" )
			->setLabel(
				$codex
					->Label()
					->setLabelText(
						"Send password reset emails only when both email address and username are provided."
					)
					->setDescription(
						"This improves privacy and helps prevent unsolicited emails."
					)
					->setDescriptionId( "cdx-description-css-1" )
					->build()
			)
			->setWrapperAttributes( [
				"class" => "foo",
			] )
			->setInputAttributes( [
				"class" => "bar",
				"data-toggle" => "checkbox-option",
				"aria-label" => "Checkbox input 1",
			] )
			->build()
			->getHtml();
	}
}
