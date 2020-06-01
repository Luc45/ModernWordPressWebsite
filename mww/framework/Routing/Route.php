<?php

namespace MWW\Routing;

use MWW\DI\Container;

/**
 * Class Route
 * @package MWW\Routing
 *
 * @method static string rawGet( string $route, callable $callback )
 * @method static string rawPost( string $route, callable $callback )
 * @method static string rawPut( string $route, callable $callback )
 * @method static string rawPatch( string $route, callable $callback )
 * @method static string rawDelete( string $route, callable $callback )
 */
class Route {

	/**
	 * Matches a conditional handler
	 *
	 * @param $condition
	 * @param $handler
	 *
	 * @example 'is_page', function() { echo 'All Pages' }
	 * @example ['is_page', 'javali']
	 *
	 */
	public static function add( $condition, $handler ) {
		Container::make( RouteConditional::class )->add( $condition, $handler );
	}

	/**
	 * Matches any HTTP Verb
	 *
	 * @param string $route
	 * @param callable $callback
	 */
	public static function any( string $route, callable $callback ) {
		klein_respond( $route, $callback );
	}

	/**
	 * Matches an array of HTTP Verbs
	 *
	 * @param array $verbs
	 * @param string $route
	 * @param callable $callback
	 */
	public static function match( array $verbs, string $route, callable $callback ) {
		array_walk( $verbs, function ( $verb ) {
			if ( ! is_string( $verb ) ) {
				throw new \UnexpectedValueException( 'All route verbs must be strings' );
			}
		} );

		klein_respond( $verbs, $route, $callback );
	}

	/**
	 * NotFound will behave the same
	 *
	 * For URLs that WordPress CANNOT map to a post on the database
	 * For URLs that WordPress CAN map to a post on the database, but has no Route to handle it
	 *
	 * @param $handler
	 */
	public static function notFound( $handler ) {
		Route::add( 'is_404', $handler );
		Route::rawGet( '*', $handler );
	}

	/**
	 * Matches any specific HTTP Verb
	 *
	 * @param $method
	 * @param $arguments
	 */
	public static function __callStatic( $raw_method, $arguments ) {
		if ( is_string( $raw_method ) && count( $arguments ) === 2 ) {
			$route    = $arguments[0];
			$callback = $arguments[1];
		}

		/** Sets the default action if given the string of a Class */
		if ( is_string( $callback ) && class_exists( $callback ) ) {
			$callback = [ $callback, 'index' ];
		}

		if ( is_string( $route ) && is_callable( $callback ) ) {
			$method = strtoupper( ltrim( $raw_method, 'raw' ) );

			klein_respond( $method, $route, $callback );
		}
	}
}
