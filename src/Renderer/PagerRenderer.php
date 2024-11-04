<?php
/**
 * PagerRenderer.php
 *
 * This file is part of the Codex PHP library, which provides a PHP-based interface for creating
 * UI components consistent with the Codex design system.
 *
 * The `PagerRenderer` class leverages the `TemplateRenderer` and `Sanitizer` utilities to ensure the
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
use Wikimedia\Codex\Builder\PagerBuilder;
use Wikimedia\Codex\Component\Pager;
use Wikimedia\Codex\Contract\ILocalizer;
use Wikimedia\Codex\Contract\Renderer\IRenderer;
use Wikimedia\Codex\Contract\Renderer\ITemplateRenderer;
use Wikimedia\Codex\Traits\AttributeResolver;
use Wikimedia\Codex\Utility\Codex;
use Wikimedia\Codex\Utility\Sanitizer;

/**
 * PagerRenderer is responsible for rendering the HTML markup
 * for a Pager component using a Mustache template.
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
class PagerRenderer implements IRenderer {

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
	 * The localization instance implementing ILocalizer.
	 */
	private ILocalizer $localizer;

	/**
	 * The Codex instance for utility methods.
	 */
	private Codex $codex;

	/**
	 * Constructor to initialize the PagerRenderer with a sanitizer, a template renderer, and a language handler.
	 *
	 * @since 0.1.0
	 * @param Sanitizer $sanitizer The sanitizer instance used for content sanitization.
	 * @param ITemplateRenderer $templateRenderer The template renderer instance used for rendering templates.
	 * @param ILocalizer $localizer The localizer instance used for localization and translations.
	 */
	public function __construct(
		Sanitizer $sanitizer,
		ITemplateRenderer $templateRenderer,
		ILocalizer $localizer
	) {
		$this->sanitizer = $sanitizer;
		$this->templateRenderer = $templateRenderer;
		$this->localizer = $localizer;
		$this->codex = new Codex();
	}

	/**
	 * Renders the HTML for a pager component.
	 *
	 * Uses the provided Pager to generate HTML markup adhering to the Codex design system.
	 *
	 * @since 0.1.0
	 * @param Pager $component The Pager object to render.
	 * @return string The rendered HTML string for the component.
	 */
	public function render( $component ): string {
		if ( !$component instanceof Pager ) {
			throw new InvalidArgumentException( "Expected instance of Pager, got " . get_class( $component ) );
		}

		$selectHtml = $this->buildSelect( $component );

		$buttons = [
			'firstButton' => $this->buildButtonData( $component, PagerBuilder::ACTION_FIRST ),
			'prevButton' => $this->buildButtonData( $component, PagerBuilder::ACTION_PREVIOUS ),
			'nextButton' => $this->buildButtonData( $component, PagerBuilder::ACTION_NEXT ),
			'lastButton' => $this->buildButtonData( $component, PagerBuilder::ACTION_LAST ),
		];

		$hiddenFields = $this->buildHiddenFields( $component );

		$pagerData = [
			'id' => $this->sanitizer->sanitizeText( $component->getId() ),
			'position' => $this->sanitizer->sanitizeText( $component->getPosition() ),
			'startOrdinal' => $component->getStartOrdinal(),
			'endOrdinal' => $component->getEndOrdinal(),
			'totalResults' => $component->getTotalResults(),
			'isPending' => $component->getEndOrdinal() < $component->getStartOrdinal(),
			'hasTotalResults' => $component->getTotalResults() > 0,
			'select' => $selectHtml,
			'firstButton' => $buttons['firstButton'],
			'prevButton' => $buttons['prevButton'],
			'nextButton' => $buttons['nextButton'],
			'lastButton' => $buttons['lastButton'],
			'hiddenFields' => $hiddenFields,
		];

		return $this->templateRenderer->render( 'pager.mustache', $pagerData );
	}

	/**
	 * Build the select dropdown data to be passed to the Mustache template.
	 *
	 * @since 0.1.0
	 * @param Pager $pager
	 * @return string The select dropdown data for Mustache.
	 */
	protected function buildSelect( Pager $pager ): string {
		$sizeOptions = $pager->getPaginationSizeOptions();
		$currentLimit = $pager->getLimit();

		$options = [];

		foreach ( $sizeOptions as $size ) {
			$options[] = [
				'value' => $this->sanitizer->sanitizeText( (string)$size ),
				'text' => $this->localizer->msg(
					'cdx-table-pager-items-per-page-current', [ 'variables' => [ $size ] ]
				),
				'selected' => ( $size == $currentLimit ),
			];
		}

		return $this->codex->select()
			->setOptions( $options )
			->setSelectedOption( (string)$currentLimit )
			->setAttributes( [
				'name' => 'limit',
				'onchange' => 'this.form.submit();',
				'class' => 'cdx-select',
			] )->build()->getHtml();
	}

	/**
	 * Build an individual pagination button.
	 *
	 * Generates the data array for a single pagination button based on the action.
	 *
	 * @since 0.1.0
	 * @param Pager $pager The Pager object.
	 * @param string $action The action for the button (e.g., PagerBuilder::ACTION_FIRST).
	 * @return array The data array for the pagination button.
	 */
	protected function buildButtonData( Pager $pager, string $action ): array {
		$iconClass = $pager->getIconClasses()[$action] ?? '';
		$dir = '';
		switch ( $action ) {
			case PagerBuilder::ACTION_FIRST:
				$disabled = $pager->isFirstDisabled();
				$ariaLabelKey = 'cdx-table-pager-button-first-page';
				$offset = $pager->getFirstOffset();
				break;
			case PagerBuilder::ACTION_PREVIOUS:
				$disabled = $pager->isPrevDisabled();
				$ariaLabelKey = 'cdx-table-pager-button-prev-page';
				$offset = $pager->getPrevOffset();
				break;
			case PagerBuilder::ACTION_NEXT:
				$disabled = $pager->isNextDisabled();
				$ariaLabelKey = 'cdx-table-pager-button-next-page';
				$offset = $pager->getNextOffset();
				break;
			case PagerBuilder::ACTION_LAST:
				$disabled = $pager->isLastDisabled();
				$ariaLabelKey = 'cdx-table-pager-button-last-page';
				$offset = $pager->getLastOffset();
				$dir = 'prev';
				break;
			default:
				throw new InvalidArgumentException( "Unknown action: $action" );
		}

		return [
			'isDisabled' => $disabled,
			'weight' => 'quiet',
			'iconOnly' => true,
			'ariaLabelKey' => $ariaLabelKey,
			'iconClass' => $iconClass,
			'type' => 'submit',
			'name' => 'offset',
			'value' => $this->sanitizer->sanitizeText( (string)$offset ),
			'dir' => $dir,
		];
	}

	/**
	 * Build hidden fields for the pagination form.
	 *
	 * This method generates the hidden input fields needed for the pagination form, including offset, direction,
	 * and other query parameters.
	 *
	 * @since 0.1.0
	 * @param Pager $pager The Pager object to render.
	 * @return array The generated HTML string for the hidden fields.
	 */
	protected function buildHiddenFields( Pager $pager ): array {
		$callbacks = $pager->getCallbacks();
		if ( !$callbacks ) {
			return [];
		}

		$fields = [];
		foreach ( $callbacks->getValues( 'sort', 'asc', 'desc' ) as $key => $value ) {
			$fields[] = [
				'key' => $this->sanitizer->sanitizeText( $key ),
				'value' => $this->sanitizer->sanitizeText( $value ),
			];
		}

		return $fields;
	}
}
