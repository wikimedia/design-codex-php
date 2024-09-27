<?php
/**
 * IWebRequestCallbacksTest.php
 *
 * This class contains unit tests to verify the existence of necessary methods
 * defined in the IWebRequestCallbacks interface.
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
use Wikimedia\Codex\Contract\IWebRequestCallbacks;

/**
 * CallbacksTest
 *
 * This test suite verifies that the IWebRequestCallbacks interface contains the required methods.
 *
 * @category Tests\Unit\Contract
 * @package  Codex\Tests\Unit\Contract
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */
class IWebRequestCallbacksTest extends TestCase {

	/**
	 * Test that the IWebRequestCallbacks interface has the getValue method.
	 *
	 * @since 0.1.0
	 * @covers \Wikimedia\Codex\Contract\IWebRequestCallbacks::getValue
	 * @return void
	 */
	public function testHasGetValueMethod(): void {
		$this->assertTrue(
			method_exists( IWebRequestCallbacks::class, 'getValue' ),
			'IWebRequestCallbacks interface should contain the getValue method.'
		);
	}

	/**
	 * Test that the IWebRequestCallbacks interface has the getValues method.
	 *
	 * @since 0.1.0
	 * @covers \Wikimedia\Codex\Contract\IWebRequestCallbacks::getValues
	 * @return void
	 */
	public function testHasGetValuesMethod(): void {
		$this->assertTrue(
			method_exists( IWebRequestCallbacks::class, 'getValues' ),
			'IWebRequestCallbacks interface should contain the getValues method.'
		);
	}
}
