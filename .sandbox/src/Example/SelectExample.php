<?php

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class SelectExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		return $codex
			->Select()
			->setOptions( [
				"val1" => "Standalone Option 1",
				"val2" => "Standalone Option 2",
			] )
			->setOptGroups( [
				"Group 1" => [
					"val3" => "Option in Group 1",
					[
						"value" => "val4",
						"text" => "Another Option in Group 1",
						"selected" => true,
					],
				],
				"Group 2" => [
					"val5" => "Option in Group 2",
					[
						"value" => "val6",
						"text" => "Another Option in Group 2",
					],
				],
			] )
			->setAttributes( [
				"class" => "foo",
				"bar" => "baz",
				"id" => "example-select",
				"name" => "exampleSelection",
				"data-category" => "selection",
			] )
			->setDisabled( false )
			->build()
			->getHtml();
	}
}
