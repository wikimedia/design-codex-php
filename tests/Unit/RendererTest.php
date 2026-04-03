<?php
declare( strict_types = 1 );

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
use Wikimedia\Codex\Utility\Sanitizer;

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
		return new class( new Sanitizer() ) extends Renderer {
			public function render( Component $component ): string {
				return '';
			}
		};
	}

	public static function provideExtraClassesAndOtherAttributes() {
		yield 'empty attributes' => [
			[],
			'',
			'',
		];
		yield 'basic attributes' => [
			[
				'id' => 'button1',
				'type' => 'submit',
			],
			' id="button1" type="submit"',
			'',
		];
		yield 'boolean attributes' => [
			[
				'id' => 'button1',
				'disabled' => true,
				'type' => 'submit',
				'readonly' => true,
				'required' => true,
			],
			' id="button1" disabled type="submit" readonly required',
			'',
		];
		yield 'basic attributes with class' => [
			[
				'id' => 'button1',
				'class' => 'foo',
				'type' => 'submit',
			],
			' id="button1" type="submit"',
			' foo',
		];
		yield 'class as array' => [
			[
				'id' => 'button1',
				'class' => [ 'foo', 'bar', 'baz' ],
				'type' => 'submit',
			],
			' id="button1" type="submit"',
			' foo bar baz',
		];
		yield 'attributes with special characters' => [
			[
				'id' => 'button2',
				'a"b' => 'c"d',
				'e' => 'f"g<h>i&j\'l',
				'class' => [ 'he"lp', 'yi>kes' ],
			],
			' id="button2" a&quot;b="c&quot;d" e="f&quot;g&lt;h&gt;i&amp;j&#039;l"',
			' he&quot;lp yi&gt;kes',
		];
	}

	/**
	 * @dataProvider provideExtraClassesAndOtherAttributes
	 */
	public function testExtraClassesAndOtherAttributes(
		array $attributes,
		string $expectedOtherAttrs,
		string $expectedExtraClasses
	) {
		$renderer = $this->getTestRenderer();
		$this->assertSame( $expectedOtherAttrs, $renderer->getOtherAttributes( $attributes ) );
		$this->assertSame( $expectedExtraClasses, $renderer->getExtraClasses( $attributes ) );
	}
}
