<?php
/**
 * ServiceContainer.php
 *
 * This class provides a simple implementation of a Dependency Injection (DI) container.
 * It allows services to be registered and lazily resolved. Services are registered with
 * a name and a resolver function, which is executed to instantiate the service when
 * needed. The container stores these services and resolves them when requested.
 *
 * This container does not throw exceptions if a service is not found; instead, it
 * returns `null` if a service cannot be resolved.
 *
 * @category Infrastructure
 * @package  Codex\Infrastructure
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */

namespace Wikimedia\Codex\Infrastructure;

use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * ServiceContainer
 *
 * The `ServiceContainer` class is responsible for managing Dependency Injection (DI) by registering and
 * resolving services. It allows services to be lazily instantiated only when needed, using callable resolvers
 * or method references. Once a service is resolved, it is stored in memory to avoid redundant instantiation.
 *
 * Key Responsibilities:
 * - Register services using a name and a resolver (callable or method reference).
 * - Resolve services on demand.
 * - Provide methods for monitoring the service resolution process.
 * - Handle and log failed service lookups to avoid redundant error logging.
 *
 * Usage:
 * - Services are registered via the `register()` method.
 * - Services can be retrieved via the `getService()` method.
 * - Handle non-existent services gracefully.
 *
 * @category Infrastructure
 * @package  Codex\Infrastructure
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */
class ServiceContainer {

	/**
	 * Array of registered services.
	 *
	 * This array stores the resolver functions for each registered service.
	 */
	private array $services = [];

	/**
	 * Cache for failed service lookups to avoid repeated error logging.
	 */
	private array $failedServices = [];

	/**
	 * Logger instance for logging errors and other messages.
	 */
	private LoggerInterface $logger;

	/**
	 * Constructor for ServiceContainer.
	 */
	public function __construct( LoggerInterface $logger = null ) {
		$this->logger = $logger ?: new NullLogger();
	}

	/**
	 * Resolve a service from the container.
	 *
	 * @since 0.1.0
	 * @param string $name The name of the service to resolve.
	 * @return mixed|null Returns the service instance, or `null` if the service is not found.
	 */
	public function getService( string $name ) {
		// Resolve the service if registered
		if ( isset( $this->services[$name] ) ) {
			$resolver = $this->services[$name];

			if ( is_callable( $resolver ) ) {
				return $resolver( $this );
			} elseif ( is_array( $resolver ) && method_exists( $resolver[0], $resolver[1] ) ) {
				return call_user_func( $resolver, $this );
			}
		}

		// Handle non-existent service
		if ( !isset( $this->failedServices[$name] ) ) {
			$this->failedServices[$name] = true;
			$this->logger->error( "Service '$name' is not registered in the container." );
		}

		return null;
	}

	/**
	 * Apply a wiring configuration to register multiple services.
	 *
	 * @since 0.1.0
	 * @param array $wiring The service wiring configuration.
	 * @return void
	 */
	public function applyWiring( array $wiring ): void {
		foreach ( $wiring as $name => $resolver ) {
			$this->register( $name, $resolver );
		}
	}

	/**
	 * Register a service in the container.
	 *
	 * @since 0.1.0
	 * @param string $name The unique name of the service.
	 * @param mixed $resolver The function, method reference, or object to return the service instance.
	 * @return void
	 */
	public function register( string $name, $resolver ): void {
		if ( !is_callable( $resolver ) && !is_array( $resolver ) ) {
			throw new InvalidArgumentException( 'Service resolver must be a callable or an array.' );
		}

		$this->services[$name] = $resolver;
	}
}
