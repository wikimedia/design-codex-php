<?php

namespace Wikimedia\Codex\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Wikimedia\Codex\Component\HtmlSnippet;
use Wikimedia\Codex\Sandbox\Example\AccordionExample;
use Wikimedia\Codex\Sandbox\Example\ButtonExample;
use Wikimedia\Codex\Sandbox\Example\CardExample;
use Wikimedia\Codex\Sandbox\Example\CheckboxExample;
use Wikimedia\Codex\Sandbox\Example\FieldExample;
use Wikimedia\Codex\Sandbox\Example\InfoChipExample;
use Wikimedia\Codex\Sandbox\Example\LabelExample;
use Wikimedia\Codex\Sandbox\Example\MessageExample;
use Wikimedia\Codex\Sandbox\Example\ProgressBarExample;
use Wikimedia\Codex\Sandbox\Example\RadioExample;
use Wikimedia\Codex\Sandbox\Example\SelectExample;
use Wikimedia\Codex\Sandbox\Example\TableExample;
use Wikimedia\Codex\Sandbox\Example\TabsExample;
use Wikimedia\Codex\Sandbox\Example\TextAreaExample;
use Wikimedia\Codex\Sandbox\Example\TextInputExample;
use Wikimedia\Codex\Sandbox\Example\ThumbnailExample;
use Wikimedia\Codex\Sandbox\Example\ToggleSwitchExample;
use Wikimedia\Codex\Utility\Codex;

class SnapshotTest extends TestCase {
	private const SNAPSHOT_DELIMITER = "\n\n<!---- ---->\n\n";
	private const SNAPSHOT_FILE = __DIR__ . '/snapshots.txt';

	private ?array $snapshots = null;

