<?php
/**
 * FieldRenderer.php
 *
 * This file is part of the Codex PHP library, which provides a PHP-based interface for creating
 * UI components consistent with the Codex design system.
 *
 * The `FieldRenderer` class leverages the `TemplateRenderer` and `Sanitizer` utilities to ensure the
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
use Wikimedia\Codex\Component\Field;
use Wikimedia\Codex\Contract\Renderer\IRenderer;
use Wikimedia\Codex\Contract\Renderer\ITemplateRenderer;
use Wikimedia\Codex\Traits\AttributeResolver;
use Wikimedia\Codex\Utility\Codex;
use Wikimedia\Codex\Utility\Sanitizer;

/**
 * FieldRenderer is responsible for rendering the HTML markup
 * for a Field component using a Mustache template.
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
class FieldRenderer implements IRenderer {
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
	 * The codex instance.
	 */
	private Codex $codex;

	/**
	 * Constructor to initialize the FieldRenderer with a sanitizer and a template renderer.
	 *
	 * @since 0.1.0
	 * @param Sanitizer $sanitizer The sanitizer instance used for content sanitization.
	 * @param ITemplateRenderer $templateRenderer The template renderer instance.
	 */
	public function __construct( Sanitizer $sanitizer, ITemplateRenderer $templateRenderer ) {
		$this->sanitizer = $sanitizer;
		$this->templateRenderer = $templateRenderer;
		$this->codex = new Codex();
	}

	/**
	 * Renders the HTML for a field component.
	 *
	 * Uses the provided Field component to generate HTML markup adhering to the Codex design system.
	 *
	 * @since 0.1.0
	 * @param Field $component The Field component to render.
	 * @return string The rendered HTML string for the component.
	 * @throws InvalidArgumentException If the provided object is not an instance of Field.
	 */
	public function render( $component ): string {
		if ( !$component instanceof Field ) {
			throw new InvalidArgumentException( "Expected instance of Field, got " . get_class( $component ) );
		}

		$label = $component->getLabel();

		$labelData = [
			'id' => $this->sanitizer->sanitizeText( $label->getId() ),
			'isLegend' => $component->isFieldset(),
			'inputId' => $this->sanitizer->sanitizeText( $label->getInputId() ),
			'labelText' => $this->sanitizer->sanitizeText( $label->getLabelText() ),
			'optionalFlag' => $label->isOptional(),
			'description' => $this->sanitizer->sanitizeText( $label->getDescription() ),
			'descriptionId' => $this->sanitizer->sanitizeText( $label->getDescriptionId() ),
			'icon' => $this->sanitizer->sanitizeText( $label->getIconClass() ),
			'isVisuallyHidden' => $label->isVisuallyHidden(),
			'isDisabled' => $label->isDisabled(),
			'additionalClasses' =>
				$this->sanitizer->sanitizeText( $this->resolveClasses( $label->getAttributes() ) ),
			'attributes' =>
				$this->resolve( $this->sanitizer->sanitizeAttributes( $label->getAttributes() )
				),
		];

		$fieldData = [
			'id' => $this->sanitizer->sanitizeText( $component->getId() ),
			'isFieldset' => $component->isFieldset(),
			'fields' => $component->getFields(),
			'additionalClasses' =>
				$this->sanitizer->sanitizeText( $this->resolveClasses( $component->getAttributes() ) ),
			'attributes' => $this->resolve( $this->sanitizer->sanitizeAttributes( $component->getAttributes() ) ),
			'label' => $labelData,
		];

		return $this->templateRenderer->render( 'field.mustache', $fieldData );
	}
}
