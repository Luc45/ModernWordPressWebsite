<?php
/*
 * Plugin Name: Modern WordPress Website
 * Plugin URI: https://github.com/Luc45/Modern-WordPress-Website
 * Description: This project is using Modern WordPress Website (MWW).
 * Version: 0.2.0
 * Author: Lucas Bustamante
 * Author URI: https://www.lucasbustamante.com.br
 * License: GPL2
 */

/*
 * Let's begin by defining important constants for our application.
 */
define( 'MWW_FOLDER', '/mww/' );
define( 'MWW_URL', plugin_dir_url( __FILE__ ) . MWW_FOLDER );
define( 'MWW_PATH', __DIR__ . MWW_FOLDER );

/*
 * MWW follows the PSR-4 autoloader specification.
 * Thus we require the autoloader provided by Composer.
 *
 * More information:
 * https://www.php-fig.org/psr/psr-4/
 * https://getcomposer.org/doc/04-schema.md#psr-4
 */
if ( file_exists( MWW_PATH . 'vendor/autoload.php' ) ) {
	require_once( MWW_PATH . 'vendor/autoload.php' );
} else {
	wp_die( sprintf(
			'<h1>MWW requires one more step to work!</h1><p>Run "<code>composer update</code>" in the MWW folder: <strong>"%s"</strong></p>',
			MWW_PATH )
	);
}

/* Loads some Framework and App Helper functions */
require_once MWW_PATH . 'framework/helpers.php';
include_once MWW_PATH . 'app/helpers.php';

/**
 * Booststraps the application
 *
 * @var $container tad_DI52_Container
 */
$container = require_once MWW_PATH . 'bootstrap.php';

/* Understands the request and handles it according to our Routes */
$container->make( MWW\Routing\Router::class )->routeRequest();
