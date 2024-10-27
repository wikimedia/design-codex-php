<?php
/**
 * Codex.php
 *
 * This class provides factory methods to create instances of various builders,
 * including Accordion, Button, Card, Checkbox, and others. These builders facilitate
 * the creation of standardized UI components adhering to the Codex design principles.
 *
 * Each builder follows the builder pattern, allowing for easy and fluent creation
 * and customization of components used across Wikimedia projects.
 *
 * @category Utility
 * @package  Codex\Utility
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */

namespace Wikimedia\Codex\Utility;

use Wikimedia\Codex\Builder\AccordionBuilder;
use Wikimedia\Codex\Builder\ButtonBuilder;
use Wikimedia\Codex\Builder\CardBuilder;
use Wikimedia\Codex\Builder\CheckboxBuilder;
use Wikimedia\Codex\Builder\FieldBuilder;
use Wikimedia\Codex\Builder\HtmlSnippetBuilder;
use Wikimedia\Codex\Builder\InfoChipBuilder;
use Wikimedia\Codex\Builder\LabelBuilder;
use Wikimedia\Codex\Builder\MessageBuilder;
use Wikimedia\Codex\Builder\OptionBuilder;
use Wikimedia\Codex\Builder\PagerBuilder;
use Wikimedia\Codex\Builder\ProgressBarBuilder;
use Wikimedia\Codex\Builder\RadioBuilder;
use Wikimedia\Codex\Builder\SelectBuilder;
use Wikimedia\Codex\Builder\TabBuilder;
use Wikimedia\Codex\Builder\TableBuilder;
use Wikimedia\Codex\Builder\TabsBuilder;
use Wikimedia\Codex\Builder\TextAreaBuilder;
use Wikimedia\Codex\Builder\TextInputBuilder;
use Wikimedia\Codex\Builder\ThumbnailBuilder;
use Wikimedia\Codex\Builder\ToggleSwitchBuilder;
use Wikimedia\Codex\Infrastructure\CodexServices;

/**
 * Codex UI
 *
 * This class provides methods for creating instances of various builders, each
 * corresponding to a UI component in the Codex design system. These builders allow
 * the creation and customization of Codex components.
 *
 * @category Utility
 * @package  Codex\Utility
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */
class Codex {

	/**
	 * The CodexServices instance that manages services.
	 */
	private CodexServices $services;

	/**
	 * Constructor initializes CodexServices.
	 *
	 * @since 0.1.0
	 */
	public function __construct() {
		$this->services = CodexServices::getInstance();
	}

	/**
	 * Resolves and returns the Accordion builder.
	 *
	 * @since 0.1.0
	 * @return AccordionBuilder The Accordion builder instance.
	 */
	public function accordion(): AccordionBuilder {
		return $this->services->getService( 'AccordionBuilder' );
	}

	/**
	 * Resolves and returns the Button builder.
	 *
	 * @since 0.1.0
	 * @return ButtonBuilder The Button builder instance.
	 */
	public function button(): ButtonBuilder {
		return $this->services->getService( 'ButtonBuilder' );
	}

	/**
	 * Resolves and returns the Card builder.
	 *
	 * @since 0.1.0
	 * @return CardBuilder The Card builder instance.
	 */
	public function card(): CardBuilder {
		return $this->services->getService( 'CardBuilder' );
	}

	/**
	 * Resolves and returns the Checkbox builder.
	 *
	 * @since 0.1.0
	 * @return CheckboxBuilder The Checkbox builder instance.
	 */
	public function checkbox(): CheckboxBuilder {
		return $this->services->getService( 'CheckboxBuilder' );
	}

	/**
	 * Resolves and returns the Field builder.
	 *
	 * @since 0.1.0
	 * @return FieldBuilder The Field builder instance.
	 */
	public function field(): FieldBuilder {
		return $this->services->getService( 'FieldBuilder' );
	}

	/**
	 * Resolves and returns the HtmlSnippet.
	 *
	 * @since 0.1.0
	 * @return HtmlSnippetBuilder The HtmlSnippet instance.
	 */
	public function htmlSnippet(): HtmlSnippetBuilder {
		return $this->services->getService( 'HtmlSnippetBuilder' );
	}

