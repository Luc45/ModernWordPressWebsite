<?php

namespace App\Service_Providers\Viewable_Providers;

use App\Assets\Assets_Enqueuer;
use App\Assets\Emoji_Disabler;
use App\Theme\Supports;
use MWW\DI\Context_Aware_Service_Provider;
use MWW\Shortcodes\Shortcodes_Registrar;

class Viewable_Service_Provider extends Context_Aware_Service_Provider {

	/**
	 * Service Providers in the context of requests triggered by index.php
	 *
	 * When it registers:
	 * Whenever someone visits the website
	 */
	public static function should_register(): bool {
		return wp_using_themes() && ! mww_is_rest_api_request();
	}

	public function register(): void {
		$this->enqueue_assets();
		$this->add_shortcodes();
		$this->add_theme_supports();
		$this->disable_emojis();
	}

	private function enqueue_assets() {
		add_action( 'wp_enqueue_scripts', [ $this->container->make( Assets_Enqueuer::class ), 'enqueue_assets' ] );
	}

	private function add_shortcodes() {
		$this->container->make( Shortcodes_Registrar::class )->add_shortcodes();
	}

	private function add_theme_supports() {
		$this->container->make( Supports::class )->add_theme_supports();
	}

	private function disable_emojis() {
		$this->container->make( Emoji_Disabler::class )->disable_emojis();
	}

}
