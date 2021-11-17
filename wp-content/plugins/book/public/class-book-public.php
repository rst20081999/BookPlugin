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
	register_taxonomy( 'book_category', [ 'books' ], $args);
}
public function register_custom_non_herachical_taxonomy() 
{
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
		'rewrite'           => [ 'slug' => 'book_tag' ],
	);
	register_taxonomy( 'book_tag', [ 'books' ], $args );
}
public function custom_meta_box()
{
	$screens = [ 'books'];
        foreach ( $screens as $screen ) {
            add_meta_box(
                'wporg_box_id',          // Unique ID
                'Book Meta Box', // Box title
                [ self::class, 'custom_html_meta_box' ],   // Content callback, must be of type callable
                $screen                  // Post type
            );
        }
}
public function custom_meta_box_save() {
	// if ( isset( $_POST['submit']) ) {
		// $data='';
		// foreach ($_POST as $key => $value) {
			// $data.= "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";
		// }
		// echo "<script>alert(".$data.");</script>";
		global $wpdb,$post;
		$tablename=$wpdb->prefix.'metabox';
		$wpdb->insert(
			$tablename, array(
			'post_id'=>$post->ID,
			'author' => $_POST['author_name'],
			'price'=>$_POST['book_price'],
			'publisher' => $_POST['book_publisher'],
			'year' => $_POST['book_year'],
			'edition'=>$_POST['book_edition']),
			array('%s','%d','%s','%d','%s')
		);
		$wpdb->update(
			$tablename, array(
			'author' => $_POST['author_name'],
			'price'=>$_POST['book_price'],
			'publisher' => $_POST['book_publisher'],
			'year' => $_POST['book_year'],
			'edition'=>$_POST['book_edition']),
			array('post_id'=>$post->ID,)
		);
	// }
}
public function custom_html_meta_box()
{
	// global $post;
	// $value=ge_post_meta( $post->ID, 'wporg_box', true);
	// echo $value;
	// global $wpdb;
	// echo $wpdb->get_row( "SELECT * FROM 'wp_metabox' WHERE id = 1" );
		?>
        <label for="author">Enter Book Author</label>&nbsp;&nbsp;&nbsp;
		<input type="text" placeholder="Book Author" id="author" name="author_name" value="<?php echo $_POST['author_name'] ?>"><br/><br/>
		<label for="book_price">Enter Book Price</label>&nbsp;&nbsp;&nbsp;
		<input type="number" placeholder="Book Price" id="book_price" name="book_price" value="<?php esc_html($_POST['book_price']);?>"><br/><br/>
		<label for="book_publisher">Enter Book Publisher</label>&nbsp;&nbsp;&nbsp;
		<input type="text" placeholder="Book Publisher" id="book_publisher" name="book_publisher" value="<?php _e($_POST['book_publisher'], "bookdomain");?>"><br/><br/>
		<label for="book_year">Book Year</label>&nbsp;&nbsp;&nbsp;
		<input type="numberS" placeholder="Book Year" id="book_year" name="book_year" value="<?php _e($_POST['book_year'], "bookdomain");?>"><br/><br/>
		<label for="book_edition">Book Edition</label>&nbsp;&nbsp;&nbsp;
		<input type="text" placeholder="Book Edition" id="book_edition" name="book_edition" value="<?php _e($_POST['book_edition'], "bookdomain");?>"><br/><br/>
        <?php
}
public function add_book_settings(){
	add_submenu_page(
		'edit.php?post_type=books', //$parent_slug
		'Book Settings Page',  //$page_title
		'Book Settings',        //$menu_title
		'manage_options',           //$capability
		'book_Settings', //menu slug
		[ self::class, 'book_settings_html' ] //$function
);
}
public function book_settings_html(){
	if(isset($_POST['currency']) && isset($_POST['no_of_post'])){
		$currency=$_POST['currency'];
		$no_of_post=$_POST['no_of_post'];
		update_option('book_currency', $currency);
		update_option('book_no_of_post', $no_of_post);
		echo "done";
	}
	$options=get_option('book_currency');
	?>
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
	<input type="submit" class="button-primary" value="<?php _e('Save changes', 'bookdomain' ); ?>" />
	</form>
	<?php
}
public function create_Book_shortcode(){
	add_shortcode('books', [self::class,'books_shortcode']);

}
public function books_shortcode( $atts = [], $content = null,$tag='') {
    // do something to $content
    // always return
	?>
	<div style="border: 1px solid red;">
	<h4><?php echo $atts['id'] ?></h4>
	<h4><?php echo $atts['author'] ?></h4>
	<h4><?php echo $atts['year'] ?></h4>
	<h4><?php echo $atts['category'] ?></h4>
	<h4><?php echo $atts['tag'] ?></h4>
	</div>
	<?php
    return $content;
}
public function custom_gutenburg_block(){
	// automatically load dependencies and version
    // $asset_file = include_once plugins_url().'/book/widget/build/index.asset.php';

    wp_register_script(
        'fancy-custom-block-block-editor',
        plugins_url().'/book/widget/build/index.js',
        array('wp-element','wp-blocks','wp-api-fetch','wp-components'),
    );

    wp_register_style(
        'fancy-custom-block-block-editor',
        plugins_url().'/book/widget/editor.css',
        array()
    );

    wp_register_style(
        'fancy-custom-block-block',
        plugins_url().'/book/widget/editor.css',
        array()
    );

    register_block_type( 'fancy-block-plugin/fancy-custom-block', array(
        'editor_script' => 'fancy-custom-block-block-editor',
        'editor_style'  => 'fancy-custom-block-block-editor',
        'style'         => 'fancy-custom-block-block',
    ) );
}
public function my_rest_api_init() {
    register_rest_route( 'book-plugin/v1', '/items', array(
        'methods'             => 'GET',
        'permission_callback' => '__return_true', // *always set a permission callback
        'callback'            => function ( $request ) {
			$args = array(
				'taxonomy' => 'book_category',
				'orderby' => 'name',
               'order'   => 'ASC'
			);
			$cats = get_categories($args);
			$data=array();
			foreach($cats as $cat) {
				array_push($data,$cat->name);
			}
            return $data;
        },
    ) );
	register_rest_route('book-plugin/v1','/post',array(
		'methods'=>'GET',
		'permission_callback'=>'__return_true',
		'callback'=>function($request){
			$args = array(
				'taxonomy' => 'book_category',
				'orderby' => 'name',
               'order'   => 'ASC'
			);
			$cats = get_categories($args);
			$catPost = get_posts(get_cat_ID("ddd"));
			return $cats;
		}
	));
}
}
