<?php

namespace App\Theme;

class Supports {

	public function add_theme_supports() {
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'title-tag' );
	}

}
