<?php
/*
Plugin Name: Competitions Theme Functionality
Plugin URI: #
Description: CPTs, Views, ACF fields & all else...
Version: 1.0.0
Author: Robmccormack89
Author URI: #
Version: 1.0.0
License: GNU General Public License v2 or later
License URI: LICENSE
Text Domain: competitions-theme-functionality
Domain Path: /languages/
*/

// don't run if someone access this file directly
defined('ABSPATH') || exit;

// define some constants
if (!defined('COMPETITIONS_THEME_FUNCTIONALITY_PATH')) define('COMPETITIONS_THEME_FUNCTIONALITY_PATH', plugin_dir_path( __FILE__ ));
if (!defined('COMPETITIONS_THEME_FUNCTIONALITY_VIEWS')) define('COMPETITIONS_THEME_FUNCTIONALITY_VIEWS', plugin_dir_path( __FILE__ ).'views');

// require the composer autoloader
if (file_exists($composer_autoload = __DIR__.'/vendor/autoload.php')) require_once $composer_autoload;

// then require the main plugin class. this class extends Timber/Timber which is required via composer
new Rmcc\CompetitionsThemeFunctionality;