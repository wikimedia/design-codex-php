<?php
/**
 * WebRequestAdapter.php
 *
 * This file is part of the Codex design system, the official design system
 * for Wikimedia projects. It provides the `WebRequestAdapter` class, which
 * implements the `IWebRequest` to adapt the behavior of an underlying
 * request object to conform to the Codex interface. This adapter ensures that
 * request parameters are accessed in a standardized way across the Codex system.
 *
 * The `WebRequestAdapter` class is designed to decouple the request handling
 * from specific implementations, allowing for greater flexibility and
 * consistency within the Codex system. By implementing the `IWebRequest`,
 * this class makes it possible to interact with various request objects in a
 * uniform manner.
 *
 * @category Adapter
 * @package  Codex\Adapter
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */

namespace Wikimedia\Codex\Adapter;

use Wikimedia\Codex\Contract\IWebRequest;

/**
 * WebRequestAdapter adapts a request object to the IWebRequest.
 *
 * The `WebRequestAdapter` class wraps around a request object and provides
 * methods to access request parameters in a way that conforms to the
 * `IWebRequest`. This allows the Codex system to interact with the request
 * object without being tightly coupled to a specific implementation.
 *
 * @category Adapter
 * @package  Codex\Adapter
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */
class WebRequestAdapter implements IWebRequest {

	/**
	 * The underlying request object.
	 *
	 * @var object The request object being adapted.
	 */
	// phpcs:ignore - Intentional use of object as the type
	protected object $request;

	/**
	 * Constructor for WebRequestAdapter.
	 *
	 * This constructor initializes the adapter with the given request object.
	 * The request object must provide a `getVal` method that retrieves request
	 * parameters.
	 *
	 * @since 0.1.0
	 * @param object $request The request object to adapt.
	 */
	// phpcs:ignore - Intentional use of object as the type
	public function __construct( object $request ) {
		$this->request = $request;
	}

	/**
	 * Fetch a value from the request.
	 *
	 * This method retrieves the value of a specific parameter from the underlying
	 * request object. If the parameter is not present, the provided default value
	 * will be returned.
	 *
	 * @since 0.1.0
	 * @param string $name The name of the parameter to fetch.
	 * @param mixed $default The default value to return if the parameter is not
	 *                       set in the request. Defaults to null.
	 *
	 * @return mixed The value of the parameter, or the `$default` value if the
	 *               parameter is not set.
	 */
	public function getVal( string $name, $default = null ) {
		return $this->request->getVal( $name, $default );
	}
}
