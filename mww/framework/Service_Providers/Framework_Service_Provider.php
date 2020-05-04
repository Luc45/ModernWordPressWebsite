<?php

namespace MWW\Service_Providers;

use MWW\Routing\RouteConditional;
use MWW\Routing\Router;

class Framework_Service_Provider extends Service_Provider {

	/**
	 * @inheritDoc
	 */
	public function register(): void {
		$this->container->singleton( Router::class, Router::class );
		$this->container->singleton( RouteConditional::class, RouteConditional::class );
	}

}
