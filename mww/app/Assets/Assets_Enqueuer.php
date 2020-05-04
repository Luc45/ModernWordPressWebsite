<?php

namespace App\Assets;

use MWW\Assets\Enqueuer;

class Assets_Enqueuer extends Enqueuer {

	/**
	 * @action wp_enqueue_scripts 10 0
	 * @see \MWW\Service_Providers\Viewable_Service_Provider::register
	 */
	public function enqueue_assets() {
		$this->enqueue_style( 'style.css' );
		$this->enqueue_javascript( 'main.js' );
	}

}
