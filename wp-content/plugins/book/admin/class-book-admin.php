<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @category Class_Admin_Book
 * @package  Class_Admin_Book
 * @author   RIshabh Tiwari <rishabh.tiwari@hbwsl.com>
 * @license  opentoall https:
 * @see      https://wa.me/+918108981924
 * @link     me https:
 * @_version 5.4
 * @since    1.0.0
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, _version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @author RIshabh Tiwari <rishabh.tiwari@hbwsl.com>
 */
class Book_Admin
{
    /**
     * The ID of this plugin.
     *
     * @since 1.0.0
     *
     * @var string the ID of this plugin
     */
    private $_plugin_name;

    /**
     * The _version of this plugin.
     *
     * @since 1.0.0
     *
     * @var string the current _version of this plugin
     */
    private $_version;

    /**
     * Initialize the class and set its properties.
     *
     * @since 1.0.0
     *
     * @param string $_plugin_name the name of this plugin
     * @param string $_version     the _version of this plugin
     */
    public function __construct($_plugin_name, $_version)
    {
        $this->_plugin_name = $_plugin_name;
        $this->_version = $_version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since 1.0.0
     */
    public function enqueue_styles()
    {
        /*
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

        wp_enqueue_style($this->_plugin_name, plugin_dir_url(__FILE__).'css/book-admin.css', [], $this->_version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since 1.0.0
     */
    public function enqueue_scripts()
    {
        /*
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

        wp_enqueue_script($this->_plugin_name, plugin_dir_url(__FILE__).'js/book-admin.js', ['jquery'], $this->_version, false);
    }

    /**
     * This comment is just for no purposes just to get rid
     * from that error and nothing else
     * please use your mind and understand the login below it;s not complicated
     * 
     * @return void
     */
    public function customPostBook()
    {
        
        // Set UI labels for Custom Post Type
        $labels = [
            'name' => _x('Book', 'Post Type General Name', 'Bookdomain'),
            'singular_name' => _x('Books', 'Post Type Singular Name', 'Bookdomain'),
            'menu_name' => __('Books', 'Bookdomain'),
            'parent_item_colon' => __('Parent Book', 'Bookdomain'),
            'all_items' => __('All Books', 'Bookdomain'),
            'view_item' => __('View Book', 'Bookdomain'),
            'add_new_item' => __('Add New Book', 'Bookdomain'),
            'add_new' => __('Add New', 'Bookdomain'),
            'edit_item' => __('Edit Book', 'Bookdomain'),
            'update_item' => __('Update Book', 'Bookdomain'),
            'search_items' => __('Search Book', 'Bookdomain'),
            'not_found' => __('Not Found', 'Bookdomain'),
            'not_found_in_trash' => __('Not found in Trash', 'Bookdomain'),
        ];

        // Set other options for Custom Post Type

        $args = [
            'label' => __('Books', 'Bookdomain'),
            'description' => __('Book news and reviews', 'Bookdomain'),
            'labels' => $labels,
            // Features this CPT supports in Post Editor
            'supports' => ['title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields'],
            // You can associate this CPT with a taxonomy or custom taxonomy.
            'taxonomies' => ['genres'],
            /* A hierarchical CPT is like Pages and can have
            * Parent and child items. A non-hierarchical CPT
            * is like Posts.
            */
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'show_in_admin_bar' => true,
            'menu_position' => 5,
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'capability_type' => 'post',
            'show_in_rest' => true,
        ];

        // Registering your Custom Post Type
        register_post_type('Books', $args);
    }

    /**
     * This comment is just for no purposes just to get rid
     * from that error and nothing else
     * please use your mind and understand the login below it;s not complicated
     * 
     * @return void
     */
    public function books_shortcode($atts = [], $content = null, $tag = '')
    {
        global $wpdb;
        $query = 'SELECT * FROM `wp_metabox`';
        $data = $wpdb->get_results($query);
        $newdata = [];
        if ($atts) {
            foreach ($atts as $key => $a) {
                // echo '<script>console.log("'.$key.'")</script>';
                foreach ($data as $d) {
                    if ($d->$key == $a) {
                        array_push($newdata, $d);
                    }
                }

                // foreach($data as $d){

                // }
            }
            $data = $newdata;
        } else {
            // echo '<script>console.log("no data")</script>';
        }
        $c = '<div><p>i am here</p>';
        foreach ($data as $row) {
            $c .= '
        <div style="border: 1px solid red;">
        <p>sds</p>
        <p>'.$row->post_id.'</p>
        <p>'.$row->author.'</p>
        <p>'.$row->price.'</p>
        <p>'.$row->publisher.'</p>
        <p>'.$row->year.'</p>
        <p>'.$row->edition.'</p>
        </div><br/>';
        }
        $c .= '</div>';

        return $c;
    }

    /**
     * This comment is just for no purposes just to get rid
     * from that error and nothing else
     * please use your mind and understand the login below it;s not complicated
     * 
     * @return void
     */
    public function create_Book_shortcode()
    {
        add_shortcode('books', [self::class, 'books_shortcode']);
    }


    /**
     * This comment is just for no purposes just to get rid
     * from that error and nothing else
     * please use your mind and understand the login below it;s not complicated
     * 
     * @return void
     */
    public function custom_gutenburg_block()
    {
        // automatically load dependencies and _version
        // $asset_file = include_once plugins_url().'/book/widget/build/index.asset.php';

        wp_register_script(
            'custom-block-script',
            plugins_url().'/book/widget/build/index.js',
            ['wp-element', 'wp-blocks', 'wp-api-fetch', 'wp-components', 'wp-block-editor'],
        );

        wp_register_style(
            'custom-editor-css',
            plugins_url().'/book/widget/editor.css',
            []
        );

        wp_register_style(
            'custom-style-css',
            plugins_url().'/book/widget/style.css',
            []
        );

        register_block_type(
            'fancy-block-plugin/fancy-custom-block', [
            'editor_script' => 'custom-block-script',
            'editor_style' => 'custom-editor-css',
            'style' => 'custom-style-css',
            ]
        );
    }


    /**
     * This comment is just for no purposes just to get rid
     * from that error and nothing else
     * please use your mind and understand the login below it;s not complicated
     * 
     * @return void
     */
    public function register_custom_herachical_taxonomy()
    {
        $labels = [
        'name' => _x(' Book Categories', 'taxonomy general name'),
        'singular_name' => _x(' Book Category', 'taxonomy singular name'),
        'search_items' => __('Search  Book Categories'),
        'all_items' => __('All  Book Categories'),
        'parent_item' => __('Parent  Book Category'),
        'parent_item_colon' => __('Parent  Book Category:'),
        'edit_item' => __('Edit  Book Category'),
        'update_item' => __('Update  Book Category'),
        'add_new_item' => __('Add New  Book Category'),
        'new_item_name' => __('New  Book Category Name'),
        'menu_name' => __(' Book Category'),
        ];
        $args = [
        'hierarchical' => true, // make it hierarchical (like categories)
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'book_category'],
        'show_in_rest' => true,
         ];
        register_taxonomy('book_category', ['books'], $args);
    }

    /**
     * This comment is just for no purposes just to get rid
     * from that error and nothing else
     * please use your mind and understand the login below it;s not complicated
     * 
     * @return void
     */
    public function registerCustomNonherachicalTaxonomy()
    {
        $labels = [
        'name' => _x(' Book Tag', 'taxonomy general name'),
        'singular_name' => _x(' Book Tags', 'taxonomy singular name'),
        'search_items' => __('Search  Book Tags'),
        'all_items' => __('All  Book Tags'),
        'parent_item' => __('Parent  Book Tag'),
        'parent_item_colon' => __('Parent  Book Tag:'),
        'edit_item' => __('Edit  Book Tag'),
        'update_item' => __('Update  Book Tag'),
        'add_new_item' => __('Add New  Book Tag'),
        'new_item_name' => __('New  Book Tag Name'),
        'menu_name' => __(' Book Tag'),
        ];
        $args = [
        'hierarchical' => true, // make it hierarchical (like categories)
        'labels' => $labels,
        'show_in_rest' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'book_tag'],
        ];
        register_taxonomy('book_tag', ['books'], $args);
    }

    /**
     * This comment is just for no purposes just to get rid
     * from that error and nothing else
     * please use your mind and understand the login below it;s not complicated
     * 
     * @return void
     */
    public function addBookSettings()
    {
        add_submenu_page(
            'edit.php?post_type=books', //$parent_slug
            'Book Settings Page',  //$page_title
            'Book Settings',        //$menu_title
            'manage_options',           //$capability
            'book_Settings', //menu slug
            [self::class, 'bookSettingsHtml'] //$function
        );
    }
    /**
     * This comment is just for no purposes just to get rid
     * from that error and nothing else
     * please use your mind and understand the login below it;s not complicated
     * 
     * @return void
     */
    public function bookSettingsHtml()
    {
        if (isset($_POST['currency']) && isset($_POST['no_of_post'])) {
            $currency = $_POST['currency'];
            $no_of_post = $_POST['no_of_post'];
            update_option('book_currency', $currency);
            update_option('book_no_of_post', $no_of_post);
            echo 'done';
        }
        $options = get_option('book_currency'); ?>
    <h1>Hii i Am ADMIn</h1>
    <form method="post">
    <label for="currency">Currency</label>
    <select id="currency" name="currency">
    <option value="₹" <?php selected($options, '₹'); ?>>₹</option>
    <option value="$" <?php selected($options, '$'); ?>>$</option>
    <option value="€" <?php selected($options, '€'); ?>>€</option>
  </select>
    <br/><br />
    <label for="no_of_post">No of post per page</label>
    <input type="number" id="no_of_post" placeholder="Eg. 4 or 5" name="no_of_post"><br/><br/>
    <input type="submit" class="button-primary" value="<?php _e('Save changes', 'bookdomain'); ?>" />
    </form>
        <?php
    }
}
