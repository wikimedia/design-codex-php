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
 * Mustache template engine and Intuition for localization. These services are integral to
 * the Codex design system for generating reusable, standardized components.
 *
 * @category Infrastructure
 * @package  Codex\Infrastructure
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */

use Krinkle\Intuition\Intuition;
use Wikimedia\Codex\Adapter\WebRequestAdapter;
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
use Wikimedia\Codex\Utility\Sanitizer;
use Wikimedia\Codex\Utility\SimpleWebRequest;
use Wikimedia\Codex\Utility\WebRequestCallbacks;

/** @phpcs-require-sorted-array */
return [

	'AccordionBuilder' => static function ( $container ) {
		return new AccordionBuilder( $container->getService( 'AccordionRenderer' ) );
	},

	'AccordionRenderer' => static function ( $container ) {
		return new AccordionRenderer(
			$container->getService( 'Sanitizer' ), $container->getService( 'TemplateRenderer' ),
		);
	},

	'ButtonBuilder' => static function ( $container ) {
		return new ButtonBuilder( $container->getService( 'ButtonRenderer' ) );
	},

	'ButtonRenderer' => static function ( $container ) {
		return new ButtonRenderer(
			$container->getService( 'Sanitizer' ), $container->getService( 'TemplateRenderer' ),
		);
	},

	'CardBuilder' => static function ( $container ) {
		return new CardBuilder( $container->getService( 'CardRenderer' ) );
	},

	'CardRenderer' => static function ( $container ) {
		return new CardRenderer(
			$container->getService( 'Sanitizer' ), $container->getService( 'TemplateRenderer' ),
		);
	},

	'CheckboxBuilder' => static function ( $container ) {
		return new CheckboxBuilder( $container->getService( 'CheckboxRenderer' ) );
	},

	'CheckboxRenderer' => static function ( $container ) {
		return new CheckboxRenderer(
			$container->getService( 'Sanitizer' ), $container->getService( 'TemplateRenderer' )
		);
	},

	'FieldBuilder' => static function ( $container ) {
		return new FieldBuilder( $container->getService( 'FieldRenderer' ) );
	},

	'FieldRenderer' => static function ( $container ) {
		return new FieldRenderer(
			$container->getService( 'Sanitizer' ), $container->getService( 'TemplateRenderer' ),
		);
	},

	'HTMLPurifier' => static function ( $container ) {
		return new HTMLPurifier( $container->getService( 'HTMLPurifierConfig' ) );
	},

	'HTMLPurifierConfig' => static function () {
		return HTMLPurifier_Config::createDefault();
	},

	'HtmlSnippetBuilder' => static function ( $container ) {
		return new HtmlSnippetBuilder( $container->getService( 'Sanitizer' ) );
	},

	'InfoChipBuilder' => static function ( $container ) {
		return new InfoChipBuilder( $container->getService( 'InfoChipRenderer' ) );
	},

	'InfoChipRenderer' => static function ( $container ) {
		return new InfoChipRenderer(
			$container->getService( 'Sanitizer' ), $container->getService( 'TemplateRenderer' ),
		);
	},

	'Intuition' => static function () {
		static $intuition = null;

		if ( $intuition === null ) {
			$intuition = new Intuition( 'codex' );
			$intuition->registerDomain( 'codex', __DIR__ . '/../../i18n' );
		}

		return $intuition;
	},

	'LabelBuilder' => static function ( $container ) {
		return new LabelBuilder( $container->getService( 'LabelRenderer' ) );
	},

	'LabelRenderer' => static function ( $container ) {
		return new LabelRenderer(
			$container->getService( 'Sanitizer' ), $container->getService( 'TemplateRenderer' )
		);
	},

	'MessageBuilder' => static function ( $container ) {
		return new MessageBuilder( $container->getService( 'MessageRenderer' ) );
	},

	'MessageRenderer' => static function ( $container ) {
		return new MessageRenderer(
			$container->getService( 'Sanitizer' ), $container->getService( 'TemplateRenderer' ),
		);
	},

	'OptionBuilder' => static function () {
		return new OptionBuilder();
	},

	'PagerBuilder' => static function ( $container ) {
		return new PagerBuilder( $container->getService( 'PagerRenderer' ) );
	},

	'PagerRenderer' => static function ( $container ) {
		return new PagerRenderer(
			$container->getService( 'Sanitizer' ),
			$container->getService( 'TemplateRenderer' ),
			$container->getService( 'Intuition' )
		);
	},

	'ProgressBarBuilder' => static function ( $container ) {
		return new ProgressBarBuilder( $container->getService( 'ProgressBarRenderer' ) );
	},

	'ProgressBarRenderer' => static function ( $container ) {
		return new ProgressBarRenderer(
			$container->getService( 'Sanitizer' ), $container->getService( 'TemplateRenderer' ),
		);
	},

	'RadioBuilder' => static function ( $container ) {
		return new RadioBuilder( $container->getService( 'RadioRenderer' ) );
	},

	'RadioRenderer' => static function ( $container ) {
		return new RadioRenderer(
			$container->getService( 'Sanitizer' ), $container->getService( 'TemplateRenderer' )
		);
	},

	'Sanitizer' => static function ( $container ) {
		return new Sanitizer( $container->getService( 'HTMLPurifier' ) );
	},

	'SelectBuilder' => static function ( $container ) {
		return new SelectBuilder( $container->getService( 'SelectRenderer' ) );
	},

	'SelectRenderer' => static function ( $container ) {
		return new SelectRenderer(
			$container->getService( 'Sanitizer' ), $container->getService( 'TemplateRenderer' ),
		);
	},

	'SimpleWebRequest' => static function () {
		//phpcs:ignore
		return new SimpleWebRequest( $_GET );
	},

	'TabBuilder' => static function () {
		return new TabBuilder();
	},

	'TableBuilder' => static function ( $container ) {
		return new TableBuilder( $container->getService( 'TableRenderer' ) );
	},

	'TableRenderer' => static function ( $container ) {
		return new TableRenderer( $container->getService( 'Sanitizer' ), $container->getService( 'TemplateRenderer' ) );
	},

	'TabsBuilder' => static function ( $container ) {
		return new TabsBuilder( $container->getService( 'TabsRenderer' ) );
	},

	'TabsRenderer' => static function ( $container ) {
		return new TabsRenderer( $container->getService( 'Sanitizer' ), $container->getService( 'TemplateRenderer' ) );
	},

	'TemplateRenderer' => static function ( $container ) {
		static $mustacheEngine = null;

		if ( $mustacheEngine === null ) {
			$templatePath = __DIR__ . '/../../resources/templates';

			$intuition = $container->getService( 'Intuition' );

			$mustacheEngine = new Mustache_Engine( [
				'loader' => new Mustache_Loader_FilesystemLoader( $templatePath ),
				// Disable escaping in Mustache. We use custom PHP escaping instead.
				'escape' => static fn ( $x ) => $x,
				'helpers' => [
					// i18n helper - for localization
					'i18n' => static function ( $text, $render ) use ( $intuition ) {
						$renderedText = trim( $render( $text ) );
						// Split by '|' to separate the key and parameters.
						// XXX This assumes that the expanded content of parameters does not contain pipes.
						$parts = explode( '|', $renderedText );
						// The first part is the message key, the rest are parameters
						$key = trim( array_shift( $parts ) );
						$params = array_map( 'trim', $parts );

						return htmlspecialchars(
							$intuition->msg( $key, [ 'variables' => $params ] ),
							ENT_QUOTES,
							'UTF-8'
						);
					},
				],
			] );
		}

		return new TemplateRenderer( $mustacheEngine );
	},

	'TextAreaBuilder' => static function ( $container ) {
		return new TextAreaBuilder( $container->getService( 'TextAreaRenderer' ) );
	},

	'TextAreaRenderer' => static function ( $container ) {
		return new TextAreaRenderer(
			$container->getService( 'Sanitizer' ), $container->getService( 'TemplateRenderer' )
		);
	},

	'TextInputBuilder' => static function ( $container ) {
		return new TextInputBuilder( $container->getService( 'TextInputRenderer' ) );
	},

	'TextInputRenderer' => static function ( $container ) {
		return new TextInputRenderer(
			$container->getService( 'Sanitizer' ), $container->getService( 'TemplateRenderer' ),
		);
	},

	'ThumbnailBuilder' => static function ( $container ) {
		return new ThumbnailBuilder( $container->getService( 'ThumbnailRenderer' ) );
	},

	'ThumbnailRenderer' => static function ( $container ) {
		return new ThumbnailRenderer(
			$container->getService( 'Sanitizer' ), $container->getService( 'TemplateRenderer' ),
		);
	},

	'WebRequestAdapter' => static function ( $container ) {
		return new WebRequestAdapter( $container->getService( 'SimpleWebRequest' ) );
	},

	'WebRequestCallbacks' => static function ( $container ) {
		return new WebRequestCallbacks( $container->getService( 'WebRequestAdapter' ) );
	},
];
