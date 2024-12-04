<?php
/**
 * ServiceWiring.php
 *
 * This file returns the array loaded by the CodexServices class
 * for use through `Wikimedia\CodexServices::getInstance()`. Each service is associated with a key (service name),
 * and its value is a closure that returns an instance of the service. This setup allows for
 * dependency injection, ensuring services are instantiated only when needed.
 *
 * Reminder:
 *  - ServiceWiring is NOT a cache for arbitrary singletons.
 *
 * Services include various UI component builders, renderers, and utilities such as the
 * Mustache template engine and Localization for localization. These services are integral to
 * the Codex design system for generating reusable, standardized components.
 *
 * @category Infrastructure
 * @package  Codex\Infrastructure
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */

use GuzzleHttp\Psr7\ServerRequest;
use Krinkle\Intuition\Intuition;
use MediaWiki\Context\RequestContext;
use Wikimedia\Codex\Builder\AccordionBuilder;
use Wikimedia\Codex\Builder\ButtonBuilder;
use Wikimedia\Codex\Builder\CardBuilder;
use Wikimedia\Codex\Builder\CheckboxBuilder;
use Wikimedia\Codex\Builder\FieldBuilder;
use Wikimedia\Codex\Builder\HtmlSnippetBuilder;
use Wikimedia\Codex\Builder\InfoChipBuilder;
use Wikimedia\Codex\Builder\LabelBuilder;
use Wikimedia\Codex\Builder\MessageBuilder;
use Wikimedia\Codex\Builder\OptionBuilder;
use Wikimedia\Codex\Builder\PagerBuilder;
use Wikimedia\Codex\Builder\ProgressBarBuilder;
use Wikimedia\Codex\Builder\RadioBuilder;
use Wikimedia\Codex\Builder\SelectBuilder;
use Wikimedia\Codex\Builder\TabBuilder;
use Wikimedia\Codex\Builder\TableBuilder;
use Wikimedia\Codex\Builder\TabsBuilder;
use Wikimedia\Codex\Builder\TextAreaBuilder;
use Wikimedia\Codex\Builder\TextInputBuilder;
use Wikimedia\Codex\Builder\ThumbnailBuilder;
use Wikimedia\Codex\Builder\ToggleSwitchBuilder;
use Wikimedia\Codex\Contract\ILocalizer;
use Wikimedia\Codex\Localization\IntuitionLocalization;
use Wikimedia\Codex\Localization\MediaWikiLocalization;
use Wikimedia\Codex\ParamValidator\ParamValidator;
use Wikimedia\Codex\ParamValidator\ParamValidatorCallbacks;
use Wikimedia\Codex\Renderer\AccordionRenderer;
use Wikimedia\Codex\Renderer\ButtonRenderer;
use Wikimedia\Codex\Renderer\CardRenderer;
use Wikimedia\Codex\Renderer\CheckboxRenderer;
use Wikimedia\Codex\Renderer\FieldRenderer;
use Wikimedia\Codex\Renderer\InfoChipRenderer;
use Wikimedia\Codex\Renderer\LabelRenderer;
use Wikimedia\Codex\Renderer\MessageRenderer;
use Wikimedia\Codex\Renderer\PagerRenderer;
use Wikimedia\Codex\Renderer\ProgressBarRenderer;
use Wikimedia\Codex\Renderer\RadioRenderer;
use Wikimedia\Codex\Renderer\SelectRenderer;
use Wikimedia\Codex\Renderer\TableRenderer;
use Wikimedia\Codex\Renderer\TabsRenderer;
use Wikimedia\Codex\Renderer\TemplateRenderer;
use Wikimedia\Codex\Renderer\TextAreaRenderer;
use Wikimedia\Codex\Renderer\TextInputRenderer;
use Wikimedia\Codex\Renderer\ThumbnailRenderer;
use Wikimedia\Codex\Renderer\ToggleSwitchRenderer;
use Wikimedia\Codex\Utility\Sanitizer;
use Wikimedia\Services\ServiceContainer;

