<?php

/**
 * The file that defines the core plugin class.
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @see   https://wa.me/+918108981924
 * @since 1.0.0
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since 1.0.0
 *
 * @author RIshabh Tiwari <rishabh.tiwari@hbwsl.com>
 */
class Book
{
    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since 1.0.0
     *
     * @var Book_Loader maintains and registers all hooks for the plugin
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since 1.0.0
     *
     * @var string the string used to uniquely identify this plugin
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since 1.0.0
     *
     * @var string the current version of the plugin
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        if (defined('BOOK_VERSION')) {
            $this->version = BOOK_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'book';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Book_Loader. Orchestrates the hooks of the plugin.
     * - Book_i18n. Defines internationalization functionality.
     * - Book_Admin. Defines all hooks for the admin area.
     * - Book_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since 1.0.0
     */
    private function load_dependencies()
    {
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        include_once plugin_dir_path(dirname(__FILE__)).'includes/class-book-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        include_once plugin_dir_path(dirname(__FILE__)).'includes/class-book-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        include_once plugin_dir_path(dirname(__FILE__)).'admin/class-book-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        include_once plugin_dir_path(dirname(__FILE__)).'public/class-book-public.php';

        $this->loader = new Book_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Book_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since 1.0.0
     */
    private function set_locale()
    {
        $plugin_i18n = new Book_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since 1.0.0
     */
    private function define_admin_hooks()
    {
        $plugin_admin = new Book_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        $this->loader->add_action('init', $plugin_admin, 'Custom_Post_Book');
        $this->loader->add_action('init', $plugin_admin, 'create_Book_shortcode');
        $this->loader->add_action('init', $plugin_admin, 'custom_gutenburg_block');
        $this->loader->add_action('init', $plugin_admin, 'register_custom_herachical_taxonomy');
        $this->loader->add_action('init', $plugin_admin, 'register_custom_non_herachical_taxonomy');
        $this->loader->add_action('admin_menu', $plugin_admin, 'add_book_settings');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since 1.0.0
     */
    private function define_public_hooks()
    {
        $plugin_public = new Book_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        $this->loader->add_action('add_meta_boxes', $plugin_public, 'custom_meta_box');
        $this->loader->add_action('save_post', $plugin_public, 'custom_meta_box_save');
        $this->loader->add_action('rest_api_init', $plugin_public, 'my_rest_api_init', 10, 1);
        $this->loader->add_action('wp_dashboard_setup', $plugin_public, 'book_custom_dashboard_widgets');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since 1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since 1.0.0
     *
     * @return string the name of the plugin
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since 1.0.0
     *
     * @return Book_Loader orchestrates the hooks of the plugin
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since 1.0.0
     *
     * @return string the version number of the plugin
     */
    public function get_version()
    {
        return $this->version;
    }
}
