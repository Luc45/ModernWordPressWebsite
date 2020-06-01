<?php

namespace App\Shortcodes;

use MWW\Shortcodes\Shortcode;

/**
 * Class HelloWorldShortcode
 * @package App\Shortcodes
 */
class HelloWorldShortcode extends Shortcode {

	/** Shortcode handler */
	public $shortcode = 'hello_world';

	/**
	 * Call this shortcode using [hello_world]
	 *
	 * @param $atts
	 * @param null $content
	 *
	 * @return string
	 */
	public function execute( $atts, $content = null ): string {
		return 'Hello World!';
	}
}
