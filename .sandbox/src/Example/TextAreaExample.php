<?php

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class TextAreaExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		return $codex
			->TextArea()
			->setName( "user-message" )
			->setPlaceholder( "Enter your message..." )
			->setValue( "This is a default message." )
			->setId( "user-message" )
			->setTextAreaAttributes( [
				"class" => "foo",
				"data-category" => "feedback",
				"aria-label" => "Message"
			] )
			->setWrapperAttributes( [
				"class" => "bar",
				"some-attribute" => "some-value"
			] )
			->build()
			->getHtml();
	}
}
