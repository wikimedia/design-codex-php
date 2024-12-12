<?php
/**
 * IWebRequestTest.php
 *
 * This class contains unit tests to verify the existence of necessary methods
 * defined in the IWebRequest interface.
 *
 * @category Tests\Unit\Contract
 * @package  Codex\Tests\Unit\Contract
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */

namespace Wikimedia\Codex\Tests\Unit\Contract;

use PHPUnit\Framework\TestCase;
use Wikimedia\Codex\Utility\SimpleWebRequest;

/**
 * IWebRequestTest
 *
 * This test suite verifies that the IWebRequest interface contains the required methods.
 *
 * @category Tests\Unit\Contract
 * @package  Codex\Tests\Unit\Contract
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 * @coversDefaultClass \Wikimedia\Codex\Contract\IWebRequest
 */
class IWebRequestTest extends TestCase {
	/**
	 * Test that the getVal method of SimpleWebRequest returns the expected value.
	 *
	 * @since 0.1.0
	 * @covers ::getVal
	 * @return void
	 */
	public function testGetValReturnsExpectedValue(): void {
		$data = [ 'key' => 'expectedValue' ];
		$request = new SimpleWebRequest( $data );

		$result = $request->getVal( 'key' );

		$this->assertEquals( 'expectedValue', $result );
	}

	/**
	 * Test that the getVal method returns the default value when the key is not present.
	 *
	 * @since 0.1.0
	 * @covers ::getVal
	 * @return void
	 */
	public function testGetValReturnsDefaultValueWhenKeyNotPresent(): void {
		$data = [];
		$request = new SimpleWebRequest( $data );

		$result = $request->getVal( 'nonExistingKey', 'defaultValue' );

		$this->assertEquals( 'defaultValue', $result );
	}
}
