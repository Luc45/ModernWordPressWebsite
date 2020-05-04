<?php

namespace MWW\Service_Providers;

abstract class Service_Provider extends \tad_DI52_ServiceProvider {
	/**
	 * @inheritDoc
	 */
	abstract public function register(): void;
}
