<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wa.me/+918108981924
 * @since      1.0.0
 *
 * @package    Book
 * @subpackage Book/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Book
 * @subpackage Book/public
 * @author     RIshabh Tiwari <rishabh.tiwari@hbwsl.com>
 */
class Book_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Book_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Book_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/book-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Book_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Book_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/book-public.js', array( 'jquery' ), $this->version, false );

	}
	
/**
 * Custom post type funtion for book post type
 * 
 * @return void
 */
public function Custom_Post_Book() 
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
public function register_custom_herachical_taxonomy() {
	$labels = array(
		'name'              => _x( ' Book Categories', 'taxonomy general name' ),
		'singular_name'     => _x( ' Book Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search  Book Categories' ),
		'all_items'         => __( 'All  Book Categories' ),
		'parent_item'       => __( 'Parent  Book Category' ),
		'parent_item_colon' => __( 'Parent  Book Category:' ),
		'edit_item'         => __( 'Edit  Book Category' ),
		'update_item'       => __( 'Update  Book Category' ),
		'add_new_item'      => __( 'Add New  Book Category' ),
		'new_item_name'     => __( 'New  Book Category Name' ),
		'menu_name'         => __( ' Book Category' ),
	);
	$args   = array(
		'hierarchical'      => true, // make it hierarchical (like categories)
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => [ 'slug' => 'course' ],
		'show_in_rest'		=> true,
	);
	register_taxonomy( 'book_category', [ 'books' ], $args );
}
public function register_custom_non_herachical_taxonomy() {
	$labels = array(
		'name'              => _x( ' Book Tag', 'taxonomy general name' ),
		'singular_name'     => _x( ' Book Tags', 'taxonomy singular name' ),
		'search_items'      => __( 'Search  Book Tags' ),
		'all_items'         => __( 'All  Book Tags' ),
		'parent_item'       => __( 'Parent  Book Tag' ),
		'parent_item_colon' => __( 'Parent  Book Tag:' ),
		'edit_item'         => __( 'Edit  Book Tag' ),
		'update_item'       => __( 'Update  Book Tag' ),
		'add_new_item'      => __( 'Add New  Book Tag' ),
		'new_item_name'     => __( 'New  Book Tag Name' ),
		'menu_name'         => __( ' Book Tag' ),
	);
	$args   = array(
		'hierarchical'      => true, // make it hierarchical (like categories)
		'labels'            => $labels,
		'show_in_rest'		=> true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => [ 'slug' => 'course' ],
	);
	register_taxonomy( 'book_tag', [ 'books' ], $args );
}
}
