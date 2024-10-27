
# Wikimedia Codex

A PHP library for generating markup for Codex CSS-only components using a builder-based methodology.
This library leverages the Codex design system,
providing a PHP-based interface to create UI components that ensure visual consistency.
It follows a builder pattern approach to construct UI components directly in PHP.

## Installation
Use Composer to install the Codex library:

```bash
composer require wikimedia/codex
```

## Construction Methodology

Codex uses the **Fluent Builder Pattern**
to allow developers to create and configure UI components in a highly readable and intuitive manner.
This pattern follows a **create → build → render** sequence 
that allows methods to progressively customize components before rendering.

### How It Works

1. **Create**: Begin by calling a builder method to initialize a new component, for example, `$codex->Accordion()`.
2. **Configure**: Chain configuration methods to customize the component's attributes, such as `setTitle()`, `setDescription()`, or `setContent()`.
3. **Render**: Finally, call the `build()->getHtml()` method to get the rendered HTML for the component.

### Example

```php
$accordion = $codex
			->accordion()
			->setTitle( "Accordion Example" )
			->setDescription( "This is an example of an accordion." )
			->setContentHtml(
				$codex
					->htmlSnippet()
					->setContent( "<p>This is the content of the accordion.</p>" )
					->build()
			)
			->setOpen( false )
			->setAttributes( [
				"class" => "foo",
				"bar" => "baz",
			] )
			->build()
			->getHtml();

echo $accordion;
```

This pattern allows for a structured and clear way to build complex UI components with minimal effort,
making the codebase both efficient and readable.

## Available Components
The Codex library provides a variety of components to build UI:

- **Accordion**: A collapsible and expandable section for organizing content.
- **Button**: A clickable button that can be styled to reflect different actions.
- **Card**: A component for grouping information and actions related to a single topic.
- **Checkbox**: A form element that allows users to select one or more options.
- **Field**: A container for grouping form elements with optional legend and help a text.
- **InfoChip**: A small component used to display brief information or tags.
- **Label**: A component used to label other form elements.
- **Message**: A component to display information, warnings, or errors to users.
- **Pager**: A component for navigating through pages of data.
- **ProgressBar**: A visual indicator of progress toward a goal or task completion.
- **Radio**: A form element that allows users to select one option from a set.
- **Select**: A dropdown component that allows users to select an option from a list.
- **Table**: A component for arranging data in rows and columns.
- **Tabs**: A component that organizes content into multiple panels with selectable tabs.
- **TextArea**: A multi-line text input field for user input.
- **TextInput**: A single-line text input field for user input.
- **Thumbnail**: A visual component for displaying small preview images.
- **ToggleSwitch**: A ToggleSwitch enables the user to instantly toggle between on and off states.

## Usage
Here is a basic example of how to use the Codex library:

```php
<?php

require 'vendor/autoload.php';
use Wikimedia\Codex\Utility\Codex

$codex = new Codex();

$accordion = $codex
			->accordion()
			->setTitle( "Accordion Example" )
			->setDescription( "This is an example of an accordion." )
			->setContentHtml(
				$codex
					->htmlSnippet()
					->setContent( "<p>This is the content of the accordion.</p>" )
					->build()
			)
			->setOpen( false )
			->setAttributes( [
				"class" => "foo",
				"bar" => "baz",
			] )
			->build()
			->getHtml();

echo $accordion;
?>
```

## Usage in MediaWiki
Here is a basic example of how to use the Codex library in MediaWiki:

