<?php
/**
 * SimpleWebRequest.php
 *
 * This file is part of the Codex design system, the official design system
 * for Wikimedia projects. It provides the `SimpleWebRequest` class, which
 * implements the `IWebRequest` interface. This class serves as a simple wrapper
 * around an associative array, providing standardized access to web request data
 * for Codex components.
 *
 * The `SimpleWebRequest` class enables Codex to interact with request data in a consistent
 * manner without being tightly coupled to a specific web framework.
 *
 * @category Utility
 * @package  Codex\Utility
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */

namespace Wikimedia\Codex\Utility;

use Wikimedia\Codex\Contract\IWebRequest;

/**
 * SimpleWebRequest provides access to web request data using an array structure.
 *
 * The `SimpleWebRequest` class implements the `IWebRequest` interface, allowing it
 * to provide a simple, array-based mechanism for accessing request parameters.
 * It adapts an associative array of request data, allowing Codex components to
 * retrieve values in a standardized way.
 *
 * @category Utility
 * @package  Codex\Utility
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */
class SimpleWebRequest implements IWebRequest {

	/**
	 * The array containing request data.
	 */
	protected array $data;

	/**
	 * Constructor for SimpleWebRequest.
	 *
	 * @param array $data The array containing request data.
	 */
	public function __construct( array $data ) {
		$this->data = $data;
	}

	/**
	 * Fetch a value from the request data.
	 *
	 * This method retrieves the value of a specific parameter from the data array.
	 * If the parameter is not present, the provided default value will be returned.
	 *
	 * @since 1.0.0
	 * @param string $name The name of the parameter to fetch.
	 * @param mixed $default The default value to return if the parameter is not
	 *                       set in the request data. Defaults to null.
	 * @return mixed The value of the parameter, or the `$default` value if the
	 *               parameter is not set.
	 */
	public function getVal( string $name, $default = null ) {
		return $this->data[$name] ?? $default;
	}
}
