<?php

namespace Wikimedia\Codex\Contract;

abstract class Renderer {

	/**
	 * Renders the HTML markup for a Component.
	 *
	 * This method is responsible for generating the complete HTML markup for the provided
	 * component object. The implementation should ensure that the generated markup is
	 * consistent with the Codex design system's guidelines.
	 *
	 * @since 0.1.0
	 * @param Component $component The Component object to render.
	 * @return string The generated HTML markup for the component.
	 */
	abstract public function render( Component $component ): string;

	/**
	 * Resolves an associative array of HTML attributes into a string for an HTML tag.
	 * Boolean attributes (like `disabled`) are rendered without a value.
	 * Array-based attributes (like `class`) are concatenated into a single string.
	 *
	 * @since 0.1.0
	 * @param array $attributes Key-value pairs of HTML attributes.
	 * @return string The attributes as a string, ready to be included in an HTML tag.
	 */
	public function resolveAttributes( array $attributes ): string {
		// Return an empty string if there are no attributes
		if ( !$attributes ) {
			return '';
		}

		$resolvedAttributes = [];

		foreach ( $attributes as $key => $value ) {

			// If the value is true, include the key as an attribute without a value.
			if ( $value === true ) {
				$resolvedAttributes[] = $key;
			} elseif ( is_array( $value ) ) {
				// If the value is an array (e.g., 'data' => ['toggle' => 'modal']), flatten it into a string
				$attributeValue = implode( ' ', $value );
				$resolvedAttributes[] = "$key=\"$attributeValue\"";
			} elseif ( $value !== false && $value !== null ) {
				// Handle other scalar values
				$attributeValue = (string)$value;
				$resolvedAttributes[] = "$key=\"$attributeValue\"";
			}
		}

		return implode( ' ', $resolvedAttributes );
	}
}
