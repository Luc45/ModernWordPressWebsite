<?php

namespace MWW\Shortcodes;

/**
 * Class Shortcode
 * @package MWW\Shortcodes;
 */
abstract class Shortcode {
	/**
	 * Add the shortcode to WordPress
	 */
	public function add() {
		add_shortcode( $this->shortcode, [ $this, 'register_shortcode' ] );
	}

	/**
	 * What the shortcode will output when called.
	 *
	 * @return string
	 */
	public abstract function execute( $atts, $content = null ): string;
}
