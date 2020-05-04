<?php

namespace MWW\Service_Providers;

abstract class Viewable_Service_Provider extends Context_Aware_Service_Provider {

	/**
	 * Service Providers in the context of requests triggered by index.php
	 *
	 * When it registers:
	 * Whenever someone visits the website
	 */
	public static function should_register(): bool {
		return wp_using_themes() && ! mww_is_rest_api_request();
	}

}
