<?php
/**
 * ITemplateRenderer.php
 *
 * This file is part of the Codex PHP library, which provides an interface for rendering templates.
 * The `ITemplateRenderer` interface defines the contract for classes that render templates using
 * various engines, ensuring a consistent method signature across different implementations.
 *
 * @category Contract\Renderer
 * @package  Codex\Contract\Renderer
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */

namespace Wikimedia\Codex\Contract\Renderer;

/**
 * ITemplateRenderer Interface
 *
 * The `ITemplateRenderer` interface provides a contract for rendering templates.
 * Any class implementing this interface must define a `render` method that takes a
 * template name and an array of data to generate the final output.
 *
 * This interface is intended to be implemented by classes that manage the rendering
 * of templates using different engines, such as Mustache or Twig.
 *
 * @category Contract\Renderer
 * @package  Codex\Contract\Renderer
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */
interface ITemplateRenderer {

	/**
	 * Renders a template with the provided data.
	 *
	 * This method is responsible for taking a template file name and an associative
	 * array of data, and then generating the final output based on the template
	 * and the provided data.
	 *
	 * @since 0.1.0
	 * @param string $template The name of the template file to render.
	 * @param array $data An associative array of data to be injected into the template.
	 * @return string The rendered output as a string.
	 */
	public function render( string $template, array $data ): string;
}
