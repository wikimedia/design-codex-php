<?php
/**
 * TextInput.php
 *
 * This file is part of the Codex design system, the official design system for Wikimedia projects.
 * It contains the definition and implementation of the `TextInput` class, responsible for managing
 * the behavior and properties of the corresponding component.
 *
 * @category Component
 * @package  Codex\Component
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */

namespace Wikimedia\Codex\Component;

use Wikimedia\Codex\Contract\Renderer\IRenderer;

/**
 * TextInput
 *
 * This class is part of the Codex PHP library and is responsible for
 * representing an immutable object. It is primarily intended for use
 * with a builder class to construct its instances.
 *
 * @category Component
 * @package  Codex\Component
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */
class TextInput {

	/**
	 * Input field type.
	 */
	private string $type;

	/**
	 * Whether the input field has a start icon.
	 */
	private bool $hasStartIcon;

	/**
	 * Whether the input field has an end icon.
	 */
	private bool $hasEndIcon;

	/**
	 * Whether the input field is disabled.
	 */
	private bool $disabled;

	/**
	 * Whether the input field is in an error state.
	 */
	private bool $hasError;

	/**
	 * The CSS class for the start icon.
	 */
	private string $startIconClass;

	/**
	 * The CSS class for the end icon.
	 */
	private string $endIconClass;

	/**
	 * Additional HTML attributes for the input element.
	 */
	private array $inputAttributes;

	/**
	 * Additional HTML attributes for the wrapper element.
	 */
	private array $wrapperAttributes;

	/**
	 * The placeholder text for the input field.
	 */
	private string $placeholder;

	/**
	 * The name attribute of the input field.
	 */
	private string $name;

	/**
	 * The value attribute of the input field.
	 */
	private string $value;

	/**
	 * The ID attribute for the input field.
	 */
	private string $inputId;

	/**
	 * The renderer instance used to render the text input.
	 */
	private IRenderer $renderer;

	/**
	 * Constructor for the TextInput component.
	 *
	 * Initializes a TextInput instance with the specified properties.
	 *
	 * @param string $type The type of the input field (e.g., 'text', 'email').
	 * @param bool $hasStartIcon Indicates if the input has a start icon.
	 * @param bool $hasEndIcon Indicates if the input has an end icon.
	 * @param bool $disabled Indicates if the input is disabled.
	 * @param bool $hasError Indicates if the input is in an error state.
	 * @param string $startIconClass CSS class for the start icon.
	 * @param string $endIconClass CSS class for the end icon.
	 * @param array $inputAttributes Additional HTML attributes for the input element.
	 * @param array $wrapperAttributes Additional HTML attributes for the wrapper element.
	 * @param string $placeholder Placeholder text for the input.
	 * @param string $name Name attribute of the input.
	 * @param string $value Default value of the input.
	 * @param string $inputId ID attribute for the input.
	 * @param IRenderer $renderer The renderer to use for rendering the text input.
	 */
	public function __construct(
		string $type,
		bool $hasStartIcon,
		bool $hasEndIcon,
		bool $disabled,
		bool $hasError,
		string $startIconClass,
		string $endIconClass,
		array $inputAttributes,
		array $wrapperAttributes,
		string $placeholder,
		string $name,
		string $value,
		string $inputId,
		IRenderer $renderer
	) {
		$this->type = $type;
		$this->hasStartIcon = $hasStartIcon;
		$this->hasEndIcon = $hasEndIcon;
		$this->disabled = $disabled;
		$this->hasError = $hasError;
		$this->startIconClass = $startIconClass;
		$this->endIconClass = $endIconClass;
		$this->inputAttributes = $inputAttributes;
		$this->wrapperAttributes = $wrapperAttributes;
		$this->placeholder = $placeholder;
		$this->name = $name;
		$this->value = $value;
		$this->inputId = $inputId;
		$this->renderer = $renderer;
	}

	/**
	 * Get the type of the input field.
	 *
	 * This method returns the type attribute of the input field, which determines the type of data
	 * the input field accepts (e.g., 'text', 'email', 'password').
	 *
	 * @since 0.1.0
	 * @return string The type of the input field.
	 */
	public function getType(): string {
		return $this->type;
	}

