<?php
/**
 * CheckboxRenderer.php
 *
 * This file is part of the Codex PHP library, which provides a PHP-based interface for creating
 * UI components consistent with the Codex design system.
 *
 * The `CheckboxRenderer` class leverages the `TemplateRenderer` and `Sanitizer` utilities to ensure the
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
use Wikimedia\Codex\Component\Checkbox;
use Wikimedia\Codex\Contract\Renderer\IRenderer;
use Wikimedia\Codex\Contract\Renderer\ITemplateRenderer;
use Wikimedia\Codex\Traits\AttributeResolver;
use Wikimedia\Codex\Utility\Sanitizer;

/**
 * CheckboxRenderer is responsible for rendering the HTML markup
 * for a Checkbox component using a Mustache template.
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
class CheckboxRenderer implements IRenderer {

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
	 * Constructor to initialize the CheckboxRenderer with a sanitizer and a template renderer.
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
	 * Renders the HTML for a checkbox component.
	 *
	 * Uses the provided Checkbox component to generate HTML markup adhering to the Codex design system.
	 *
	 * @since 0.1.0
	 * @param Checkbox $component The Checkbox component to render.
	 * @return string The rendered HTML string for the component.
	 */
	public function render( $component ): string {
		if ( !$component instanceof Checkbox ) {
			throw new InvalidArgumentException( "Expected instance of Checkbox, got " . get_class( $component ) );
		}

		$label = $component->getLabel();

		$labelData = [
			'id' => $this->sanitizer->sanitizeText( $label->getId() ),
			'coreClass' => 'cdx-checkbox__label',
			'labelText' => $this->sanitizer->sanitizeText( $label->getLabelText() ),
			'optionalFlag' => $label->isOptional(),
			'inputId' => $component->getInputId(),
			'description' => $this->sanitizer->sanitizeText( $label->getDescription() ),
			'descriptionId' => $this->sanitizer->sanitizeText( $label->getDescriptionId() ?? '' ),
			'disabled' => $label->isDisabled(),
			'iconClass' => $this->sanitizer->sanitizeText( $label->getIconClass() ?? '' ),
			'attributes' => $this->resolve(
				$this->sanitizer->sanitizeAttributes( $label->getAttributes() )
			),
		];

		$checkboxData = [
			'id' => $this->sanitizer->sanitizeText( $component->getInputId() ),
			'name' => $this->sanitizer->sanitizeText( $component->getName() ),
			'value' => $this->sanitizer->sanitizeText( $component->getValue() ),
			'inputId' => $component->getInputId(),
			'isChecked' => $component->isChecked(),
			'isDisabled' => $component->isDisabled(),
			'isInline' => $component->isInline(),
			'ariaDescribedby' => $this->sanitizer->sanitizeText( $label->getDescriptionId() ?? '' ),
			'inputAttributes' => $this->resolve(
				$this->sanitizer->sanitizeAttributes( $component->getInputAttributes() )
			),
			'wrapperAttributes' => $this->resolve(
				$this->sanitizer->sanitizeAttributes( $component->getWrapperAttributes() )
			),
			'label' => $labelData,
		];

		return $this->templateRenderer->render( 'checkbox.mustache', $checkboxData );
	}
}
