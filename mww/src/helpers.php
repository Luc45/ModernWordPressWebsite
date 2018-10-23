<?php

/**
 * Debug Function
 *
 * @example dd($var1, $var2);
 */
if (!function_exists('dd')) {
    function dd(...$debug)
    {
        echo var_dump($debug);
        exit;
    }
}

/**
 * Returns true if current page is WordPress login
 * @see https://wordpress.stackexchange.com/a/237285/27278
 */
if (!function_exists('is_wp_login')) {
    function is_wp_login()
    {
        $ABSPATH_MY = str_replace(array('\\','/'), DIRECTORY_SEPARATOR, ABSPATH);
        return ((in_array($ABSPATH_MY.'wp-login.php', get_included_files()) || in_array($ABSPATH_MY.'wp-register.php', get_included_files()) ) || (isset($_GLOBALS['pagenow']) && $GLOBALS['pagenow'] === 'wp-login.php') || $_SERVER['PHP_SELF']== '/wp-login.php');
    }
}

/**
 * Returns URL for MWW folder
 */
function get_mww_url()
{
    return MWW_URL;
}

/**
 * Returns PATH for MWW folder
 */
function get_mww_path()
{
    return MWW_PATH;
}

/**
 *  Wrapper for method include in Template class
 *
 *  @param string $file Name of the view to load
 *  @param array $data Data to be passed to the view
 */
function include_view($file, $data = [])
{
    $template = new MWW\Frontend\Template;
    $template->include($file, $data);
}