	public static function provideSnapshots(): array {
		return [
			// Use all the sandbox examples as snapshots
			[ 'Accordion sandbox', AccordionExample::create( ... ) ],
			[ 'Button sandbox', ButtonExample::create( ... ) ],
			[ 'Card sandbox', CardExample::create( ... ) ],
			[ 'Checkbox sandbox', CheckboxExample::create( ... ) ],
			[ 'Field sandbox', FieldExample::create( ... ) ],
			[ 'InfoChip sandbox', InfoChipExample::create( ... ) ],
			[ 'Label sandbox', LabelExample::create( ... ) ],
			[ 'Message sandbox', MessageExample::create( ... ) ],
			[ 'ProgressBar sandbox', ProgressBarExample::create( ... ) ],
			[ 'Radio sandbox', RadioExample::create( ... ) ],
			[ 'Select sandbox', SelectExample::create( ... ) ],
			[ 'Table sandbox', TableExample::create( ... ) ],
			[ 'Tabs sandbox', TabsExample::create( ... ) ],
			[ 'TextArea sandbox', TextAreaExample::create( ... ) ],
			[ 'TextInput sandbox', TextInputExample::create( ... ) ],
			[ 'Thumbnail sandbox', ThumbnailExample::create( ... ) ],
			[ 'ToggleSwitch sandbox', ToggleSwitchExample::create( ... ) ],

			// Additional tests per component

			// Accordion
			[ 'basic accordion closed with text content', static fn ( Codex $codex ) => $codex->accordion(
				title: 'Some title',
				description: 'Some description',
				content: 'Some plain text content',
				open: false,
				attributes: [ 'id' => 'some-id' ]
			) ],
			[ 'basic accordion open with HTML content', static fn ( Codex $codex ) => $codex->accordion(
				title: 'Some title',
				description: 'Some description',
				content: new HtmlSnippet( '<p>Some content</p>' ),
				open: true,
				attributes: [ 'id' => 'some-id' ]
			) ],
			[ 'accordion without description with text content', static fn ( Codex $codex ) => $codex->accordion(
				title: 'Some title',
				description: '',
				content: 'Some plain text content',
				open: false
			) ],

			// Button
			[ 'default button', static fn ( Codex $codex ) => $codex->button(
				label: 'Click Me'
			) ],
			[ 'primary progressive large button with icon', static fn ( Codex $codex ) => $codex->button(
				label: 'Submit',
				action: 'progressive',
				weight: 'primary',
				size: 'large',
				type: 'submit',
				iconClass: 'icon-submit',
				attributes: [ 'data-action' => 'submit-form' ]
			) ],
			[ 'destructive quiet medium icon-only disabled button', static fn ( Codex $codex ) => $codex->button(
				label: 'Delete',
				action: 'destructive',
				weight: 'quiet',
				size: 'medium',
				type: 'button',
				iconClass: 'icon-delete',
				iconOnly: true,
				disabled: true,
				attributes: [
					'aria-label' => 'Delete Item',
					'id' => 'delete-btn'
				],
			) ],
			[ 'button with custom attributes and no icon', static fn ( Codex $codex ) => $codex->button(
				label: 'Learn More',
				action: 'default',
				weight: 'normal',
				size: 'medium',
				type: 'button',
				iconClass: null,
				iconOnly: false,
				disabled: false,
				attributes: [
					'data-toggle' => 'modal',
					'aria-expanded' => 'false',
				]
			) ],

			// InfoChip
			[ 'infoChip notice', static fn ( Codex $codex ) => $codex->infoChip(
				text: 'Some text',
				attributes: [ 'id' => 'some-id' ],
				status: 'notice'
			) ],
			[ 'infoChip error', static fn ( Codex $codex ) => $codex->infoChip(
				text: 'Some text',
				attributes: [ 'id' => 'some-id' ],
				status: 'error'
			) ],
			// [ 'infoChip with invalid status', static fn ( Codex $codex ) => $codex->infoChip(
			// 	text: 'Some text',
			// 	attributes: [ 'id' => 'some-id' ],
			// 	status: 'foo'
			// ) ],

			// ProgressBar
			[ 'default progress bar', static fn ( Codex $codex ) => $codex->progressBar(
				label: 'Some progress'
			) ],
			[ 'inline progress bar', static fn ( Codex $codex ) => $codex->progressBar(
				label: 'Some processing',
				inline: true
			) ],
			[ 'disabled progress bar', static fn ( Codex $codex ) => $codex->progressBar(
				label: 'Some disabled progress',
				disabled: true
			) ],
			[ 'inline and disabled progress bar with attributes', static fn ( Codex $codex ) => $codex->progressBar(
				label: 'Some progress',
				inline: true,
				disabled: true,
				attributes: [
					'id' => 'some-progress',
					'data-test' => 'some-value',
				]
			) ],
		];
	}

	/**
	 * @dataProvider provideSnapshots
	 * @covers Wikimedia\Codex\Utility\Codex
	 */
	public function testSnapshots( string $name, callable $callback ) {
		$codex = new Codex();
		$this->assertSame( $this->getSnapshot( $name ), (string)$callback( $codex ), $name );
	}

	public static function writeSnapshots( Codex $codex ) {
		$snapshotBlocks = [];
		foreach ( self::provideSnapshots() as $snapshot ) {
			[ $name, $callback ] = $snapshot;
			$snapshotBlocks[] = $name . "\n" . (string)$callback( $codex );
		}

		file_put_contents( self::SNAPSHOT_FILE, implode( self::SNAPSHOT_DELIMITER, $snapshotBlocks ) );
	}

	public function getSnapshot( $name ) {
		if ( $this->snapshots === null ) {
			if ( !file_exists( self::SNAPSHOT_FILE ) ) {
				$this->snapshots = [];
				return null;
			}

			$this->snapshots = [];
			$snapshotBlocks = explode( self::SNAPSHOT_DELIMITER, file_get_contents( self::SNAPSHOT_FILE ) );
			foreach ( $snapshotBlocks as $snapshotBlock ) {
				[ $snapshotName, $html ] = explode( "\n", $snapshotBlock, 2 );
				$this->snapshots[$snapshotName] = $html;
			}
		}

		return $this->snapshots[$name] ?? null;
	}
}
