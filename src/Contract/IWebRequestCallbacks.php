<?php
/**
 * IWebRequestCallbacks.php
 *
 * This file is part of the Codex design system, the official design system
 * for Wikimedia projects. It defines the `IWebRequestCallbacks` interface, which outlines
 * the methods required for handling various types of request parameters within
 * the Codex design system. Implementations of this interface can be used to
 * manage query parameters, file uploads, and other types of input data in a
 * consistent and flexible manner.
 *
 * The `IWebRequestCallbacks` interface is crucial for decoupling request handling from
 * specific implementations, allowing for greater flexibility and testability
 * within the Codex system. By defining these methods, developers can create
 * custom implementations that suit their application's needs while adhering to
 * the expected behavior of the Codex components.
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
 * Interface defining callbacks for handling request parameters.
 *
 * The `IWebRequestCallbacks` interface outlines the methods required to interact with
 * various types of request parameters, including query parameters and file
 * uploads. Implementing this interface allows for consistent access to request
 * data across different components of the Codex system.
 *
 * @category Contract
 * @package  Codex\Contract
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */
interface IWebRequestCallbacks {

	/**
	 * Fetch a value from the request.
	 *
	 * This method retrieves the value of a specific parameter from the request.
	 * If the parameter is not present, the provided default value will be returned.
	 * For file upload parameters, this method should return the `$default` value.
	 *
	 * @since 0.1.0
	 * @param string $name The name of the parameter to fetch.
	 * @param mixed $default The default value to return if the parameter is not
	 *                       set in the request.
	 * @param array $options An associative array of options that may modify the
	 *                       behavior of the method.
	 * @return string|string[]|mixed The value of the parameter, or the `$default`
	 *                               value if the parameter is not set.
	 */
	public function getValue( string $name, $default, array $options );

	/**
	 * Fetch multiple values from the request.
	 *
	 * This method retrieves the values of multiple parameters from the request. If a parameter is not present,
	 * it will be omitted from the returned array. This allows for the collection of several parameters at once
	 * without manually checking each one.
	 *
	 * Example usage:
	 *
	 *     $values = $request->getValues('param1', 'param2', 'param3');
	 *
	 * @since 0.1.0
	 * @param string ...$names The names of the parameters to fetch.
	 * @return array An associative array where keys are parameter names and values are the corresponding values from
	 *               the request.
	 */
	public function getValues( string ...$names ): array;
}
