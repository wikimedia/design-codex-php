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
use Wikimedia\Codex\Builder\HtmlSnippetBuilder;
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
 * @coversDefaultClass \Wikimedia\Codex\Builder\AccordionBuilder
 */
class AccordionBuilderTest extends TestCase {

	/**
	 * Provides data for testing different scenarios of rendering Accordion components.
	 *
	 * @since 0.1.0
	 * @return array
	 */
	public function templateDataProvider(): array {
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
				'setContentText',
			],
			'basic accordion open with HTML content' => [
				[
					'title' => 'Some title',
					'description' => 'Some description',
					'content' => '<p>Some content</p>',
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
				'setContentHtml',
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
				'setContentText',
			],
		];
	}

	/**
	 * Test converting an Accordion to a string via build using provided data.
	 *
	 * @since 0.1.0
	 * @covers ::build
	 * @dataProvider templateDataProvider
	 * @param array $data The input data for the Accordion.
	 * @param string $expectedOutput The expected HTML output.
	 * @param string $contentMethod The content method to use ('setContentText' or 'setContentHtml').
	 * @return void
	 */
	public function testBuild( array $data, string $expectedOutput, string $contentMethod ): void {
		$renderer = CodexServices::getInstance()->getService( 'TemplateRenderer' );
		$sanitizer = CodexServices::getInstance()->getService( 'Sanitizer' );
		$accordionRenderer = new AccordionRenderer( $sanitizer, $renderer );
		$accordion = new AccordionBuilder( $accordionRenderer );
		$htmlSnippet = new HtmlSnippetBuilder( $sanitizer );

		if ( $contentMethod === 'setContentHtml' ) {
			$accordion->setContentHtml( $htmlSnippet->setContent( $data['content'] )->build() );
		} else {
			$accordion->setContentText( $data['content'] );
		}

		$accordion->setTitle( $data['title'] )
		->setDescription( $data['description'] )
		->setOpen( $data['isOpen'] )
		->setAttributes( $data['attributes'] );

		$this->assertSame(
		preg_replace( '/\s+/', ' ', trim( $expectedOutput ) ),
		preg_replace( '/\s+/', ' ', trim( $accordion->build()->getHtml() ) ),
		'The __toString method should generate the correct HTML output.'
		);
	}
}
