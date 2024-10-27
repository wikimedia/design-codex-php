<?php

namespace Wikimedia\Codex\Sandbox\Example;

use Wikimedia\Codex\Utility\Codex;

class ToggleSwitchExample {
	/**
	 * @param Codex $codex
	 * @return string
	 */
	public static function create( Codex $codex ): string {
		return $codex
			->ToggleSwitch()
			->setInputId( "cdx-toggle-switch-css-1" )
			->setLabel(
				$codex
					->Label()
					->setLabelText( "Visual editing mode" )
					->setDescription(
						"Turn on to use the visual editor. You can switch back to source mode at any time" )
					->setDescriptionId( "cdx-description-css-1" )
					->build()
			)
			->setChecked( false )
			->setDisabled( false )
			->setInputAttributes( [
				'foo' => 'bar'
			] )
			->build()
			->getHtml();
	}
}
