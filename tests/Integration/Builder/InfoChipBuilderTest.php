<?php
/**
 * InfoChipBuilderTest.php
 *
 * This class contains integration tests to verify the correct behavior of the InfoChip class,
 * including managing text, status, icon, and attributes with the actual rendering services.
 *
 * @category Tests\Integration\Builder
 * @package  Codex\Tests\Integration\Builder
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */

namespace Wikimedia\Codex\Tests\Integration\Builder;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Wikimedia\Codex\Builder\InfoChipBuilder;
use Wikimedia\Codex\Infrastructure\CodexServices;
use Wikimedia\Codex\Renderer\InfoChipRenderer;

/**
 * InfoChipTest
 *
 * This test suite verifies the behavior of the InfoChip class.
 *
 * @category Tests\Integration\Builder
 * @package  Codex\Tests\Integration\Builder
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 * @covers   \Wikimedia\Codex\Builder\InfoChipBuilder
 */
class InfoChipBuilderTest extends TestCase {

	/**
	 * Provides data for testing different scenarios of rendering InfoChip components.
	 *
	 * @since 0.1.0
	 * @return array
	 */
	public function templateDataProvider(): array {
		return [
			'success status with icon' => [
				[
					'text' => 'Some text',
					'status' => 'notice',
					'icon' => 'some-icon',
					'attributes' => [ 'id' => 'some-id' ],
				],
				'<div class="cdx-info-chip cdx-info-chip--notice" id="some-id">
					<span class="cdx-info-chip--icon some-icon" aria-hidden="true"></span>
					<span class="cdx-info-chip--text">Some text</span>
				</div>',
			],
			'warning status without icon' => [
				[
					'text' => 'Some text',
					'status' => 'notice',
					'attributes' => [ 'id' => 'some-id' ],
				],
				'<div class="cdx-info-chip cdx-info-chip--notice" id="some-id">
					<span class="cdx-info-chip--text">Some text</span>
				</div>',
			],
			'bad example with invalid status' => [
				[
					'text' => 'Some text',
					'status' => 'foo',
					'attributes' => [ 'id' => 'some-id' ],
				],
				'<div class="cdx-info-chip cdx-info-chip--foo" id="some-id">
					<span class="cdx-info-chip--text">Some text</span>
				</div>',
			],
		];
	}

	/**
	 * Test converting an InfoChip to a string via build using provided data.
	 *
	 * @since 0.1.0
	 * @dataProvider templateDataProvider
	 *
	 * @param array $data The input data for the InfoChip.
	 * @param string $expectedOutput The expected HTML output.
	 *
	 * @return void
	 */
	public function testBuild( array $data, string $expectedOutput ): void {
		$templateParser = CodexServices::getInstance()->getService( 'TemplateParser' );
		$sanitizer = CodexServices::getInstance()->getService( 'Sanitizer' );
		$infoChipRenderer = new InfoChipRenderer( $sanitizer, $templateParser );
		$infoChip = new InfoChipBuilder( $infoChipRenderer );

		if ( $data['status'] == "foo" ) {
			// Ensure that invalid status arguments throw an exception
			$this->expectException( InvalidArgumentException::class );
			$infoChip->setText( $data['text'] )
				->setStatus( $data['status'] )
				->setIcon( $data['icon'] ?? null )
				->setAttributes( $data['attributes'] ?? [] );
		} else {
			$infoChip->setText( $data['text'] )
				->setStatus( $data['status'] )
				->setIcon( $data['icon'] ?? null )
				->setAttributes( $data['attributes'] ?? [] );

			$this->assertSame(
				preg_replace( '/\s+/', ' ', trim( $expectedOutput ) ),
				preg_replace( '/\s+/', ' ', trim( $infoChip->build()->getHtml() ) ),
				'The getHtml() method should return the correct HTML output.'
			);
		}
	}
}
