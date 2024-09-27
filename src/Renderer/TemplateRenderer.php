<?php
/**
 * TemplateRenderer.php
 *
 * This file is part of the Codex design system, which provides a standardized
 * approach to rendering templates. The `TemplateRenderer` class
 * is responsible for managing the template rendering environment within the Codex system.
 *
 * This utility class is designed to centralize the configuration and instantiation
 * of the rendering environment, ensuring consistency and reusability across the system.
 *
 * @category Renderer
 * @package  Codex\Renderer
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */

namespace Wikimedia\Codex\Renderer;

use Mustache_Engine;
use Wikimedia\Codex\Contract\Renderer\ITemplateRenderer;

/**
 * TemplateRenderer is a utility class responsible for managing the template rendering environment.
 *
 * The `TemplateRenderer` class provides an instance of the rendering engine,
 * configured with the necessary settings for the Codex system. This class ensures
 * that templates are loaded consistently from the defined directory.
 *
 * @category Renderer
 * @package  Codex\Renderer
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */
class TemplateRenderer implements ITemplateRenderer {

	/**
	 * The rendering engine instance.
	 */
	private Mustache_Engine $engine;

	/**
	 * Constructor to initialize the TemplateRenderer with a Mustache engine.
	 *
	 * @since 0.1.0
	 * @param Mustache_Engine $engine The Mustache engine instance for rendering templates.
	 */
	public function __construct( Mustache_Engine $engine ) {
		$this->engine = $engine;
	}

	/**
	 * Renders a template with the provided data.
	 *
	 * @since 0.1.0
	 * @param string $template The template file name.
	 * @param array $data The data to render within the template.
	 * @return string The rendered HTML string.
	 */
	public function render( string $template, array $data ): string {
		return $this->engine->render( $template, $data );
	}
}
