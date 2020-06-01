<?php

namespace MWW\Service_Providers;

abstract class Cron_Service_Provider extends Context_Aware_Service_Provider {

	/**
	 * Service Providers in the context of WP Cron
	 *
	 * When it registers:
	 * During requests originated from wp-cron.php
	 */
	public static function should_register(): bool {
		return wp_doing_cron();
	}

}
