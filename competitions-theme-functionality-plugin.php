<?php
/*
Plugin Name: Competitions Theme Functionality by RMcC
Plugin URI: #
Description: CPTs, Views, ACF fields & all else...
Version: 1.0.0
Author: robmccormack89
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
if (!defined('COMPETITIONS_THEME_FUNCTIONALITY_URL')) define('COMPETITIONS_THEME_FUNCTIONALITY_URL', plugin_dir_url( __FILE__ ));
if (!defined('COMPETITIONS_THEME_FUNCTIONALITY_BASE')) define('COMPETITIONS_THEME_FUNCTIONALITY_BASE', dirname(plugin_basename( __FILE__ )));

// require action functions 
// require_once('inc/functions.php');

// require the composer autoloader
if (file_exists($composer_autoload = __DIR__.'/vendor/autoload.php')) require_once $composer_autoload;

// then require the main plugin class. this class extends Timber/Timber which is required via composer
new Rmcc\CompetitionsThemeFunctionality;

// execute after the theme setup. for a plugin class that piggybacks off the theme
// no need to require timber via composer once the theme requires the timber plugin
// no need to use composer autoloader either
// add_action( 'after_setup_theme', function() {
//   // check if CautiousOctoFiesta exists before we try to extend it
//   if(class_exists('CautiousOctoFiesta')) {
//     // require the extending class
//     require(COMPETITIONS_THEME_FUNCTIONALITY_PATH.'inc/CompetitionsThemeFunctionality.php');
//   };
// });