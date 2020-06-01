<?php

/**
 * Interface Context_Tests_Interface
 *
 * The methods a Context test class has to implement to make sure all
 * contexts only fire when needed.
 */
interface Context_Tests_Interface {
	public function test_is_rest_request( FunctionalTester $I );

	public function test_is_admin_request( FunctionalTester $I );

	public function test_is_ajax_request( FunctionalTester $I );

	public function test_is_viewable_request( FunctionalTester $I );

	/*
	 * Disabled because of the addition of fastcgi_finish_request()
	 * on wp-cron.php on WordPress 5.1, which makes this hard to test.
	 *
	 * See: https://github.com/lucatume/wp-browser/issues/380
	 *
	 * public function test_is_cron_request( FunctionalTester $I );
	 */

	/*
	 * CLI context is covered in the CLI suite.
	 *
	 * public function test_is_cli_request( FunctionalTester $I );
	*/
}
