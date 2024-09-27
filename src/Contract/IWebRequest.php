<?php
/**
 * IWebRequest.php
 *
 * This file is part of the Codex design system, the official design system
 * for Wikimedia projects. It defines the `IWebRequest` interface, which
 * outlines the method required for retrieving request parameters within the
 * Codex design system. Implementations of this interface can be used to
 * manage query parameters in a consistent and flexible manner.
 *
 * The `IWebRequest` is essential for standardizing the way request
 * parameters are accessed, allowing for greater flexibility and consistency
 * within the Codex system. By defining this method, developers can create
 * custom implementations that suit their application's needs while adhering
 * to the expected behavior of the Codex components.
 *
 * @category Contract
 * @package  Codex\Contract
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */

namespace Wikimedia\Codex\Contract;

/**
 * Interface defining a method for retrieving request parameters.
 *
 * The `IWebRequest` outlines the method required to interact with
 * request parameters, providing a consistent way to fetch values from the request.
 * Implementing this interface ensures that request data can be accessed
 * consistently across different components of the Codex system.
 *
 * @category Contract
 * @package  Codex\Contract
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */
interface IWebRequest {

	/**
	 * Fetch a value from the request.
	 *
	 * This method retrieves the value of a specific parameter from the request.
	 * If the parameter is not present, the provided default value will be returned.
	 *
	 * @since 0.1.0
	 * @param string $name The name of the parameter to fetch.
	 * @param mixed $default The default value to return if the parameter is not
	 *                        set in the request. Defaults to null.
	 * @return mixed The value of the parameter, or the `$default` value if the
	 *               parameter is not set.
	 */
	public function getVal( string $name, $default = null );
}
