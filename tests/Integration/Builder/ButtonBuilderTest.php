<?php
/**
 * ButtonBuilderTest.php
 *
 * This class contains integration tests to verify the correct behavior of the Button class,
 * including managing labels, actions, sizes, weights, icons, disabled states, and ensuring proper functionality.
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
use Wikimedia\Codex\Builder\ButtonBuilder;
use Wikimedia\Codex\Infrastructure\CodexServices;
use Wikimedia\Codex\Renderer\ButtonRenderer;

/**
 * ButtonTest
 *
 * This test suite verifies the behavior of the Button class.
 *
 * @category Tests\Integration\Builder
 * @package  Codex\Tests\Integration\Builder
 * @since    0.1.0
 * @author   Doğu Abaris <abaris@null.net>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/main/ Codex Documentation
 * @coversDefaultClass \Wikimedia\Codex\Builder\ButtonBuilder
 */
class ButtonBuilderTest extends TestCase {

	/**
	 * Provides data for testing different scenarios of rendering Button components.
	 *
	 * @since 0.1.0
	 * @return array
	 */
	public function templateDataProvider(): array {
		return [
			'default button' => [
				[
					'label' => 'Click Me',
					'action' => 'default',
					'weight' => 'normal',
					'size' => 'medium',
					'type' => 'button',
					'iconClass' => null,
					'iconOnly' => false,
					'disabled' => false,
					'attributes' => [],
				],
				'<button class="cdx-button" type="button">
                    Click Me
                </button>',
			],
			'primary progressive large button with icon' => [
				[
					'label' => 'Submit',
					'action' => 'progressive',
					'weight' => 'primary',
					'size' => 'large',
					'type' => 'submit',
					'iconClass' => 'icon-submit',
					'iconOnly' => false,
					'disabled' => false,
					'attributes' => [ 'data-action' => 'submit-form' ],
				],
				'<button 
					class="cdx-button cdx-button--action-progressive cdx-button--weight-primary cdx-button--size-large"
					type="submit" data-action="submit-form">
                    <span class="cdx-button__icon icon-submit" aria-hidden="true"></span>
                    Submit
                </button>',
			],
			'destructive quiet medium icon-only disabled button' => [
				[
					'id' => 'delete-btn',
					'label' => 'Delete',
					'action' => 'destructive',
					'weight' => 'quiet',
					'size' => 'medium',
					'type' => 'button',
					'iconClass' => 'icon-delete',
					'iconOnly' => true,
					'disabled' => true,
					'attributes' => [ 'aria-label' => 'Delete Item' ],
				],
				'<button 
					class="cdx-button cdx-button--action-destructive cdx-button--weight-quiet cdx-button--icon-only"
					id="delete-btn" type="button" aria-label="Delete Item" disabled>
                    <span class="cdx-button__icon icon-delete" aria-hidden="true"></span>
                </button>',
			],
			'button with custom attributes and no icon' => [
				[
					'label' => 'Learn More',
					'action' => 'default',
					'weight' => 'normal',
					'size' => 'medium',
					'type' => 'button',
					'iconClass' => null,
					'iconOnly' => false,
					'disabled' => false,
					'attributes' => [ 'data-toggle' => 'modal', 'aria-expanded' => 'false' ],
				],
				'<button class="cdx-button" type="button" data-toggle="modal" aria-expanded="false">
                    Learn More
                </button>',
			],
		];
	}

	/**
	 * Test converting a Button to a string via build using provided data.
	 *
	 * This test ensures that the Button class generates the correct HTML output based on the input properties.
	 *
	 * @since 0.1.0
	 * @covers ::build
	 * @dataProvider templateDataProvider
	 * @param array $data The input data for the Button.
	 * @param string $expectedOutput The expected HTML output.
	 * @return void
	 */
	public function testBuild( array $data, string $expectedOutput ): void {
		$renderer = CodexServices::getInstance()->getService( 'TemplateRenderer' );
		$sanitizer = CodexServices::getInstance()->getService( 'Sanitizer' );
		$buttonRenderer = new ButtonRenderer( $sanitizer, $renderer );
		$button = new ButtonBuilder( $buttonRenderer );

		if ( isset( $data['id'] ) ) {
			$button->setId( $data['id'] );
		}
		if ( isset( $data['label'] ) ) {
			$button->setLabel( $data['label'] );
		}
		if ( isset( $data['action'] ) ) {
			$button->setAction( $data['action'] );
		}
		if ( isset( $data['weight'] ) ) {
			$button->setWeight( $data['weight'] );
		}
		if ( isset( $data['size'] ) ) {
			$button->setSize( $data['size'] );
		}
		if ( isset( $data['type'] ) ) {
			$button->setType( $data['type'] );
		}
		if ( isset( $data['iconClass'] ) ) {
			$button->setIconClass( $data['iconClass'] );
		}
		if ( isset( $data['iconOnly'] ) ) {
			$button->setIconOnly( $data['iconOnly'] );
		}
		if ( isset( $data['disabled'] ) ) {
			$button->setDisabled( $data['disabled'] );
		}
		if ( isset( $data['attributes'] ) ) {
			$button->setAttributes( $data['attributes'] );
		}

		$this->assertSame(
			preg_replace( '/\s+/', ' ', trim( $expectedOutput ) ),
			preg_replace( '/\s+/', ' ', trim( $button->build()->getHtml() ) ),
			'The __toString method should generate the correct HTML output.'
		);
	}
}
