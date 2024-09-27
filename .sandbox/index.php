<?php
/**
 * @file
 * Example usage of the Wikimedia Codex PHP library to generate components.
 */

require '../vendor/autoload.php';

use Wikimedia\Codex\Adapter\WebRequestAdapter;
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
use Wikimedia\Codex\Utility\Codex;
use Wikimedia\Codex\Utility\SimpleWebRequest;
use Wikimedia\Codex\Utility\WebRequestCallbacks;

// Initialize Codex instance
$codex = new Codex();

// phpcs:ignore
$request = new SimpleWebRequest($_GET);
$requestAdapter = new WebRequestAdapter( $request );
$callbacks = new WebRequestCallbacks( $requestAdapter );

// Define components and their examples
$examples = [
	'Accordion' => [ 'component' => AccordionExample::create( $codex ),
		'file' => 'src/Example/AccordionExample.php' ],
	'Button' => [ 'component' => ButtonExample::create( $codex ),
		'file' => 'src/Example/ButtonExample.php' ],
	'Card' => [ 'component' => CardExample::create( $codex ),
		'file' => 'src/Example/CardExample.php' ],
	'Checkbox' => [ 'component' => CheckboxExample::create( $codex ),
		'file' => 'src/Example/CheckboxExample.php' ],
	'Field' => [ 'component' => FieldExample::create( $codex ),
		'file' => 'src/Example/FieldExample.php' ],
	'InfoChip' => [ 'component' => InfoChipExample::create( $codex ),
		'file' => 'src/Example/InfoChipExample.php' ],
	'Label' => [ 'component' => LabelExample::create( $codex ),
		'file' => 'src/Example/LabelExample.php' ],
	'Message' => [ 'component' => MessageExample::create( $codex ),
		'file' => 'src/Example/MessageExample.php' ],
	'ProgressBar' => [ 'component' => ProgressBarExample::create( $codex ),
		'file' => 'src/Example/ProgressBarExample.php' ],
	'Radio' => [ 'component' => RadioExample::create( $codex ),
		'file' => 'src/Example/RadioExample.php' ],
	'Select' => [ 'component' => SelectExample::create( $codex ),
		'file' => 'src/Example/SelectExample.php' ],
	'Table' => [ 'component' => TableExample::create( $codex, $callbacks ),
		'file' => 'src/Example/TableExample.php' ],
	'Tabs' => [ 'component' => TabsExample::create( $codex, $callbacks ),
		'file' => 'src/Example/TabsExample.php' ],
	'TextArea' => [ 'component' => TextAreaExample::create( $codex ),
		'file' => 'src/Example/TextAreaExample.php' ],
	'TextInput' => [ 'component' => TextInputExample::create( $codex ),
		'file' => 'src/Example/TextInputExample.php' ],
	'Thumbnail' => [ 'component' => ThumbnailExample::create( $codex ),
		'file' => 'src/Example/ThumbnailExample.php' ],
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Codex Sandbox</title>
	<link rel="icon" href="assets/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="node_modules/@wikimedia/codex/dist/codex.style.css">
	<link rel="stylesheet" href="assets/style.css">
	<link href="node_modules/prismjs/themes/prism-okaidia.css" rel="stylesheet" />
</head>
<body>

<header>
	<div class="cdx-example-hero">
			<span class="cdx-icon cdx-icon--medium cdx-example-hero__icon">
				<img src="assets/wikimedia-logo.svg" alt="Wikimedia Foundation"/>
			</span>
		<h1 class="cdx-example-hero__title">Codex<sup><img src="assets/php-logo.svg" alt="PHP"/></sup></h1>
		<p class="cdx-example-hero__tagline">Wikimedia Design System</p>
		<div class="cdx-example-hero__description">
			<p>This page demonstrates the usage of the Wikimedia Codex PHP library components.</p>
		</div>
	</div>
</header>

<main>
	<?php foreach ( $examples as $title => $example ) { ?>
		<article class="cdx-example-section" aria-labelledby="<?php echo htmlspecialchars( $title ); ?>">
			<h2 class="cdx-example-title" id="<?php echo htmlspecialchars( $title ); ?>">
				<?php echo htmlspecialchars( $title ); ?>
			</h2>
			<div class="cdx-example-body">
				<?php echo $example['component']; ?>
			</div>
			<details class="cdx-example-code">
				<summary>Show Input</summary>
				<pre><code class="language-php"><?php echo htmlspecialchars(
							file_get_contents( $example['file'] ),
							ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8' ); ?></code></pre>
			</details>

			<details class="cdx-example-code">
				<summary>Show Output</summary>
				<pre><code class="language-html"><?php echo htmlspecialchars(
							$example['component'],
							ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8' ); ?></code></pre>
			</details>
		</article>
	<?php } ?>
</main>

<script src="node_modules/prismjs/prism.js"></script>
<script src="node_modules/prismjs/components/prism-markup-templating.js"></script>
<script src="node_modules/prismjs/components/prism-php.min.js"></script>

</body>
</html>

