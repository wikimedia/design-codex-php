<?php
/**
 * WebRequestAdapterTest.php
 *
 * This class contains unit tests to verify the correct behavior of the WebRequestAdapter,
 * including handling request data, returning default values, and interacting with IWebRequest.
 *
 * @category Tests\Unit\Adapter
 * @package  Codex\Tests\Unit\Adapter
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 * @phan-file-suppress PhanTypeMismatchArgumentProbablyReal
 */

namespace Wikimedia\Codex\Tests\Unit\Adapter;

use PHPUnit\Framework\TestCase;
use Wikimedia\Codex\Adapter\WebRequestAdapter;
use Wikimedia\Codex\Contract\IWebRequest;

/**
 * WebRequestAdapterTest
 *
 * This test suite verifies the behavior of the WebRequestAdapter, including request data handling
 * and default value functionality.
 *
 * @category Tests\Unit\Adapter
 * @package  Codex\Tests\Unit\Adapter
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 * @coversDefaultClass \Wikimedia\Codex\Adapter\WebRequestAdapter
 */
class WebRequestAdapterTest extends TestCase {

	/**
	 * Test that getVal returns the correct value from the request.
	 *
	 * @since 0.1.0
	 * @covers ::getVal
	 * @return void
	 */
	public function testGetValReturnsCorrectValue(): void {
		$request = $this->createMock( IWebRequest::class );
		$request->method( 'getVal' )->with( 'key' )->willReturn( 'value' );

		$adapter = new WebRequestAdapter( $request );
		$this->assertEquals(
			'value',
			$adapter->getVal( 'key' ),
			'getVal should return the correct value.'
		);
	}

	/**
	 * Test that getVal returns the default value if the key does not exist.
	 *
	 * @since 0.1.0
	 * @covers ::getVal
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
}
