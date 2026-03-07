<?php
/**
 * RendererTest.php
 *
 * This class contains unit tests to verify the correct behavior of the abstract Renderer class.
 *
 * @category Tests\Unit
 * @package  Codex\Tests\Unit
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */

namespace Wikimedia\Codex\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Wikimedia\Codex\Contract\Component;
use Wikimedia\Codex\Contract\Renderer;

/**
 * RendererTest
 *
 * This test verifies the abstract Renderer class's handling of HTML attributes.
 *
 * @category Tests\Unit\Traits
 * @package  Codex\Tests\Unit\Traits
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 * @covers   \Wikimedia\Codex\Contract\Renderer
 */
class RendererTest extends TestCase {

	private function getTestRenderer(): Renderer {
		return new class() extends Renderer {
			public function render( Component $component ): string {
				return '';
			}
		};
	}

	/**
	 * Test that an empty array of attributes returns an empty string.
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function testEmptyAttributes(): void {
		$result = $this->getTestRenderer()->resolveAttributes( [] );
		$this->assertSame( '', $result, 'Empty attributes should return an empty string.' );
	}

	/**
	 * Test resolving a basic array of attributes.
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function testBasicAttributes(): void {
		$attributes =
			[
				'id' => 'button1',
				'type' => 'submit',
			];
		$result = $this->getTestRenderer()->resolveAttributes( $attributes );
		$this->assertSame( 'id="button1" type="submit"', $result );
	}

	/**
	 * Test handling boolean attributes (true or false).
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function testBooleanAttributes(): void {
		$attributes =
			[
				'disabled' => true,
				'readonly' => false,
				'required' => true,
			];
		$result = $this->getTestRenderer()->resolveAttributes( $attributes );
		$this->assertSame( 'disabled required', $result );
	}

	/**
	 * Test handling array attributes like class names.
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function testArrayAttributes(): void {
		$attributes = [ 'foo' => 'bar' ];
		$result = $this->getTestRenderer()->resolveAttributes( $attributes );
		$this->assertSame( 'foo="bar"', $result );
	}
}
