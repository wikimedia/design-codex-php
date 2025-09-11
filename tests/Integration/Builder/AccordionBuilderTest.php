<?php
/**
 * AccordionBuilderTest.php
 *
 * This class contains integration tests to verify the correct behavior of the Accordion class,
 * including managing items, attributes, and ensuring proper functionality.
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
use Wikimedia\Codex\Builder\AccordionBuilder;
use Wikimedia\Codex\Component\HtmlSnippet;
use Wikimedia\Codex\Infrastructure\CodexServices;
use Wikimedia\Codex\Renderer\AccordionRenderer;

/**
 * AccordionTest
 *
 * This test suite verifies the behavior of the Accordion class.
 *
 * @category Tests\Integration\Builder
 * @package  Codex\Tests\Integration\Builder
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 * @covers   \Wikimedia\Codex\Builder\AccordionBuilder
 */
class AccordionBuilderTest extends TestCase {

	/**
	 * Provides data for testing different scenarios of rendering Accordion components.
	 *
	 * @since 0.1.0
	 * @return array
	 */
	public static function templateDataProvider(): array {
		return [
			'basic accordion closed with text content' => [
				[
					'title' => 'Some title',
					'description' => 'Some description',
					'content' => 'Some plain text content',
					'isOpen' => false,
					'attributes' => [ 'id' => 'some-id' ],
				],
				'<details class="cdx-accordion" id="some-id">
                    <summary>
                        <h3 class="cdx-accordion__header">
                            <span class="cdx-accordion__header__title">Some title</span>
                            <span class="cdx-accordion__header__description">Some description</span>
                        </h3>
                    </summary>
                    <div class="cdx-accordion__content">
                        Some plain text content
                    </div>
                </details>',
			],
			'basic accordion open with HTML content' => [
				[
					'title' => 'Some title',
					'description' => 'Some description',
					'content' => new HtmlSnippet( '<p>Some content</p>' ),
					'isOpen' => true,
					'attributes' => [ 'id' => 'some-id' ],
				],
				'<details class="cdx-accordion" id="some-id" open>
                    <summary>
                        <h3 class="cdx-accordion__header">
                            <span class="cdx-accordion__header__title">Some title</span>
                            <span class="cdx-accordion__header__description">Some description</span>
                        </h3>
                    </summary>
                    <div class="cdx-accordion__content">
                        <p>Some content</p>
                    </div>
                </details>',
			],
			'accordion without description with text content' => [
				[
					'title' => 'Some title',
					'description' => '',
					'content' => 'Some plain text content',
					'isOpen' => false,
					'attributes' => [],
				],
				'<details class="cdx-accordion">
                    <summary>
                        <h3 class="cdx-accordion__header">
                            <span class="cdx-accordion__header__title">Some title</span>
                        </h3>
                    </summary>
                    <div class="cdx-accordion__content">
                        Some plain text content
                    </div>
                </details>',
			],
		];
	}

	/**
	 * Test converting an Accordion to a string via build using provided data.
	 *
	 * @since 0.1.0
	 * @dataProvider templateDataProvider
	 *
	 * @param array $data The input data for the Accordion.
	 * @param string $expectedOutput The expected HTML output.
	 *
	 * @return void
	 */
	public function testBuild( array $data, string $expectedOutput ): void {
		$templateParser = CodexServices::getInstance()->getService( 'TemplateParser' );
		$sanitizer = CodexServices::getInstance()->getService( 'Sanitizer' );
		$accordionRenderer = new AccordionRenderer( $sanitizer, $templateParser );
		$accordion = new AccordionBuilder( $accordionRenderer );

		$accordion->setTitle( $data['title'] )
			->setDescription( $data['description'] )
			->setOpen( $data['isOpen'] )
			->setContent( $data['content'] )
			->setAttributes( $data['attributes'] );

		$this->assertSame(
			preg_replace( '/\s+/', ' ', trim( $expectedOutput ) ),
			preg_replace( '/\s+/', ' ', trim( $accordion->build()->getHtml() ) ),
			'The getHtml() method should return the correct HTML output.'
		);
	}
}
