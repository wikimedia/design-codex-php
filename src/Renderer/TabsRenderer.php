<?php
/**
 * TabsRenderer.php
 *
 * This file is part of the Codex PHP library, which provides a PHP-based interface for creating
 * UI components consistent with the Codex design system.
 *
 * The `TabsRenderer` class leverages the `TemplateRenderer` and `Sanitizer` utilities to ensure the
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
use Wikimedia\Codex\Component\Tab;
use Wikimedia\Codex\Component\Tabs;
use Wikimedia\Codex\Contract\Renderer\IRenderer;
use Wikimedia\Codex\Contract\Renderer\ITemplateRenderer;
use Wikimedia\Codex\Traits\AttributeResolver;
use Wikimedia\Codex\Utility\Sanitizer;

/**
 * TabsRenderer is responsible for rendering the HTML markup
 * for a Tabs component using a Mustache template.
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
class TabsRenderer implements IRenderer {

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
	 * Constructor to initialize the TabsRenderer with a sanitizer and a template renderer.
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
	 * Renders the HTML for a tabs component.
	 *
	 * Uses the provided Tabs component to generate HTML markup adhering to the Codex design system.
	 *
	 * @since 0.1.0
	 * @param Tabs $component The Tabs object to render.
	 * @return string The rendered HTML string for the component.
	 */
	public function render( $component ): string {
		if ( !$component instanceof Tabs ) {
			throw new InvalidArgumentException( "Expected instance of Tabs, got " . get_class( $component ) );
		}

		$currentTabName = $component->getCallbacks()->getValue(
			'tab',
			$component->getTabs()[0]->getName(),
			[]
		);

		$tabsData = [];
		foreach ( $component->getTabs() as $tab ) {
			if ( !$tab instanceof Tab ) {
				throw new InvalidArgumentException( "All tabs must be instances of Tab Component" );
			}

			$isSelected = $tab->getName() === $currentTabName;
			$isHidden = !$isSelected;

			$tabsData[] = [
				'id' => $this->sanitizer->sanitizeText( $tab->getId() ),
				'name' => $this->sanitizer->sanitizeText( $tab->getName() ),
				'label' => $this->sanitizer->sanitizeText( $tab->getLabel() ),
				'content-html' => $this->sanitizer->sanitizeHtml( $tab->getContent() ),
				'isSelected' => $isSelected,
				'isHidden' => $isHidden,
				'disabled' => $tab->isDisabled(),
			];
		}

		$data = [
			'id' => $this->sanitizer->sanitizeText( $component->getId() ),
			'tabs' => $tabsData,
			'additionalClasses' =>
				$this->sanitizer->sanitizeText( $this->resolveClasses( $component->getAttributes() ) ),
			'attributes' => self::resolve(
				$this->sanitizer->sanitizeAttributes( $component->getAttributes() )
			),
		];

		return $this->templateRenderer->render( 'tabs.mustache', $data );
	}
}
