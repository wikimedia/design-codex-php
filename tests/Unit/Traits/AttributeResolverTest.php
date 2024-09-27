<?php
/**
 * AttributeResolverTest.php
 *
 * This class contains unit tests to verify the correct behavior of the AttributeResolver trait, which is responsible
 * for converting associative arrays of HTML attributes into a string format suitable for use in HTML tags.
 *
 * @category Tests\Unit\Traits
 * @package  Codex\Tests\Unit\Traits
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */

namespace Wikimedia\Codex\Tests\Unit\Traits;

use PHPUnit\Framework\TestCase;
use Wikimedia\Codex\Traits\AttributeResolver;

/**
 * AttributeResolverTest
 *
 * This test verifies the AttributeResolver trait's handling of HTML attributes.
 *
 * @category Tests\Unit\Traits
 * @package  Codex\Tests\Unit\Traits
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */
class AttributeResolverTest extends TestCase {
	use AttributeResolver;

	/**
	 * Test that an empty array of attributes returns an empty string.
	 *
	 * @since 0.1.0
	 * @covers \Wikimedia\Codex\Traits\AttributeResolver::resolve
	 * @return void
	 */
	public function testEmptyAttributes(): void {
		$result = $this->resolve( [] );
		$this->assertSame( '', $result, 'Empty attributes should return an empty string.' );
	}

	/**
	 * Test resolving a basic array of attributes.
	 *
	 * @since 0.1.0
	 * @covers \Wikimedia\Codex\Traits\AttributeResolver::resolve
	 * @return void
	 */
	public function testBasicAttributes(): void {
		$attributes = [ 'id' => 'button1', 'type' => 'submit' ];
		$result = $this->resolve( $attributes );
		$this->assertSame( 'id="button1" type="submit"', $result );
	}

	/**
	 * Test handling boolean attributes (true or false).
	 *
	 * @since 0.1.0
	 * @covers \Wikimedia\Codex\Traits\AttributeResolver::resolve
	 * @return void
	 */
	public function testBooleanAttributes(): void {
		$attributes = [ 'disabled' => true, 'readonly' => false, 'required' => true ];
		$result = $this->resolve( $attributes );
		$this->assertSame( 'disabled required', $result );
	}

	/**
	 * Test handling array attributes like class names.
	 *
	 * @since 0.1.0
	 * @covers \Wikimedia\Codex\Traits\AttributeResolver::resolve
	 * @return void
	 */
	public function testArrayAttributes(): void {
		$attributes = [ 'foo' => 'bar' ];
		$result = $this->resolve( $attributes );
		$this->assertSame( 'foo="bar"', $result );
	}

	/**
	 * Test special characters are properly escaped in attribute values.
	 *
	 * @since 0.1.0
	 * @covers \Wikimedia\Codex\Traits\AttributeResolver::resolve
	 * @return void
	 */
	public function testSpecialCharactersEscaping(): void {
		$attributes = [ 'title' => 'This is "special" & important' ];
		$result = $this->resolve( $attributes );
		$this->assertSame( 'title="This is &quot;special&quot; &amp; important"', $result );
	}
}
