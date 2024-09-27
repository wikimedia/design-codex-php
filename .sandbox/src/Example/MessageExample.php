<?php

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class MessageExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		$noticeBlock = $codex
			->Message()
			->setContentText( "This is a notice message." )
			->setType( "notice" )
			->setAttributes( [
				"class" => "foo",
				"bar" => "baz",
			] )
			->build()
			->getHtml();

		$warningBlock = $codex
			->Message()
			->setContentText( "This is a warning message." )
			->setType( "warning" )
			->setAttributes( [
				"class" => "foo",
				"bar" => "baz",
			] )
			->build()
			->getHtml();

		$errorBlock = $codex
			->Message()
			->setContentText( "This is an error message." )
			->setType( "error" )
			->setAttributes( [
				"class" => "foo",
				"bar" => "baz",
			] )
			->build()
			->getHtml();

		$successBlock = $codex
			->Message()
			->setContentText( "This is a success message." )
			->setType( "success" )
			->setAttributes( [
				"class" => "foo",
				"bar" => "baz",
			] )
			->build()
			->getHtml();

		$multiline = $codex
			->Message()
			->setContentText( "The form has been submitted successfully." )
			->setType( "success" )
			->setHeading( "Success" )
			->setAttributes( [
				"class" => "foo",
				"id" => "success-message",
				"data-type" => "confirmation",
			] )
			->build()
			->getHtml();

		$noticeInline = $codex
			->Message()
			->setContentText( "The form has been submitted successfully." )
			->setType( "notice" )
			->setInline( true )
			->setAttributes( [
				"class" => "foo",
				"bar" => "baz",
			] )
			->build()
			->getHtml();

		return $noticeBlock .
			$warningBlock .
			$errorBlock .
			$successBlock .
			$multiline .
			$noticeInline;
	}
}
