<?php
/**
 * TextInputRenderer.php
 *
 * This file is part of the Codex PHP library, which provides a PHP-based interface for creating
 * UI components consistent with the Codex design system.
 *
 * The `TextInputRenderer` class leverages the `TemplateRenderer` and `Sanitizer` utilities to ensure the
 * component object is rendered according to Codex design system standards.
 *
 * @category Renderer
 * @package  Codex\Renderer
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */

namespace Wikimedia\Codex\Renderer;

use InvalidArgumentException;
use Wikimedia\Codex\Component\TextInput;
use Wikimedia\Codex\Contract\Renderer\IRenderer;
use Wikimedia\Codex\Contract\Renderer\ITemplateRenderer;
use Wikimedia\Codex\Traits\AttributeResolver;
use Wikimedia\Codex\Utility\Sanitizer;

/**
 * TextInputRenderer is responsible for rendering the HTML markup
 * for a TextInput component using a Mustache template.
 *
 * This class uses the `TemplateRenderer` and `Sanitizer` utilities to manage
 * the template rendering process, ensuring that the component object's HTML
 * output adheres to the Codex design system's standards.
 *
 * @category Renderer
 * @package  Codex\Renderer
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */
class TextInputRenderer implements IRenderer {

	/**
	 * Use the AttributeResolver trait
	 */
	use AttributeResolver;

	/**
	 * The sanitizer instance used for content sanitization.
	 */
	private Sanitizer $sanitizer;

	/**
	 * The template renderer instance.
	 */
	private ITemplateRenderer $templateRenderer;

	/**
	 * Constructor to initialize the TextInputRenderer with a sanitizer and a template renderer.
	 *
	 * @since 0.1.0
	 * @param Sanitizer $sanitizer The sanitizer instance used for content sanitization.
	 * @param ITemplateRenderer $templateRenderer The template renderer instance.
	 */
	public function __construct( Sanitizer $sanitizer, ITemplateRenderer $templateRenderer ) {
		$this->sanitizer = $sanitizer;
		$this->templateRenderer = $templateRenderer;
	}

	/**
	 * Renders the HTML for a text input component.
	 *
	 * Uses the provided TextInput component to generate HTML markup adhering to the Codex design system.
	 *
	 * @since 0.1.0
	 * @param TextInput $component The TextInput component to render.
	 * @return string The rendered HTML string for the component.
	 * @throws InvalidArgumentException If the provided object is not an instance of TextInput.
	 */
	public function render( $component ): string {
		if ( !$component instanceof TextInput ) {
			throw new InvalidArgumentException( "Expected instance of TextInput, got " . get_class( $component ) );
		}

		$textInputData = [
			'inputId' => $this->sanitizer->sanitizeText( $component->getInputId() ),
			'type' => $this->sanitizer->sanitizeText( $component->getType() ),
			'name' => $this->sanitizer->sanitizeText( $component->getName() ),
			'isDisabled' => $component->isDisabled(),
			'value' => $this->sanitizer->sanitizeText( $component->getValue() ),
			'placeholder' => $this->sanitizer->sanitizeText( $component->getPlaceholder() ),
			'hasStartIcon' => $component->hasStartIcon(),
			'startIconClass' => $this->sanitizer->sanitizeText( $component->getStartIconClass() ),
			'hasEndIcon' => $component->hasEndIcon(),
			'endIconClass' => $this->sanitizer->sanitizeText( $component->getEndIconClass() ),
			'hasError' => $component->hasError(),
			'inputAttributes' => self::resolve(
				$this->sanitizer->sanitizeAttributes( $component->getInputAttributes() )
			),
			'wrapperAttributes' => self::resolve(
				$this->sanitizer->sanitizeAttributes( $component->getWrapperAttributes() )
			),
		];

		return $this->templateRenderer->render( 'text-input.mustache', $textInputData );
	}
}
