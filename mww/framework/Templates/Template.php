<?php

namespace MWW\Templates;

class Template {
	/**
	 * Includes a template file
	 *
	 * @param string $file Name of the view to load
	 * @param array $data_noconflict Data to be passed to the view
	 * @param string $hook_to_fire Fires this hook upon loading this template
	 */
	public function include( string $file, array $data_noconflict = [], string $hook_to_fire = '' ) {
		// Globals from load_template function from wp-includes/template.php
		global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

		// Warn for conflicting vars
		$this->warnForGlobalVarConflicts( $data_noconflict, $file );

		// Extract data without overriding WordPress globals
		extract( $data_noconflict, EXTR_PREFIX_SAME, 'mww' );

		// Allows for subdirectory includes, such as "partials.header"
		$file = str_replace( '.', '/', $file );

		$file_path = MWW_PATH . '/views/' . $file . '.blade.php';

		if ( file_exists( $file_path ) ) {
			if ( ! empty( $hook ) ) {
				do_action( $hook );
			}

			// Create \Illuminate\View\Factory
			$view = ViewFactory::create();

			// Pass all previously defined to view
			$view->share( get_defined_vars() );

			// Construct and render view
			echo $view->make( $file )->render();
		} else {
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				echo sprintf(
					"Error loading view: %s<br>",
					$file
				);
				if ( endswith( $file, '/php' ) ) {
					echo sprintf(
						"Maybe you meant to add <strong>%s</strong> instead?<br>",
						rtrim( $file, '/php' )
					);
				}
			}
		}
	}

	/**
	 * Warns for conflicts with $data and WordPress globals
	 *
	 * @param array $data data being passed to the view
	 * @param string $file file to which this data is being passed
	 */
	private function warnForGlobalVarConflicts( array $data, string $file ) {
		$globals_in_use = [
			'posts',
			'post',
			'wp_did_header',
			'wp_query',
			'wp_rewrite',
			'wpdb',
			'wp_version',
			'wp',
			'id',
			'comment',
			'user_ID',
		];
		foreach ( $data as $var => $value ) {
			if ( in_array( $var, $globals_in_use ) ) {
				if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
					echo sprintf(
						"%s conflicts with WordPress global %s and thus have been renamed to mww_%s in this view
						to avoid inconsistencies with the WordPress global environment. (being passed to view %s)",
						$var,
						$var,
						$var,
						$file
					);
				}
			}
		}
	}
}
