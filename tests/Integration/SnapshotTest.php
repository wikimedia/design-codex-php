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
			[ 'basic accordion closed with text content', static fn ( Codex $codex ) => $codex->accordion()
				->setTitle( 'Some title' )
				->setDescription( 'Some description' )
				->setContent( 'Some plain text content' )
				->setOpen( false )
				->setAttributes( [ 'id' => 'some-id' ] )
				->build()
				->getHtml()
			],
			[ 'basic accordion open with HTML content', static fn ( Codex $codex ) => $codex->accordion()
				->setTitle( 'Some title' )
				->setDescription( 'Some description' )
				->setContent( new HtmlSnippet( '<p>Some content</p>' ) )
				->setOpen( true )
				->setAttributes( [ 'id' => 'some-id' ] )
				->build()
				->getHtml()
			],
			[ 'accordion without description with text content', static fn ( Codex $codex ) => $codex->accordion()
				->setTitle( 'Some title' )
				->setDescription( '' )
				->setContent( 'Some plain text content' )
				->setOpen( false )
				->build()
				->getHtml()
			],

			// Button
			[ 'default button', static fn ( Codex $codex ) => $codex->button()
				->setLabel( 'Click Me' )
				->build()
				->getHtml()
			],
			[ 'primary progressive large button with icon', static fn ( Codex $codex ) => $codex->button()
				->setLabel( 'Submit' )
				->setAction( 'progressive' )
				->setWeight( 'primary' )
				->setSize( 'large' )
				->setType( 'submit' )
				->setIconClass( 'icon-submit' )
				->setAttributes( [ 'data-action' => 'submit-form' ] )
				->build()
				->getHtml()
			],
			[ 'destructive quiet medium icon-only disabled button', static fn ( Codex $codex ) => $codex->button()
				->setId( 'delete-btn' )
				->setLabel( 'Delete' )
				->setAction( 'destructive' )
				->setWeight( 'quiet' )
				->setSize( 'medium' )
				->setType( 'button' )
				->setIconClass( 'icon-delete' )
				->setIconOnly( true )
				->setDisabled( true )
				->setAttributes( [ 'aria-label' => 'Delete Item' ] )
				->build()
				->getHtml()
			],
			[ 'button with custom attributes and no icon', static fn ( Codex $codex ) => $codex->button()
				->setLabel( 'Learn More' )
				->setAction( 'default' )
				->setWeight( 'normal' )
				->setSize( 'medium' )
				->setType( 'button' )
				->setAttributes( [
					'data-toggle' => 'modal',
					'aria-expanded' => 'false',
				] )
				->build()
				->getHtml()
			],

			// InfoChip
			[ 'infoChip notice', static fn ( Codex $codex ) => $codex->infoChip()
				->setText( 'Some text' )
				->setAttributes( [ 'id' => 'some-id' ] )
				->setStatus( 'notice' )
				->build()
				->getHtml()
			],
			[ 'infoChip error', static fn ( Codex $codex ) => $codex->infoChip()
				->setText( 'Some text' )
				->setAttributes( [ 'id' => 'some-id' ] )
				->setStatus( 'error' )
				->build()
				->getHtml()
			],
			// [ 'infoChip with invalid status', static fn ( Codex $codex ) => $codex->infoChip()
			// 	->setText( 'Some text' )
			// 	->setAttributes( [ 'id' => 'some-id' ] )
			// 	->setStatus( 'foo' )
			// 	->build()
			// 	->getHtml()
			// ],

			// ProgressBar
			[ 'default progress bar', static fn ( Codex $codex ) => $codex->progressBar()
				->setLabel( 'Some progress' )
				->build()
				->getHtml()
			],
			[ 'inline progress bar', static fn ( Codex $codex ) => $codex->progressBar()
				->setLabel( 'Some processing' )
				->setInline( true )
				->build()
				->getHtml()
			],
			[ 'disabled progress bar', static fn ( Codex $codex ) => $codex->progressBar()
				->setLabel( 'Some disabled progress' )
				->setDisabled( true )
				->build()
				->getHtml()
			],
			[ 'inline and disabled progress bar with attributes', static fn ( Codex $codex ) => $codex->progressBar()
				->setLabel( 'Some progress' )
				->setInline( true )
				->setDisabled( true )
				->setAttributes( [
					'id' => 'some-progress',
					'data-test' => 'some-value',
				] )
				->build()
				->getHtml()
			],
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
