<?php

class REST_Context_Cest implements Context_Tests_Interface {
	public function test_is_rest_request( FunctionalTester $I ) {
		$code = <<<PHP
/** Plugin Name: Test */
add_action( 'rest_api_init', function () {
	 echo (int) \MWW\Service_Providers\REST_Service_Provider::should_register();
	exit;
} );
PHP;

		$I->haveMuPlugin( "test.php", $code );

		$I->sendGET( "v1/" );
		$I->seeResponseEquals( '1' );
	}

	public function test_is_viewable_request( FunctionalTester $I ) {
		$code = <<<PHP
/** Plugin Name: Test */
add_action( 'wp', function () {
	 echo sprintf('<div id="test-rest-response">%d</div>', (int) \MWW\Service_Providers\REST_Service_Provider::should_register());
	exit;
} );
PHP;

		$I->haveMuPlugin( "test.php", $code );

		$I->amOnPage( "/" );
		$I->see( "0", "#test-rest-response" );
	}

	public function test_is_admin_request( FunctionalTester $I ) {
		$I->loginAsAdmin();

		$code = <<<PHP
/** Plugin Name: Test */
add_action( 'admin_init', function () {
	 echo sprintf('<div id="test-rest-response">%d</div>', (int) \MWW\Service_Providers\REST_Service_Provider::should_register());
	exit;
} );
PHP;

		$I->haveMuPlugin( "test.php", $code );

		$I->amOnPluginsPage();

		$I->see( "0", "#test-rest-response" );
	}

	public function test_is_ajax_request( FunctionalTester $I ) {
		$code = <<<PHP
/** Plugin Name: Test */
 add_action("wp_ajax_nopriv_test_rest_action", function() {
    echo sprintf('<div id="test-rest-response">%d</div>', (int) \MWW\Service_Providers\REST_Service_Provider::should_register());
    exit;
 });
PHP;

		$I->haveMuPlugin( "test.php", $code );

		$I->amOnAdminAjaxPage(['action'=> 'test_rest_action']);

		$I->seeResponseEquals( '<div id="test-rest-response">0</div>' );
	}
}
