<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @see   https://wa.me/+918108981924
 * @since 1.0.0
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @author     RIshabh Tiwari <rishabh.tiwari@hbwsl.com>
 */
class Book_Public
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     *
     * @var string the ID of this plugin
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     *
     * @var string the current version of this plugin
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     *
     * @param string $plugin_name the name of the plugin
     * @param string $version     the version of this plugin
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
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

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__).'css/book-public.css', [], $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
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

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__).'js/book-public.js', ['jquery'], $this->version, false);
    }

    /**
     * Custom post type funtion for book post type.
     *
     * @return void
     */
    public function custom_meta_box()
    {
        $screens = ['books'];
        foreach ($screens as $screen) {
            add_meta_box(
                'wporg_box_id',          // Unique ID
                'Book Meta Box', // Box title
                [self::class, 'custom_html_meta_box'],   // Content callback, must be of type callable
                $screen                  // Post type
            );
        }
    }

    public function custom_meta_box_save()
    {
        // if ( isset( $_POST['submit']) ) {
        // $data='';
        // foreach ($_POST as $key => $value) {
        // $data.= "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";
        // }
        // echo "<script>alert(".$data.");</script>";
        global $wpdb,$post;
        $tablename = $wpdb->prefix.'metabox';
        $wpdb->insert(
            $tablename, [
            'post_id' => $post->ID,
            'author' => $_POST['author_name'],
            'price' => $_POST['book_price'],
            'publisher' => $_POST['book_publisher'],
            'year' => $_POST['book_year'],
            'edition' => $_POST['book_edition'], ],
            ['%s', '%d', '%s', '%d', '%s']
        );
        $wpdb->update(
            $tablename, [
            'author' => $_POST['author_name'],
            'price' => $_POST['book_price'],
            'publisher' => $_POST['book_publisher'],
            'year' => $_POST['book_year'],
            'edition' => $_POST['book_edition'], ],
            ['post_id' => $post->ID]
        );
        // }
    }

    public static function custom_html_meta_box()
    {
        // global $post;
    // $value=ge_post_meta( $post->ID, 'wporg_box', true);
    // echo $value;
    // global $wpdb;
    // echo $wpdb->get_row( "SELECT * FROM 'wp_metabox' WHERE id = 1" );
        ?>
        <label for="author">Enter Book Author</label>&nbsp;&nbsp;&nbsp;
		<input type="text" placeholder="Book Author" id="author" name="author_name" ><br/><br/>
		<label for="book_price">Enter Book Price</label>&nbsp;&nbsp;&nbsp;
		<input type="number" placeholder="Book Price" id="book_price" name="book_price" ><br/><br/>
		<label for="book_publisher">Enter Book Publisher</label>&nbsp;&nbsp;&nbsp;
		<input type="text" placeholder="Book Publisher" id="book_publisher" name="book_publisher"><br/><br/>
		<label for="book_year">Book Year</label>&nbsp;&nbsp;&nbsp;
		<input type="numberS" placeholder="Book Year" id="book_year" name="book_year" ><br/><br/>
		<label for="book_edition">Book Edition</label>&nbsp;&nbsp;&nbsp;
		<input type="text" placeholder="Book Edition" id="book_edition" name="book_edition"><br/><br/>
        <?php
    }

    public function my_rest_api_init()
    {
        register_rest_route('book-plugin/v1', '/items', [
        'methods' => 'GET',
        'permission_callback' => '__return_true', // *always set a permission callback
        'callback' => function ($request) {
            $args = [
                'taxonomy' => 'book_category',
                'orderby' => 'name',
               'order' => 'ASC',
            ];
            $cats = get_categories($args);
            $data = [];
            foreach ($cats as $cat) {
                array_push($data, $cat->name);
            }

            return $data;
        },
    ]);
        register_rest_route('book-plugin/v1', '/post/(?P<category>[a-zA-Z0-9]+)', [
        'methods' => 'GET',
        'permission_callback' => '__return_true',
        'callback' => function ($request) {
            $feild = $request['category'];
            global $wpdb;
            $query = "SELECT `object_id` FROM `wp_term_relationships` WHERE `term_taxonomy_id`=(SELECT `term_id` from `wp_terms` where `name`='$feild')";
            $post_ids = $wpdb->get_results($query);
            $ids = [];
            foreach ($post_ids as $id) {
                array_push($ids, $id->object_id);
            }
            // return $ids;
            // $id=implode(',',$ids);
            $d = [];
            foreach ($ids as $pid) {
                $query2 = "SELECT * FROM `wp_metabox` WHERE `post_id`='$pid'";
                $data = $wpdb->get_results($query2);
                array_push($d, $data[0]);
            }

            return $d;
        },
    ]);
    }

    public function book_custom_dashboard_widgets()
    {
        global $wp_meta_boxes;
        wp_add_dashboard_widget('custom_book_widget', 'Book Dashboard Widget', [self::class, 'custom_Dashboard_HTML']);
    }

    public function custom_Dashboard_HTML()
    {
        echo '<p>Hey Buddy, I am HERE</p>';
        $args = [
            'taxonomy' => 'book_category',
            'orderby' => 'count',
           'order' => 'DESC',
        ];
        $cats = get_categories($args);
        $count = 0;
        foreach ($cats as $cat) {
            if ($count == 5) {
                break;
            } else {
                ++$count;
            }
            echo $cat->name.'   '.$cat->count;
            echo '<br/>';
        }
    }
}
