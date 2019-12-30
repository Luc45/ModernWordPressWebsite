<?php

namespace App\Service_Providers\Admin_Providers;

use MWW\DI\Context_Aware_Service_Provider;

class Admin_Service_Provider extends Context_Aware_Service_Provider {

	/**
	 * Service Providers exclusive to the requests being made viewing the WordPress Admin Dashboard
	 *
	 * When it registers:
	 * On all requests made at wp-admin/*, except AJAX ones
	 */
	public static function should_register(): bool {
		return is_admin() && ! wp_doing_ajax();
	}

	public function register(): void {

	}

}
