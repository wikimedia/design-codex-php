<?php
declare( strict_types = 1 );

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class MessageExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		$noticeBlock = $codex->Message(
			content: 'This is a notice message.',
			type: 'notice',
			attributes: [
				'class' => 'foo',
				'bar' => 'baz',
			]
		);

		$warningBlock = $codex->Message(
			content: 'This is a warning message.',
			type: 'warning',
			attributes: [
				'class' => 'foo',
				'bar' => 'baz',
			]
		);

		$errorBlock = $codex->Message(
			content: 'This is an error message.',
			type: 'error',
			attributes:  [
				'class' => 'foo',
				'bar' => 'baz',
			]
		);

		$successBlock = $codex->Message(
			content: 'This is a success message.',
			type: 'success',
			attributes: [
				'class' => 'foo',
				'bar' => 'baz',
			]
		);

		$multiline = $codex->Message(
			content: 'The form has been submitted successfully.',
			type: 'success',
			heading: 'Success',
			attributes: [
				'class' => 'foo',
				'id' => 'success-message',
				'data-type' => 'confirmation',
			]
		);

		$noticeInline = $codex->Message(
			content: 'The form has been submitted successfully.',
			type: 'notice',
			inline: true,
			attributes: [
				'class' => 'foo',
				'bar' => 'baz',
			]
		);

		return $noticeBlock .
			$warningBlock .
			$errorBlock .
			$successBlock .
			$multiline .
			$noticeInline;
	}
}
