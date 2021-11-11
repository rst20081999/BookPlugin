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
/**
 * Custom post type funtion for book post type
 * 
 * @return void
 */
function Custom_Post_type() 
{
 
    // Set UI labels for Custom Post Type
        $labels = array(
            'name'                => _x('Book', 'Post Type General Name', 'Bookdomain'),
            'singular_name'       => _x('Books', 'Post Type Singular Name', 'Bookdomain'),
            'menu_name'           => __('Books', 'Bookdomain'),
            'parent_item_colon'   => __('Parent Book', 'Bookdomain'),
            'all_items'           => __('All Books', 'Bookdomain'),
            'view_item'           => __('View Book', 'Bookdomain'),
            'add_new_item'        => __('Add New Book', 'Bookdomain'),
            'add_new'             => __('Add New', 'Bookdomain'),
            'edit_item'           => __('Edit Book', 'Bookdomain'),
            'update_item'         => __('Update Book', 'Bookdomain'),
            'search_items'        => __('Search Book', 'Bookdomain'),
            'not_found'           => __('Not Found', 'Bookdomain'),
            'not_found_in_trash'  => __('Not found in Trash', 'Bookdomain'),
        );
         
        // Set other options for Custom Post Type
         
        $args = array(
            'label'               => __('Books', 'Bookdomain'),
            'description'         => __('Book news and reviews', 'Bookdomain'),
            'labels'              => $labels,
            // Features this CPT supports in Post Editor
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields',),
            // You can associate this CPT with a taxonomy or custom taxonomy. 
            'taxonomies'          => array( 'genres' ),
            /* A hierarchical CPT is like Pages and can have
            * Parent and child items. A non-hierarchical CPT
            * is like Posts.
            */ 
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
            'show_in_rest' => true,
     
        );
         
        // Registering your Custom Post Type
        register_post_type('Books', $args);
}
     
    /* Hook into the 'init' action so that the function
    * Containing our post type registration is not 
    * unnecessarily executed. 
    */
     
    add_action('init', 'Custom_Post_type', 0);