```php
<?php

use MediaWiki\SpecialPage\SpecialPage;
use Wikimedia\Codex\Adapter\WebRequestAdapter;
use Wikimedia\Codex\Utility\Codex;
use Wikimedia\Codex\Utility\WebRequestCallbacks;

class SomeSpecial extends SpecialPage {

	public function __construct() {
		parent::__construct( "SomeSpecial" );
	}

	public function execute( $subPage ) {
		$codex = new Codex();
		$requestAdapter = new WebRequestAdapter( $this->getRequest() );
		$callbacks = new WebRequestCallbacks( $requestAdapter );

		$tab1 = $codex
				->Tab()
				->setName( "tab1" )
				->setLabel( "Tab 1" )
				->setContentHtml(
					$codex
					->htmlSnippet()
					->setContent( "<p>Content 1.</p>" )
					->build()
				)
				->setSelected( true )
				->build();

		$tab2 = $codex
				->Tab()
				->setName( "tab2" )
				->setLabel( "Tab 2" )
				->setContentHtml(
					$codex
					->htmlSnippet()
					->setContent( "<p>Content 2.</p>" )
					->build()
				)
				->build();

		$tab3 = $codex
				->Tab()
				->setName( "tab3" )
				->setLabel( "Tab 3" )
				->setContentHtml(
					$codex
					->htmlSnippet()
					->setContent( "<p>Content 3.</p>" )
					->build()
				)
				->build();

		$tabs = $codex
				->Tabs()
				->setCallbacks( $callbacks )
				->setTab( [ $tab1, $tab2, $tab3 ] )
				->build()
				->getHtml();

		$this->getOutput()->addHTML( $tabs );
	}
}
```

## Example Usage of WebRequestAdapter and WebRequestCallbacks

This example demonstrates how to use the `WebRequestAdapter` and `WebRequestCallbacks` classes to adapt `$_GET` parameters for use with the Codex library.

### Create a SimpleWebRequest Class

The `SimpleWebRequest` class implements the `IWebRequest` interface from the Codex design system.
It simulates a basic request object that stores `$_GET` parameters,
providing a standardized way to retrieve these parameters in accordance with the Codex interface.
This class allows for consistent access to request data,
ensuring flexibility and adherence to the expected behavior of Codex components.

```php
use Wikimedia\Codex\Contract\IWebRequest;

class SimpleWebRequest implements IWebRequest {
protected array $data;

    public function __construct( array $data ) {
        $this->data = $data;
    }

    public function getVal( string $name, $default = null ) {
        return $this->data[$name] ?? $default;
    }
}
```

### Adapt the SimpleWebRequest for Codex

Use the `WebRequestAdapter` to adapt the `SimpleWebRequest` object, making it compatible with Codex components.

```php
use Wikimedia\Codex\Adapter\WebRequestAdapter;

// Initialize the request with $_GET parameters
$request = new SimpleWebRequest( $_GET );

// Adapt the SimpleWebRequest to work with Codex
$requestAdapter = new WebRequestAdapter( $request );
```

### Initialize WebRequestCallbacks

Finally, initialize the `WebRequestCallbacks` with the adapted request to handle request parameters consistently.

```php
use Wikimedia\Codex\Utility\WebRequestCallbacks;

// Initialize WebRequestCallbacks
$callbacks = new WebRequestCallbacks( $requestAdapter );
```

With this setup, `$callbacks` can be used within Codex components to manage `$_GET` parameters consistently across the application.

## Scripts

The following scripts are defined for testing and code fixing purposes:

- `test`: Run linting and code checks.
- `fix`: Automatically fix code style issues.
- `phan`: Run the Phan static analyzer.
- `phpcs`: Run the PHP Code Sniffer.
- `start-sandbox`: Start the sandbox environment for testing.

Example usage:

```bash
composer run-script test
composer run-script fix
composer run-script phan
composer run-script phpcs
composer run-script start-sandbox
```

## License
This project is licensed under the GPL-2.0-or-later. See the [LICENSE](LICENSE) file for details.

## Contributing
Please read the [CONTRIBUTING](CONTRIBUTING.md) file for details on our code of conduct, and the process for submitting pull requests to us.

## Bugs
Report bugs at [Phabricator](https://phabricator.wikimedia.org/tag/codex/).

## Homepage
For more information, visit the [homepage](https://doc.wikimedia.org/codex/).
