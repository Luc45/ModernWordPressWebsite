<?php

namespace MWW\Service_Providers;

abstract class REST_Service_Provider extends Context_Aware_Service_Provider {

	/**
	 * Service Providers in the context of REST API Requests
	 *
	 * When it registers:
	 * On WP REST requests
	 */
	public static function should_register(): bool {
		return wp_using_themes() && mww_is_rest_api_request();
	}

}
