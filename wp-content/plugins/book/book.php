<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @package Book
 * @link    https://wa.me/+918108981924
 * @since   1.0.0
 * 
 * @wordpress-plugin
 * Plugin Name:       BookPlugin
 * Plugin URI:        https://www.wordpress.org/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            RIshabh Tiwari
 * Author URI:        https://wa.me/+918108981924
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       book
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC') ) {
    die;
}
//Exit if accessed directly
if (!defined('ABSPATH') ) {
    exit; 
}
/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('BOOK_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-book-activator.php
 * 
 * @return void
 */
function Activate_book() {
    include_once plugin_dir_path(__FILE__) . 'includes/class-book-activator.php';
    Book_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-book-deactivator.php
 * 
 * @return void
 */
function Deactivate_book() {
    include_once plugin_dir_path(__FILE__) . 'includes/class-book-deactivator.php';
    Book_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'Activate_book');
register_deactivation_hook(__FILE__, 'Deactivate_book');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-book.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since 1.0.0
 * 
 * @return void
 */
function Run_book() {
    $plugin = new Book();
    $plugin->run();

}
Run_book();
