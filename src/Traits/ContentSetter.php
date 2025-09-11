<?php
/**
 * ContentSetter.php
 *
 * @category Traits
 * @package  Codex\Traits
 * @since    0.7.2
 * @author   Roan Kattouw <roan.kattouw@gmail.com>
 * @license  https://www.gnu.org/copyleft/gpl.html GPL-2.0-or-later
 * @link     https://doc.wikimedia.org/codex/latest/ Codex Documentation
 */

namespace Wikimedia\Codex\Traits;

use Wikimedia\Codex\Component\HtmlSnippet;

/**
 * ContentSetter is a utility trait that adds the setContent() method. For backwards compatibilty,
 * it also adds setContentText() and setContentHtml(). This trait is intended to be used in builder
 * classes.
 */
trait ContentSetter {
	protected string $contentHtml = '';

	/**
	 * Set the content of the component. A string is interpreted as plain text, and will be
	 * HTML-escaped. To pass in raw HTML, wrap it in an HtmlSnippet.
	 *
	 * @param string|HtmlSnippet $content
	 */
	public function setContent( $content ): self {
		$this->contentHtml = $content instanceof HtmlSnippet ?
			$content->getContent() :
			htmlspecialchars( $content, ENT_QUOTES, 'UTF-8' );
		return $this;
	}

	/**
	 * @deprecated since 0.7.2, use setContent instead
	 */
	public function setContentText( string $content ): self {
		return $this->setContent( $content );
	}

	/**
	 * @deprecated since 0.7.2, use setContent instead
	 */
	public function setContentHtml( HtmlSnippet $content ): self {
		return $this->setContent( $content );
	}
}
