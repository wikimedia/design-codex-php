<?php
/**
 * FieldRenderer.php
 *
 * This file is part of the Codex PHP library, which provides a PHP-based interface for creating
 * UI components consistent with the Codex design system.
 *
 * The `FieldRenderer` class leverages the `TemplateParser` and `Sanitizer` utilities to ensure the
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
use Wikimedia\Codex\Contract\Component;
use Wikimedia\Codex\Contract\ILocalizer;
use Wikimedia\Codex\Contract\Renderer;
use Wikimedia\Codex\Parser\TemplateParser;
use Wikimedia\Codex\Utility\Codex;
use Wikimedia\Codex\Utility\Sanitizer;

/**
 * FieldRenderer is responsible for rendering the HTML markup
 * for a Field component using a Mustache template.
 *
 * This class uses the `TemplateParser` and `Sanitizer` utilities to manage
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
class FieldRenderer extends Renderer {

	/**
	 * The codex instance.
	 */
	private Codex $codex;

	/**
	 * Constructor to initialize the FieldRenderer with a sanitizer and a template parser.
	 *
	 * @since 0.1.0
	 * @param Sanitizer $sanitizer The sanitizer instance used for content sanitization.
	 * @param TemplateParser $templateParser The template parser instance.
	 * @param ILocalizer $localizer The localizer instance used for i18n messages.
	 */
	public function __construct(
		private readonly Sanitizer $sanitizer,
		private readonly TemplateParser $templateParser,
		private readonly ILocalizer $localizer,
	) {
		$this->codex = new Codex();
	}

	/**
	 * Renders the HTML for a field component.
	 *
	 * Uses the provided Field component to generate HTML markup adhering to the Codex design system.
	 *
	 * @since 0.1.0
	 * @param Component $component The Field component to render.
	 * @return string The rendered HTML string for the component.
	 */
	public function render( Component $component ): string {
		if ( !$component instanceof Field ) {
			throw new InvalidArgumentException( "Expected instance of Field, got " . get_class( $component ) );
		}

		$label = $component->getLabel();
		$labelData = null;

		if ( $label ) {
			$labelData = [
				'id' => $label->getId(),
				'isLegend' => $component->isFieldset(),
				'inputId' => $label->getInputId(),
				'labelText-html' => $this->sanitizer->sanitizeText( $label->getLabelText() ),
				'optionalFlag' => $label->isOptional() ?
					$this->localizer->msg( 'cdx-label-optional-flag' ) :
					null,
				'isVisuallyHidden' => $label->isVisuallyHidden(),
				'description-html' => $this->sanitizer->sanitizeText( $label->getDescription() ),
				'descriptionId' => $label->getDescriptionId(),
				'icon' => $label->getIconClass(),
				'isDisabled' => $label->isDisabled(),
				'attributes' => $this->resolveAttributes(
					$this->sanitizer->sanitizeAttributes( $label->getAttributes() )
				),
			];
		}

		$fieldData = [
			'id' => $component->getId(),
			'isFieldset' => $component->isFieldset(),
			'fields' => $component->getFields(),
			'attributes' => $this->resolveAttributes(
				$this->sanitizer->sanitizeAttributes( $component->getAttributes() )
			),
			'label' => $labelData,
		];

		return $this->templateParser->processTemplate( 'field', $fieldData );
	}
}
