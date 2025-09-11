<?php
/**
 * TabBuilder.php
 *
 * This file is part of the Codex design system, the official design system
 * for Wikimedia projects. It provides the `Tab` class, a builder for constructing
 * individual tab items within the `Tabs` component using the Codex design system.
 *
 * Tabs consist of two or more tab items created for navigating between different sections of content.
 * The `Tab` class allows for easy and flexible creation of these individual tab items.
 *
 * @category Builder
 * @package  Codex\Builder
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */

namespace Wikimedia\Codex\Builder;

use InvalidArgumentException;
use Wikimedia\Codex\Component\Tab;
use Wikimedia\Codex\Traits\ContentSetter;

/**
 * TabBuilder
 *
 * This class implements the builder pattern to construct instances of Tab.
 * It provides a fluent interface for setting various properties and building the
 * final immutable object with predefined configurations and immutability.
 *
 * @category Builder
 * @package  Codex\Builder
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */
class TabBuilder {

	use ContentSetter;

	/**
	 * The ID for the tab.
	 */
	protected string $id = '';

	/**
	 * The unique name of the tab, used for programmatic selection.
	 */
	protected string $name = '';

	/**
	 * The text label displayed for the tab in the Tabs component's header.
	 */
	protected string $label = '';

	/**
	 * Indicates whether the tab is selected by default.
	 */
	protected bool $selected = false;

	/**
	 * Indicates whether the tab is disabled, preventing interaction and navigation.
	 */
	protected bool $disabled = false;

	/**
	 * Set the tab HTML ID attribute.
	 *
	 * @since 0.1.0
	 * @param string $id The ID for the tab element.
	 * @return $this
	 */
	public function setId( string $id ): self {
		$this->id = $id;

		return $this;
	}

	/**
	 * Set the name for the tab.
	 *
	 * The name is used for programmatic selection, and it also serves as the default label if none is provided.
	 *
	 * @since 0.1.0
	 * @param string $name The unique name of the tab, used for programmatic selection.
	 * @return $this Returns the Tab instance for method chaining.
	 */
	public function setName( string $name ): self {
		if ( trim( $name ) === '' ) {
			throw new InvalidArgumentException( 'Tab name cannot be empty.' );
		}
		$this->name = $name;

		return $this;
	}

	/**
	 * Set the label for the tab.
	 *
	 * The label corresponds to the text displayed in the Tabs component's header for this tab.
	 * If not set, the label will default to the name of the tab.
	 *
	 * @since 0.1.0
	 * @param string $label The label text to be displayed in the Tabs component's header.
	 * @return $this Returns the Tab instance for method chaining.
	 */
	public function setLabel( string $label ): self {
		if ( trim( $label ) === '' ) {
			throw new InvalidArgumentException( 'Tab label cannot be empty.' );
		}
		$this->label = $label;

		return $this;
	}

	/**
	 * Set whether the tab should be selected by default.
	 *
	 * @since 0.1.0
	 * @param bool $selected Whether this tab should be selected by default.
	 * @return $this Returns the Tab instance for method chaining.
	 */
	public function setSelected( bool $selected ): self {
		$this->selected = $selected;

		return $this;
	}

	/**
	 * Set the disabled state for the tab.
	 *
	 * Disabled tabs cannot be accessed via label clicks or keyboard navigation.
	 *
	 * @since 0.1.0
	 * @param bool $disabled Whether or not the tab is disabled.
	 * @return $this Returns the Tab instance for method chaining.
	 */
	public function setDisabled( bool $disabled ): self {
		$this->disabled = $disabled;

		return $this;
	}

	/**
	 * Build and return the Tab component object.
	 * This method constructs the immutable Tab object with all the properties set via the builder.
	 *
	 * @since 0.1.0
	 * @return Tab The constructed Tab.
	 */
	public function build(): Tab {
		return new Tab(
			$this->id,
			$this->name,
			$this->label,
			$this->contentHtml,
			$this->selected,
			$this->disabled,
		);
	}
}