	/**
	 * Get the name attribute of the input field.
	 *
	 * This method returns the name attribute of the input field, which is used to identify the input
	 * form control when submitting the form data.
	 *
	 * @since 0.1.0
	 * @return string The name attribute of the input field.
	 */
	public function getName(): string {
		return $this->name;
	}

	/**
	 * Get the value of the input field.
	 *
	 * This method returns the current value of the input field.
	 *
	 * @since 0.1.0
	 * @return string The value of the input field.
	 */
	public function getValue(): string {
		return $this->value;
	}

	/**
	 * Get the placeholder text of the input field.
	 *
	 * This method returns the placeholder text, which is displayed when the input field is empty.
	 * It provides a hint to the user about what should be entered in the field.
	 *
	 * @since 0.1.0
	 * @return string The placeholder text of the input field.
	 */
	public function getPlaceholder(): string {
		return $this->placeholder;
	}

	/**
	 * Get the ID of the input field.
	 *
	 * This method returns the ID attribute of the input field, which is useful for linking
	 * the input field to a label or for other JavaScript interactions.
	 *
	 * @since 0.1.0
	 * @return string The ID of the input field.
	 */
	public function getInputId(): string {
		return $this->inputId;
	}

	/**
	 * Check if the input field has a start icon.
	 *
	 * This method returns a boolean value indicating whether the input field has an icon at the start.
	 *
	 * @since 0.1.0
	 * @return bool True if the input field has a start icon, false otherwise.
	 */
	public function hasStartIcon(): bool {
		return $this->hasStartIcon;
	}

	/**
	 * Check if the input field has an end icon.
	 *
	 * This method returns a boolean value indicating whether the input field has an icon at the end.
	 *
	 * @since 0.1.0
	 * @return bool True if the input field has an end icon, false otherwise.
	 */
	public function hasEndIcon(): bool {
		return $this->hasEndIcon;
	}

	/**
	 * Get the CSS class for the start icon.
	 *
	 * This method returns the CSS class that is applied to the start icon, which can be used to style
	 * the icon or apply a background image.
	 *
	 * @since 0.1.0
	 * @return string The CSS class for the start icon.
	 */
	public function getStartIconClass(): string {
		return $this->startIconClass;
	}

	/**
	 * Get the CSS class for the end icon.
	 *
	 * This method returns the CSS class that is applied to the end icon, which can be used to style
	 * the icon or apply a background image.
	 *
	 * @since 0.1.0
	 * @return string The CSS class for the end icon.
	 */
	public function getEndIconClass(): string {
		return $this->endIconClass;
	}

	/**
	 * Check if the input field is disabled.
	 *
	 * This method returns a boolean value indicating whether the input field is disabled, making it uneditable.
	 *
	 * @since 0.1.0
	 * @return bool True if the input field is disabled, false otherwise.
	 */
	public function isDisabled(): bool {
		return $this->disabled;
	}

	/**
	 * Check if the input field is in an error state.
	 *
	 * This method returns a boolean value indicating whether the input field is in an error state,
	 * typically by applying a specific CSS class that changes its appearance.
	 *
	 * @since 0.1.0
	 * @return bool True if the input field is in an error state, false otherwise.
	 */
	public function hasError(): bool {
		return $this->hasError;
	}

	/**
	 * Get additional HTML attributes for the input element.
	 *
	 * This method returns an associative array of custom HTML attributes that are applied to the input element,
	 * such as `data-*`, `aria-*`, or any other valid attributes that enhance functionality or accessibility.
	 *
	 * @since 0.1.0
	 * @return array The associative array of HTML attributes for the input element.
	 */
	public function getInputAttributes(): array {
		return $this->inputAttributes;
	}

	/**
	 * Get additional HTML attributes for the outer wrapper element.
	 *
	 * This method returns an associative array of custom HTML attributes that are applied to the outer wrapper element,
	 * enhancing its behavior or styling.
	 *
	 * @since 0.1.0
	 * @return array The associative array of HTML attributes for the wrapper element.
	 */
	public function getWrapperAttributes(): array {
		return $this->wrapperAttributes;
	}

	/**
	 * Get the component's HTML representation.
	 *
	 * This method generates the HTML markup for the component, incorporating relevant properties
	 * and any additional attributes. The component is structured using appropriate HTML elements
	 * as defined by the implementation.
	 *
	 * @since 0.1.0
	 * @return string The generated HTML string for the component.
	 */
	public function getHtml(): string {
		return $this->renderer->render( $this );
	}
}
