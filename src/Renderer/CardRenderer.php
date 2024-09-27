<?php
/**
 * CardRenderer.php
 *
 * This file is part of the Codex PHP library, which provides a PHP-based interface for creating
 * UI components consistent with the Codex design system.
 *
 * The `CardRenderer` class leverages the `TemplateRenderer` and `Sanitizer` utilities to ensure the
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
use Wikimedia\Codex\Component\Card;
use Wikimedia\Codex\Contract\Renderer\IRenderer;
use Wikimedia\Codex\Contract\Renderer\ITemplateRenderer;
use Wikimedia\Codex\Traits\AttributeResolver;
use Wikimedia\Codex\Utility\Sanitizer;

/**
 * CardRenderer is responsible for rendering the HTML markup
 * for a Card component using a Mustache template.
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
class CardRenderer implements IRenderer {

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
	 * Constructor to initialize the CardRenderer with a sanitizer and a template renderer.
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
	 * Renders the HTML for a card component.
	 *
	 * Uses the provided Card component to generate HTML markup adhering to the Codex design system.
	 *
	 * @since 0.1.0
	 * @param Card $component The Card object to render.
	 * @return string The rendered HTML string for the component.
	 */
	public function render( $component ): string {
		if ( !$component instanceof Card ) {
			throw new InvalidArgumentException( "Expected instance of Card, got " . get_class( $component ) );
		}
		$thumbnail = $component->getThumbnail();

		$thumbnailData = [
			'id' => $this->sanitizer->sanitizeText( $thumbnail->getId() ),
			'coreClass' => 'cdx-card__thumbnail',
			'backgroundImage' => $this->sanitizer->sanitizeText( $thumbnail->getBackgroundImage() ),
			'useDefaultPlaceholder' => (bool)$component->getThumbnail(),
			'placeholderClass' => $this->sanitizer->sanitizeText( $thumbnail->getPlaceholderClass() ),
			'attributes' => self::resolve( $this->sanitizer->sanitizeAttributes( $thumbnail->getAttributes() ) ),
		];

		$cardData = [
			'id' => $this->sanitizer->sanitizeText( $component->getId() ),
			'tag' => $component->getUrl() !== '' ? 'a' : 'span',
			'title' => $this->sanitizer->sanitizeText( $component->getTitle() ),
			'description' => $this->sanitizer->sanitizeText( $component->getDescription() ),
			'supportingText' => $this->sanitizer->sanitizeText( $component->getSupportingText() ),
			'url' => $this->sanitizer->sanitizeUrl( $component->getUrl() ),
			'iconClass' => $this->sanitizer->sanitizeText( $component->getIconClass() ),
			'thumbnail' => $thumbnailData,
			'additionalClasses' =>
				$this->sanitizer->sanitizeText( $this->resolveClasses( $component->getAttributes() ) ),
			'attributes' => self::resolve( $this->sanitizer->sanitizeAttributes( $component->getAttributes() ) ),
		];

		return $this->templateRenderer->render( 'card.mustache', $cardData );
	}
}
