<?php
/**
 * TemplateParserTest.php
 *
 * This class contains unit tests to verify the correct behavior of the TemplateParser class,
 * including rendering templates with dynamic classes, attributes, and Mustache logic sections.
 *
 * @category Tests\Integration\Parser
 * @package  Codex\Tests\Integration\Parser
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 */

namespace Wikimedia\Codex\Tests\Integration\Parser;

use PHPUnit\Framework\TestCase;
use Wikimedia\Codex\Infrastructure\CodexServices;

/**
 * TemplateParserTest
 *
 * This test verifies the TemplateParser class's behavior with a complex HTML template.
 *
 * @category Tests\Integration\Parser
 * @package  Codex\Tests\Integration\Parser
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 * @covers   \Wikimedia\Codex\Parser\TemplateParser
 */
class TemplateParserTest extends TestCase {

	/**
	 * Provides data for testing different scenarios of processing Mustache templates.
	 *
	 * @since 0.1.0
	 * @return array
	 */
	public function templateDataProvider(): array {
		return [
			'success status with icon' => [
				[
					'status' => 'success',
					'showStatusIcon' => true,
					'attributes' => 'id="info-chip" role="status"',
					'text' => 'Operation completed',
				],
				'<div class="cdx-info-chip cdx-info-chip--success" id="info-chip" role="status">
                    <span class="cdx-info-chip__icon"></span>
                    <span class="cdx-info-chip--text">Operation completed</span>
                </div>',
			],
			'warning status without icon' => [
				[
					'status' => 'warning',
					'showStatusIcon' => true,
					'attributes' => 'id="info-chip" role="status"',
					'text' => 'Operation pending',
				],
				'<div class="cdx-info-chip cdx-info-chip--warning" id="info-chip" role="status">
					<span class="cdx-info-chip__icon"></span>
                    <span class="cdx-info-chip--text">Operation pending</span>
                </div>',
			],
		];
	}

	/**
	 * Test processing a complex HTML template from a Mustache file with data provided by the data provider.
	 *
	 * @since 0.1.0
	 * @dataProvider templateDataProvider
	 *
	 * @param array $data The input data to be rendered in the Mustache template.
	 * @param string $expectedOutput The expected HTML output.
	 *
	 * @return void
	 */
	public function testProcessComplexHtmlTemplateFromFile( array $data, string $expectedOutput ): void {
		// Retrieve the TemplateParser service from CodexServices singleton instance
		$templateParser = CodexServices::getInstance()->getService( 'TemplateParser' );

		// Process the 'info-chip.mustache' template using the provided data
		$result = $templateParser->processTemplate( 'info-chip', $data );

		// Normalize whitespace in both the expected and actual output for comparison purposes
		$normalizedExpectedOutput = preg_replace( '/\s+/', ' ', trim( $expectedOutput ) );
		$normalizedResult = preg_replace( '/\s+/', ' ', trim( $result ) );

		// Verify that the normalized actual output matches the expected output
		$this->assertSame( $normalizedExpectedOutput, $normalizedResult );
	}

	/**
	 * Test that escaping is disabled, and `{{...}}` is equivalent to `{{{...}}}` (we use custom PHP escaping instead
	 * of Mustache escaping).
	 *
	 * @since 0.1.0
	 */
	public function testEscapingIsDisabled(): void {
		$templateParser = CodexServices::getInstance()->getService( 'TemplateParser' );

		$rawValue = '<script>alert( "dQw4w9WgXcQ" )</script>';
		$result = $templateParser->processTemplate( 'accordion', [ 'description' => $rawValue ] );
		$this->assertStringContainsString( $rawValue, $result );
	}
}