	/**
	 * Resolves and returns the InfoChip builder.
	 *
	 * @since 0.1.0
	 * @return InfoChipBuilder The InfoChip builder instance.
	 */
	public function infoChip(): InfoChipBuilder {
		return $this->services->getService( 'InfoChipBuilder' );
	}

	/**
	 * Resolves and returns the Label builder.
	 *
	 * @since 0.1.0
	 * @return LabelBuilder The Label builder instance.
	 */
	public function label(): LabelBuilder {
		return $this->services->getService( 'LabelBuilder' );
	}

	/**
	 * Resolves and returns the Message builder.
	 *
	 * @since 0.1.0
	 * @return MessageBuilder The Message builder instance.
	 */
	public function message(): MessageBuilder {
		return $this->services->getService( 'MessageBuilder' );
	}

	/**
	 * Resolves and returns the Option builder.
	 *
	 * @since 0.1.0
	 * @return OptionBuilder The Option builder instance.
	 */
	public function option(): OptionBuilder {
		return $this->services->getService( 'OptionBuilder' );
	}

	/**
	 * Resolves and returns the Pager builder.
	 *
	 * @since 0.1.0
	 * @return PagerBuilder The Pager builder instance.
	 */
	public function pager(): PagerBuilder {
		return $this->services->getService( 'PagerBuilder' );
	}

	/**
	 * Resolves and returns the ProgressBar builder.
	 *
	 * @since 0.1.0
	 * @return ProgressBarBuilder The ProgressBar builder instance.
	 */
	public function progressBar(): ProgressBarBuilder {
		return $this->services->getService( 'ProgressBarBuilder' );
	}

	/**
	 * Resolves and returns the Radio builder.
	 *
	 * @since 0.1.0
	 * @return RadioBuilder The Radio builder instance.
	 */
	public function radio(): RadioBuilder {
		return $this->services->getService( 'RadioBuilder' );
	}

	/**
	 * Resolves and returns the Select builder.
	 *
	 * @since 0.1.0
	 * @return SelectBuilder The Select builder instance.
	 */
	public function select(): SelectBuilder {
		return $this->services->getService( 'SelectBuilder' );
	}

	/**
	 * Resolves and returns the Tab builder.
	 *
	 * @since 0.1.0
	 * @return TabBuilder The Tab builder instance.
	 */
	public function tab(): TabBuilder {
		return $this->services->getService( 'TabBuilder' );
	}

	/**
	 * Resolves and returns the Table builder.
	 *
	 * @since 0.1.0
	 * @return TableBuilder The Table builder instance.
	 */
	public function table(): TableBuilder {
		return $this->services->getService( 'TableBuilder' );
	}

	/**
	 * Resolves and returns the Tabs builder.
	 *
	 * @since 0.1.0
	 * @return TabsBuilder The Tabs builder instance.
	 */
	public function tabs(): TabsBuilder {
		return $this->services->getService( 'TabsBuilder' );
	}

	/**
	 * Resolves and returns the TextArea builder.
	 *
	 * @since 0.1.0
	 * @return TextAreaBuilder The TextArea builder instance.
	 */
	public function textArea(): TextAreaBuilder {
		return $this->services->getService( 'TextAreaBuilder' );
	}

	/**
	 * Resolves and returns the TextInput builder.
	 *
	 * @since 0.1.0
	 * @return TextInputBuilder The TextInput builder instance.
	 */
	public function textInput(): TextInputBuilder {
		return $this->services->getService( 'TextInputBuilder' );
	}

	/**
	 * Resolves and returns the Thumbnail builder.
	 *
	 * @since 0.1.0
	 * @return ThumbnailBuilder The Thumbnail builder instance.
	 */
	public function thumbnail(): ThumbnailBuilder {
		return $this->services->getService( 'ThumbnailBuilder' );
	}

	/**
	 * Resolves and returns the ToggleSwitch builder.
	 *
	 * @since 0.1.0
	 * @return ToggleSwitchBuilder The ToggleSwitch builder instance.
	 */
	public function toggleSwitch(): ToggleSwitchBuilder {
		return $this->services->getService( 'ToggleSwitchBuilder' );
	}
}
