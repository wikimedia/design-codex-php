<?php
/**
 * InfoChipRenderer.php
 *
 * This file is part of the Codex PHP library, which provides a PHP-based interface for creating
 * UI components consistent with the Codex design system.
 *
 * The `InfoChipRenderer` class leverages the `TemplateRenderer` and `Sanitizer` utilities to ensure the
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
use Wikimedia\Codex\Component\InfoChip;
use Wikimedia\Codex\Contract\Renderer\IRenderer;
use Wikimedia\Codex\Contract\Renderer\ITemplateRenderer;
use Wikimedia\Codex\Traits\AttributeResolver;
use Wikimedia\Codex\Utility\Sanitizer;

/**
 * InfoChipRenderer is responsible for rendering the HTML markup
 * for an InfoChip component using a Mustache template.
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
class InfoChipRenderer implements IRenderer {

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
	 * Constructor to initialize the InfoChipRenderer with a sanitizer and a template renderer.
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
	 * Renders the HTML for an info chip component.
	 *
	 * Uses the provided InfoChip component to generate HTML markup adhering to the Codex design system.
	 *
	 * @since 0.1.0
	 * @param InfoChip $component The InfoChip object to render.
	 * @return string The rendered HTML string for the component.
	 */
	public function render( $component ): string {
		if ( !$component instanceof InfoChip ) {
			throw new InvalidArgumentException( "Expected instance of InfoChip, got " . get_class( $component ) );
		}

		$chipData = [
			'id' => $this->sanitizer->sanitizeText( $component->getId() ),
			'status' => $this->sanitizer->sanitizeText( $component->getStatus() ),
			'text' => $this->sanitizer->sanitizeText( $component->getText() ),
			'icon' => $this->sanitizer->sanitizeText( $component->getIcon() ),
			'attributes' => $this->resolve( $this->sanitizer->sanitizeAttributes( $component->getAttributes() ) ),
		];

		return $this->templateRenderer->render( 'info-chip.mustache', $chipData );
	}
}
