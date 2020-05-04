<?php

use App\Service_Providers\Assets_Service_Provider;
use MWW\DI\Container;
use MWW\Service_Providers\Framework_Service_Provider;
use App\Service_Providers\Example_Service_Provider;

/*
 * Register our context-based Service Providers.
 * We load different Services depending on what kind of Request this is.
 */
Container::register( Framework_Service_Provider::class );
Container::register( Example_Service_Provider::class );
Container::register( Assets_Service_Provider::class );

return Container::container();
