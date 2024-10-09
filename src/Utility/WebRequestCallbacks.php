<?php
/**
 * WebRequestCallbacks.php
 *
 * This file is part of the Codex design system, the official design system
 * for Wikimedia projects. It provides the `WebRequestCallbacks` class, which
 * implements the `IWebRequestCallbacks` interface. This class acts as a bridge between the
 * Codex system and a web request, allowing for standardized access to request
 * parameters.
 *
 * The `WebRequestCallbacks` class adapts a `WebRequestAdapter` to conform to the
 * `IWebRequestCallbacks` interface, enabling the Codex system to interact with request
 * parameters without direct dependency on the web framework.
 *
 * @category Utility
 * @package  Codex\Utility
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */

namespace Wikimedia\Codex\Utility;

use Wikimedia\Codex\Adapter\WebRequestAdapter;
use Wikimedia\Codex\Contract\IWebRequestCallbacks;

/**
 * WebRequestCallbacks provides callback methods for interacting with web requests.
 *
 * The `WebRequestCallbacks` class implements the `IWebRequestCallbacks` interface, using a
 * `WebRequestAdapter` to access request parameters in a standardized way. This
 * allows the Codex system to interact with request data consistently and flexibly.
 *
 * @category Utility
 * @package  Codex\Utility
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */
class WebRequestCallbacks implements IWebRequestCallbacks {

	/**
	 * The adapted web request object.
	 */
	protected WebRequestAdapter $request;

	/**
	 * Constructor for WebRequestCallbacks.
	 *
	 * This constructor initializes the class with a `WebRequestAdapter`, which
	 * provides the necessary methods to retrieve request parameters.
	 *
	 * @since 0.1.0
	 *
	 * @param WebRequestAdapter $request The adapted web request object.
	 */
	public function __construct( WebRequestAdapter $request ) {
		$this->request = $request;
	}

	/**
	 * Fetch a value from the request.
	 *
	 * This method retrieves the value of a specific parameter from the adapted
	 * web request. If the parameter is not present, the provided default value
	 * will be returned.
	 *
	 * @since 0.1.0
	 * @param string $name The name of the parameter to fetch.
	 * @param mixed $default The default value to return if the parameter is not
	 *                        set in the request. Defaults to null.
	 * @param array $options An associative array of options that may modify the
	 *                        behavior of the method. Defaults to an empty array.
	 * @return mixed The value of the parameter, or the `$default` value if the
	 *                        parameter is not set.
	 */
	public function getValue( string $name, $default, array $options = [] ) {
		return $this->request->getVal( $name, $default );
	}

	/**
	 * Fetch multiple values from the request.
	 *
	 * This method retrieves the values of multiple parameters from the adapted
	 * web request. If a parameter is not present, it will be omitted from the
	 * returned array unless a default value is provided.
	 *
	 * @since 0.1.0
	 * @param string ...$names Variadic parameter representing the names of the parameters to fetch.
	 * @return array Associative array where keys are parameter names and values
	 *               are the corresponding values from the request.
	 */
	public function getValues( string ...$names ): array {
		$retVal = [];
		foreach ( $names as $name ) {
			$value = $this->getValue( $name, null );
			if ( $value !== null ) {
				$retVal[$name] = $value;
			}
		}

		return $retVal;
	}
}
