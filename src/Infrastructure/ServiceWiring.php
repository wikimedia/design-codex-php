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
use Wikimedia\Codex\Contract\ILocalizer;
use Wikimedia\Codex\Localization\IntuitionLocalization;
use Wikimedia\Codex\Localization\MediaWikiLocalization;
use Wikimedia\Codex\ParamValidator\ParamValidator;
use Wikimedia\Codex\ParamValidator\ParamValidatorCallbacks;
use Wikimedia\Codex\Parser\TemplateParser;
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
use Wikimedia\Codex\Renderer\TextAreaRenderer;
use Wikimedia\Codex\Renderer\TextInputRenderer;
use Wikimedia\Codex\Renderer\ThumbnailRenderer;
use Wikimedia\Codex\Renderer\ToggleSwitchRenderer;
use Wikimedia\Codex\Utility\Sanitizer;
use Wikimedia\Services\ServiceContainer;

/** @phpcs-require-sorted-array */
return [

	'AccordionRenderer' => static function ( ServiceContainer $services ) {
		return new AccordionRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateParser' ),
		);
	},

	'ButtonRenderer' => static function ( ServiceContainer $services ) {
		return new ButtonRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateParser' ),
		);
	},

	'CardRenderer' => static function ( ServiceContainer $services ) {
		return new CardRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateParser' ),
		);
	},

	'CheckboxRenderer' => static function ( ServiceContainer $services ) {
		return new CheckboxRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateParser' )
		);
	},

	'FieldRenderer' => static function ( ServiceContainer $services ) {
		return new FieldRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateParser' ),
		);
	},

	'InfoChipRenderer' => static function ( ServiceContainer $services ) {
		return new InfoChipRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateParser' ),
		);
	},

	'LabelRenderer' => static function ( ServiceContainer $services ) {
		return new LabelRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateParser' )
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

	'MessageRenderer' => static function ( ServiceContainer $services ) {
		return new MessageRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateParser' ),
		);
	},

	'PagerRenderer' => static function ( ServiceContainer $services ) {
		return new PagerRenderer(
			$services->getService( 'Sanitizer' ),
			$services->getService( 'TemplateParser' ),
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

	'ProgressBarRenderer' => static function ( ServiceContainer $services ) {
		return new ProgressBarRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateParser' ),
		);
	},

	'RadioRenderer' => static function ( ServiceContainer $services ) {
		return new RadioRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateParser' )
		);
	},

	'Sanitizer' => static function () {
		return new Sanitizer();
	},

	'SelectRenderer' => static function ( ServiceContainer $services ) {
		return new SelectRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateParser' ),
		);
	},

	'TableRenderer' => static function ( ServiceContainer $services ) {
		return new TableRenderer(
			$services->getService( 'Sanitizer' ),
			$services->getService( 'TemplateParser' ),
			$services->getService( 'ParamValidator' ),
			$services->getService( 'ParamValidatorCallbacks' )
		);
	},

	'TabsRenderer' => static function ( ServiceContainer $services ) {
		return new TabsRenderer(
			$services->getService( 'Sanitizer' ),
			$services->getService( 'TemplateParser' ),
			$services->getService( 'ParamValidator' ),
			$services->getService( 'ParamValidatorCallbacks' )
		);
	},

	'TemplateParser' => static function ( ServiceContainer $services ) {
		$templatePath = __DIR__ . '/../../resources/templates';
		$localization = $services->getService( 'Localization' );

		return new TemplateParser( $templatePath, $localization );
	},

	'TextAreaRenderer' => static function ( ServiceContainer $services ) {
		return new TextAreaRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateParser' )
		);
	},

	'TextInputRenderer' => static function ( ServiceContainer $services ) {
		return new TextInputRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateParser' ),
		);
	},

	'ThumbnailRenderer' => static function ( ServiceContainer $services ) {
		return new ThumbnailRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateParser' ),
		);
	},

	'ToggleSwitchRenderer' => static function ( ServiceContainer $services ) {
		return new ToggleSwitchRenderer(
			$services->getService( 'Sanitizer' ), $services->getService( 'TemplateParser' ),
		);
	},
];
