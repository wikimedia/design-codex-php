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
use Wikimedia\Codex\Contract\IWebRequest;

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
 */
class IWebRequestTest extends TestCase {

	/**
	 * Test that the IWebRequest interface has the getVal method.
	 *
	 * @since 0.1.0
	 * @covers \Wikimedia\Codex\Contract\IWebRequest::getVal
	 * @return void
	 */
	public function testHasGetValMethod(): void {
		$this->assertTrue(
			method_exists( IWebRequest::class, 'getVal' ),
			'IWebRequest interface should contain the getVal method.'
		);
	}
}
