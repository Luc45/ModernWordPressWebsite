<?php

use App\Service_Providers\Viewable_Providers\REST_Service_Provider;
use MWW\DI\Container;
use MWW\Service_Providers\MWW_Service_Provider;
use App\Service_Providers\Admin_Providers\Admin_Service_Provider;
use App\Service_Providers\Ajax_Providers\Ajax_Service_Provider;
use App\Service_Providers\Application_Service_Provider;
use App\Service_Providers\CLI_Providers\CLI_Service_Provider;
use App\Service_Providers\Cron_Providers\Cron_Service_Provider;
use App\Service_Providers\Viewable_Providers\Viewable_Service_Provider;

/*
 * Register our context-based Service Providers.
 * We load different Services depending on what kind of Request this is.
 */
Container::register( MWW_Service_Provider::class );
Container::register( Application_Service_Provider::class );
Container::register_contextual_provider( Viewable_Service_Provider::class );
Container::register_contextual_provider( REST_Service_Provider::class );
Container::register_contextual_provider( Ajax_Service_Provider::class );
Container::register_contextual_provider( Admin_Service_Provider::class );
Container::register_contextual_provider( Cron_Service_Provider::class );
Container::register_contextual_provider( CLI_Service_Provider::class );

return Container::container();
