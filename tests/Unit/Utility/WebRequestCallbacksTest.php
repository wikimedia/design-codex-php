<?php
/**
 * WebRequestCallbacksTest.php
 *
 * This class contains unit tests to verify the correct behavior of the WebRequestCallbacks,
 * including callback data retrieval from WebRequestAdapter.
 *
 * @category Tests\Unit\Utility
 * @package  Codex\Tests\Unit\Utility
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 * @phan-file-suppress PhanTypeMismatchArgument
 */

namespace Wikimedia\Codex\Tests\Unit\Utility;

use PHPUnit\Framework\TestCase;
use Wikimedia\Codex\Adapter\WebRequestAdapter;
use Wikimedia\Codex\Contract\IWebRequest;
use Wikimedia\Codex\Utility\WebRequestCallbacks;

/**
 * WebRequestCallbacksTest
 *
 * This test suite verifies the behavior of the WebRequestCallbacks, including callback data handling.
 *
 * @category Tests\Unit\Utility
 * @package  Codex\Tests\Unit\Utility
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */
class WebRequestCallbacksTest extends TestCase {

	/**
	 * Test that getCallbackData returns the correct value from the adapter.
	 *
	 * @since 0.1.0
	 * @covers \Wikimedia\Codex\Adapter\WebRequestAdapter::getVal
	 * @return void
	 */
	public function testGetValReturnsDefaultValue(): void {
		$request = $this->createMock( IWebRequest::class );
		$request->expects( $this->once() )->method(
			'getVal' )->willReturnCallback( static function ( $name, $default ) {
				return $default;
			} );

		$adapter = new WebRequestAdapter( $request );
		$this->assertEquals(
			'default',
			$adapter->getVal( 'nonexistent', 'default' ),
			'getVal should return the default value when the key is missing.'
		);
	}

	/**
	 * Test that getCallbackData returns the default value if the key does not exist.
	 *
	 * @since 0.1.0
	 * @covers \Wikimedia\Codex\Utility\WebRequestCallbacks::getValue
	 * @return void
	 */
	public function testGetCallbackDataReturnsDefaultValue(): void {
		$adapter = $this->createMock( WebRequestAdapter::class );
		$adapter->method( 'getVal' )->willReturnCallback( static function ( $name, $default ) {
			return $default;
		} );

		$callbacks = new WebRequestCallbacks( $adapter );
		$this->assertEquals(
			'default_value',
			$callbacks->getValue( 'nonexistent_key', 'default_value' ),
			'getCallbackData should return the default value when the key is missing.'
		);
	}
}
