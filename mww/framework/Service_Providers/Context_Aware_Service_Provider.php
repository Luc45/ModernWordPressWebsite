<?php

namespace MWW\Service_Providers;

abstract class Context_Aware_Service_Provider extends Service_Provider {
	/**
	 * Defines if the Services from this Provider should register or not
	 * at runtime. This is useful to override the application behavior at
	 * runtime. Defaults to true.
	 *
	 * @return bool
	 */
	abstract public static function should_register(): bool;
}
