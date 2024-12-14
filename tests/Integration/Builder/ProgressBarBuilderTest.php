<?php
/**
 * ProgressBarBuilderTest.php
 *
 * This class contains integration tests to verify the correct behavior of the ProgressBar class,
 * including managing the label, inline state, disabled state, and custom attributes.
 *
 * @category Tests\Integration\Builder
 * @package  Codex\Tests\Integration\Builder
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */

namespace Wikimedia\Codex\Tests\Integration\Builder;

use PHPUnit\Framework\TestCase;
use Wikimedia\Codex\Builder\ProgressBarBuilder;
use Wikimedia\Codex\Infrastructure\CodexServices;
use Wikimedia\Codex\Renderer\ProgressBarRenderer;

/**
 * ProgressBarTest
 *
 * This test suite verifies the behavior of the ProgressBar class.
 *
 * @category Tests\Integration\Builder
 * @package  Codex\Tests\Integration\Builder
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 * @covers   \Wikimedia\Codex\Builder\ProgressBarBuilder
 */
class ProgressBarBuilderTest extends TestCase {

	/**
	 * Provides data for testing different scenarios of rendering ProgressBar components.
	 *
	 * @since 0.1.0
	 * @return array
	 */
	public function templateDataProvider(): array {
		return [
			'default progress bar' => [
				[
					'label' => 'Some progress',
					'isInline' => false,
					'isDisabled' => false,
					'attributes' => [],
				],
				'<div class="cdx-progress-bar" role="progressbar" aria-label="Some progress">
                    <div class="cdx-progress-bar__bar"></div>
                </div>',
			],
			'inline progress bar' => [
				[
					'label' => 'Some processing',
					'isInline' => true,
					'isDisabled' => false,
					'attributes' => [],
				],
				'<div class="cdx-progress-bar cdx-progress-bar--inline"
						role="progressbar" aria-label="Some processing">
                    <div class="cdx-progress-bar__bar"></div>
                </div>',
			],
			'disabled progress bar' => [
				[
					'label' => 'Some disabled progress',
					'isInline' => false,
					'isDisabled' => true,
					'attributes' => [],
				],
				'<div class="cdx-progress-bar cdx-progress-bar--disabled" role="progressbar"
						aria-label="Some disabled progress">
                    <div class="cdx-progress-bar__bar"></div>
                </div>',
			],
			'inline and disabled progress bar with attributes' => [
				[
					'label' => 'Some progress',
					'isInline' => true,
					'isDisabled' => true,
					'attributes' => [
						'id' => 'some-progress',
						'data-test' => 'some-value',
					],
				],
				'<div class="cdx-progress-bar cdx-progress-bar--inline cdx-progress-bar--disabled" role="progressbar"
					aria-label="Some progress" id="some-progress" data-test="some-value">
                    <div class="cdx-progress-bar__bar"></div>
                </div>',
			],
		];
	}

	/**
	 * Test converting an ProgressBar to a string via build using provided data.
	 *
	 * @since 0.1.0
	 * @dataProvider templateDataProvider
	 *
	 * @param array $data The input data for the ProgressBar.
	 * @param string $expectedOutput The expected HTML output.
	 *
	 * @return void
	 */
	public function testBuild( array $data, string $expectedOutput ): void {
		$templateParser = CodexServices::getInstance()->getService( 'TemplateParser' );
		$sanitizer = CodexServices::getInstance()->getService( 'Sanitizer' );
		$progressBarRenderer = new ProgressBarRenderer( $sanitizer, $templateParser );
		$progressBar = new ProgressBarBuilder( $progressBarRenderer );

		$progressBar->setLabel( $data['label'] )
			->setInline( $data['isInline'] )
			->setDisabled( $data['isDisabled'] )
			->setAttributes( $data['attributes'] );

		$this->assertSame(
			preg_replace( '/\s+/', ' ', trim( $expectedOutput ) ),
			preg_replace( '/\s+/', ' ', trim( $progressBar->build()->getHtml() ) ),
			'The getHtml() method should return the correct HTML output.'
		);
	}
}
