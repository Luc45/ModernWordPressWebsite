<?php

class CLI_Context_Cest {
	public function should_not_be_rest_request_if_cli_request( CliTester $I ) {
		$code = <<<PHP
/** Plugin Name: Test */
add_action("muplugins_loaded", function() {
	\$is_rest_request = \MWW\Service_Providers\REST_Service_Provider::should_register();
	echo \$is_rest_request ? "REST_REQUEST" : "NOT_REST_REQUEST";
	exit;
});
PHP;
		$I->haveMuPlugin( 'test.php', $code );

		$I->cli( [ 'plugin', 'list' ] );
		$I->canSeeInShellOutput( 'NOT_REST_REQUEST' );
	}
}
