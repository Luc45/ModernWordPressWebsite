<?php

namespace App\Assets;

class Emoji_Disabler {

	/**
	 * Here we take a highly biased approach to remove Emojis from WordPress. We consider them to be expensive
	 * and not being used on the majority of the websites. Enable if necessary.
	 */
	public function disable_emojis() {
		if ( (bool) apply_filters( 'mww_disable_emojis', true ) ) {
			// all actions related to emojis
			remove_action( 'admin_print_styles', 'print_emoji_styles' );
			remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
			remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
			remove_action( 'wp_print_styles', 'print_emoji_styles' );
			remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
			remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
			remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

			// Remove DNS prefetch
			add_filter( 'emoji_svg_url', '__return_false' );
		}
	}

}
