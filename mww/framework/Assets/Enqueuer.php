<?php

namespace MWW\Assets;

class Enqueuer {
	/**
	 *   Enqueues a Single CSS
	 *   https://developer.wordpress.org/reference/functions/wp_enqueue_style/
	 *
	 * @param string $file Name of the file
	 * @param array $dependency Will load after selected handlers
	 * @param string $path Path to load from, starting from MWW_PATH
	 */
	public function enqueue_style(
		string $file,
		array $dependency = [],
		string $path = '/public/css/'
	) {
		wp_enqueue_style(
			$file,
			MWW_URL . $path . $file,
			$dependency,
			filemtime( MWW_PATH . $path . $file )
		);
	}

	/**
	 *   Enqueues a Single Remote CSS
	 *   https://developer.wordpress.org/reference/functions/wp_enqueue_style/
	 *
	 * @param string $name Name of the handler, example: bootstrap
	 * @param string $url URL of the remote resource
	 * @param array $dependency Will load after selected handlers
	 */
	public function enqueue_remote_style(
		string $name,
		string $url,
		array $dependency = []
	) {
		wp_enqueue_style(
			$name,
			$url,
			$dependency
		);
	}

	/**
	 *   Enqueues a Single Javascript
	 *   https://developer.wordpress.org/reference/functions/wp_enqueue_script/
	 *
	 * @param string $file Name of the file
	 * @param array $dependency Will load after selected handlers
	 * @param string $path Path to load from, starting from MWW_PATH
	 * @param boolean $in_footer Wether to load the script in the footer or not
	 */
	public function enqueue_javascript(
		string $file,
		array $dependency = [ 'jquery' ],
		string $path = '/public/js/',
		bool $in_footer = true
	) {
		wp_enqueue_script(
			$file,
			MWW_URL . $path . $file,
			$dependency,
			filemtime( MWW_PATH . $path . $file ),
			$in_footer
		);
	}

	/**
	 *   Enqueues a Remote Javascript
	 *
	 * @param string $file Name of the handler, example: bootstrap-js
	 * @param string $url URL of the remote resource
	 * @param array $dependency Will load after selected handlers
	 * @param boolean $in_footer Wether to load the script in the footer or not
	 */
	public function enqueue_remote_javascript(
		string $name,
		string $url,
		array $dependency = [ 'jquery' ],
		bool $in_footer = true
	) {
		wp_enqueue_script(
			$name,
			$url,
			$dependency,
			null,
			$in_footer
		);
	}
}
