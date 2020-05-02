<?php


class REST_Context_Cest {
	public function should_be_a_rest_context_if_rest_request( FunctionalTester $I ) {
		$code = <<<PHP
/**
 * Plugin Name: Test REST Context
 */
add_action( 'rest_api_init', function () {
	 echo (int) App\Service_Providers\Viewable_Providers\REST_Service_Provider::should_register();
	exit;
} );
PHP;

		$I->haveMuPlugin( "test-rest-context.php", $code );

		$I->sendGET( "v1/" );
		$I->seeResponseEquals( '1' );
	}

	public function should_not_be_a_rest_context_if_is_viewable_request( FunctionalTester $I ) {
		$code = <<<PHP
/**
 * Plugin Name: Test REST Context
 */
add_action( 'wp', function () {
	 echo sprintf('<div id="test-rest-response">%d</div>', (int) App\Service_Providers\Viewable_Providers\REST_Service_Provider::should_register());
	exit;
} );
PHP;

		$I->haveMuPlugin( "test-rest-context.php", $code );

		$I->amOnPage( "/" );
		$I->see( "0", "#test-rest-response" );
	}

	public function should_not_be_a_rest_context_if_is_cron_request( FunctionalTester $I ) {
		$code = <<<PHP
/**
 * Plugin Name: Test REST Context
 */
add_action( 'wp', function () {
	 echo sprintf('<div id="test-rest-response">%d</div>', (int) App\Service_Providers\Viewable_Providers\REST_Service_Provider::should_register());
	exit;
} );
PHP;

		$I->haveMuPlugin( "test-rest-context.php", $code );

		$I->amOnCronPage( [ 'doing_cron' => true ] );
		$I->see( "0", "#test-rest-response" );
	}

	public function should_not_be_a_rest_context_if_is_admin_request( FunctionalTester $I ) {
		$I->loginAsAdmin();

		$code = <<<PHP
/**
 * Plugin Name: Test REST Context
 */
add_action( 'admin_init', function () {
	 echo sprintf('<div id="test-rest-response">%d</div>', (int) App\Service_Providers\Viewable_Providers\REST_Service_Provider::should_register());
	exit;
} );
PHP;

		$I->haveMuPlugin( "test-rest-context.php", $code );

		$I->amOnPluginsPage();

		$I->see( "0", "#test-rest-response" );
	}

	public function should_not_be_a_rest_context_if_is_ajax_request( FunctionalTester $I ) {
		$code = <<<PHP
/**
 * Plugin Name: Test REST Context
 */
 add_action("wp_ajax_nopriv_test_rest_action", function() {
    echo sprintf('<div id="test-rest-response">%d</div>', (int) App\Service_Providers\Viewable_Providers\REST_Service_Provider::should_register());
    exit;
 });
PHP;

		$I->haveMuPlugin( "test-rest-context.php", $code );

		$I->amOnAdminAjaxPage(['action'=> 'test_rest_action']);

		$I->seeResponseEquals( '<div id="test-rest-response">0</div>' );
	}

	public function should_not_be_a_rest_context_if_is_cli_request( FunctionalTester $I ) {

		$I->haveMuPlugin( "test-rest-context.php", $code );

		$I->amOnAdminAjaxPage(['action'=> 'test_rest_action']);

		$I->seeResponseEquals( '<div id="test-rest-response">0</div>' );
	}
}