/** @phpcs-require-sorted-array */
return [

	'AccordionBuilder' => static function ( ServiceContainer $services ) {
		return new AccordionBuilder( $services->getService( 'AccordionRenderer' ) );
	},

	'AccordionRenderer' => static function ( ServiceContainer $services ) {
		return new AccordionRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateRenderer' ),
		);
	},

	'ButtonBuilder' => static function ( ServiceContainer $services ) {
		return new ButtonBuilder( $services->getService( 'ButtonRenderer' ) );
	},

	'ButtonRenderer' => static function ( ServiceContainer $services ) {
		return new ButtonRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateRenderer' ),
		);
	},

	'CardBuilder' => static function ( ServiceContainer $services ) {
		return new CardBuilder( $services->getService( 'CardRenderer' ) );
	},

	'CardRenderer' => static function ( ServiceContainer $services ) {
		return new CardRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateRenderer' ),
		);
	},

	'CheckboxBuilder' => static function ( ServiceContainer $services ) {
		return new CheckboxBuilder( $services->getService( 'CheckboxRenderer' ) );
	},

	'CheckboxRenderer' => static function ( ServiceContainer $services ) {
		return new CheckboxRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateRenderer' )
		);
	},

	'FieldBuilder' => static function ( ServiceContainer $services ) {
		return new FieldBuilder( $services->getService( 'FieldRenderer' ) );
	},

	'FieldRenderer' => static function ( ServiceContainer $services ) {
		return new FieldRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateRenderer' ),
		);
	},

	'HtmlSnippetBuilder' => static function () {
		return new HtmlSnippetBuilder();
	},

	'InfoChipBuilder' => static function ( ServiceContainer $services ) {
		return new InfoChipBuilder( $services->getService( 'InfoChipRenderer' ) );
	},

	'InfoChipRenderer' => static function ( ServiceContainer $services ) {
		return new InfoChipRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateRenderer' ),
		);
	},

	'LabelBuilder' => static function ( ServiceContainer $services ) {
		return new LabelBuilder( $services->getService( 'LabelRenderer' ) );
	},

	'LabelRenderer' => static function ( ServiceContainer $services ) {
		return new LabelRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateRenderer' )
		);
	},

	'Localization' => static function (): ILocalizer {
		if ( defined( 'MW_INSTALL_PATH' ) ) {
			$messageLocalizer = RequestContext::getMain();
			return new MediaWikiLocalization( $messageLocalizer );
		} else {
			$intuition = new Intuition( 'codex' );
			$intuition->registerDomain( 'codex', __DIR__ . '/../../i18n' );
			return new IntuitionLocalization( $intuition );
		}
	},

	'MessageBuilder' => static function ( ServiceContainer $services ) {
		return new MessageBuilder( $services->getService( 'MessageRenderer' ) );
	},

	'MessageRenderer' => static function ( ServiceContainer $services ) {
		return new MessageRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateRenderer' ),
		);
	},

	'OptionBuilder' => static function () {
		return new OptionBuilder();
	},

	'PagerBuilder' => static function ( ServiceContainer $services ) {
		return new PagerBuilder( $services->getService( 'PagerRenderer' ) );
	},

	'PagerRenderer' => static function ( ServiceContainer $services ) {
		return new PagerRenderer(
			$services->getService( 'Sanitizer' ),
			$services->getService( 'TemplateRenderer' ),
			$services->getService( 'Localization' ),
			$services->getService( 'ParamValidator' ),
			$services->getService( 'ParamValidatorCallbacks' )
		);
	},

	'ParamValidator' => static function ( ServiceContainer $services ): ParamValidator{
		return new ParamValidator( $services->getService( 'ParamValidatorCallbacks' ) );
	},

	'ParamValidatorCallbacks' => static function (): ParamValidatorCallbacks {
		$request = ServerRequest::fromGlobals();
		return new ParamValidatorCallbacks( $request->getQueryParams() );
	},

	'ProgressBarBuilder' => static function ( ServiceContainer $services ) {
		return new ProgressBarBuilder( $services->getService( 'ProgressBarRenderer' ) );
	},

	'ProgressBarRenderer' => static function ( ServiceContainer $services ) {
		return new ProgressBarRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateRenderer' ),
		);
	},

	'RadioBuilder' => static function ( ServiceContainer $services ) {
		return new RadioBuilder( $services->getService( 'RadioRenderer' ) );
	},

	'RadioRenderer' => static function ( ServiceContainer $services ) {
		return new RadioRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateRenderer' )
		);
	},

	'Sanitizer' => static function () {
		return new Sanitizer();
	},

	'SelectBuilder' => static function ( ServiceContainer $services ) {
		return new SelectBuilder( $services->getService( 'SelectRenderer' ) );
	},

	'SelectRenderer' => static function ( ServiceContainer $services ) {
		return new SelectRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateRenderer' ),
		);
	},

	'TabBuilder' => static function () {
		return new TabBuilder();
	},

	'TableBuilder' => static function ( ServiceContainer $services ) {
		return new TableBuilder( $services->getService( 'TableRenderer' ) );
	},

	'TableRenderer' => static function ( ServiceContainer $services ) {
		return new TableRenderer(
			$services->getService( 'Sanitizer' ),
			$services->getService( 'TemplateRenderer' ),
			$services->getService( 'ParamValidator' ),
			$services->getService( 'ParamValidatorCallbacks' )
		);
	},

	'TabsBuilder' => static function ( ServiceContainer $services ) {
		return new TabsBuilder( $services->getService( 'TabsRenderer' ) );
	},

	'TabsRenderer' => static function ( ServiceContainer $services ) {
		return new TabsRenderer(
			$services->getService( 'Sanitizer' ),
			$services->getService( 'TemplateRenderer' ),
			$services->getService( 'ParamValidator' ),
			$services->getService( 'ParamValidatorCallbacks' )
		);
	},

	'TemplateRenderer' => static function ( ServiceContainer $services ) {
		$templatePath = __DIR__ . '/../../resources/templates';

		$localization = $services->getService( 'Localization' );

		$mustacheEngine = new Mustache_Engine( [
			'loader' => new Mustache_Loader_FilesystemLoader( $templatePath ),
			// Disable escaping in Mustache. We use custom PHP escaping instead.
			'escape' => static fn ( $x ) => $x,
			'helpers' => [
				// TODO: Consider moving the following helper functions to a separate helper class.
				// i18n helper - for localization
				'i18n' => static function ( $text, $render ) use ( $localization ) {
					$renderedText = trim( $render( $text ) );
					// Split by '|' to separate the key and parameters.
					// XXX This assumes that the expanded content of parameters does not contain pipes.
					$parts = explode( '|', $renderedText );
					// The first part is the message key, the rest are parameters
					$key = trim( array_shift( $parts ) );
					$params = [];
					foreach ( $parts as $part ) {
						$params[] = trim( $part );
					}

					return htmlspecialchars(
						$localization->msg( $key, [ 'variables' => $params ] ),
						ENT_QUOTES,
						'UTF-8'
					);
				},
				'renderClasses' => static function ( $attributes, $render ) {
					$renderedAttributes = $render( $attributes );

					// Use a regular expression to match the 'class' attribute and capture its value
					if ( preg_match( '/class="([^"]*)"/', $renderedAttributes, $matches ) ) {
						// If a 'class' attribute is found, prepend a space and return the class string
						return ' ' . $matches[1];
					}

					// If no 'class' attribute is found, return an empty string
					return '';
				},
				'renderAttributes' => static function ( $attributes, $render ) {
					$renderedAttributes = $render( $attributes );

					// Remove the 'class' attribute from the rendered attributes using a regular expression
					// This ensures that only non-class attributes are returned
					$attribs = trim( preg_replace( '/\s*class="[^"]*"/', '', $renderedAttributes ) );

					// If there are remaining attributes after removing 'class', prepend a space and return them
					// Otherwise, return an empty string
					return $attribs !== '' ? ' ' . $attribs : '';
				},
			],
		] );

		return new TemplateRenderer( $mustacheEngine );
	},

	'TextAreaBuilder' => static function ( ServiceContainer $services ) {
		return new TextAreaBuilder( $services->getService( 'TextAreaRenderer' ) );
	},

	'TextAreaRenderer' => static function ( ServiceContainer $services ) {
		return new TextAreaRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateRenderer' )
		);
	},

	'TextInputBuilder' => static function ( ServiceContainer $services ) {
		return new TextInputBuilder( $services->getService( 'TextInputRenderer' ) );
	},

	'TextInputRenderer' => static function ( ServiceContainer $services ) {
		return new TextInputRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateRenderer' ),
		);
	},

	'ThumbnailBuilder' => static function ( ServiceContainer $services ) {
		return new ThumbnailBuilder( $services->getService( 'ThumbnailRenderer' ) );
	},

	'ThumbnailRenderer' => static function ( ServiceContainer $services ) {
		return new ThumbnailRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateRenderer' ),
		);
	},

	'ToggleSwitchBuilder' => static function ( ServiceContainer $services ) {
		return new ToggleSwitchBuilder( $services->getService( 'ToggleSwitchRenderer' ) );
	},

	'ToggleSwitchRenderer' => static function ( ServiceContainer $services ) {
		return new ToggleSwitchRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateRenderer' ),
		);
	},
];
