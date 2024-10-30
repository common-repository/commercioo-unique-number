<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      0.0.1
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
 * @since      0.0.1
 * @author     Your Name <email@example.com>
 */
class Commercioo_Unique_Number {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    0.0.1
	 * @access   protected
	 * @var      Commercioo_Unique_Number_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    0.0.1
	 * @access   protected
	 * @var      string    $commercioo_unique_number    The string used to uniquely identify this plugin.
	 */
	protected $commercioo_unique_number;

	/**
	 * The current version of the plugin.
	 *
	 * @since    0.0.1
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    0.0.1
	 */
	public function __construct() {
		if ( defined( 'COMMERCIOO_UNIQUE_NUMBER_VERSION' ) ) {
			$this->version = COMMERCIOO_UNIQUE_NUMBER_VERSION;
		} else {
			$this->version = '0.0.1';
		}
		$this->commercioo_unique_number = 'commercioo-unique-number';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_customizer_unique_number_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Commercioo_Unique_Number_Loader. Orchestrates the hooks of the plugin.
	 * - Commercioo_Unique_Number_i18n. Defines internationalization functionality.
	 * - Commercioo_Unique_Number_Admin. Defines all hooks for the admin area.
	 * - Commercioo_Unique_Number_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    0.0.1
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once COMMERCIOO_UNIQUE_NUMBER_PATH . 'includes/class-commercioo-unique-number-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once COMMERCIOO_UNIQUE_NUMBER_PATH . 'includes/class-commercioo-unique-number-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once COMMERCIOO_UNIQUE_NUMBER_PATH . 'admin/class-commercioo-unique-number-admin.php';

        /**
         * The class responsible for defining customizer.
         */
        require_once COMMERCIOO_UNIQUE_NUMBER_PATH . 'includes/customizer/commercioo-unique-number.php';
		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once COMMERCIOO_UNIQUE_NUMBER_PATH . 'public/class-commercioo-unique-number-public.php';

		$this->loader = new Commercioo_Unique_Number_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Commercioo_Unique_Number_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    0.0.1
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Commercioo_Unique_Number_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 */
	private function define_admin_hooks() {

		$commercioo_unique_number_admin = new Commercioo_Unique_Number_Admin( $this->get_commercioo_unique_number(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $commercioo_unique_number_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $commercioo_unique_number_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_notices', $commercioo_unique_number_admin, 'missing_commercioo_unique_number_notice' );
		$this->loader->add_filter( 'plugin_action_links_'.COMMERCIOO_UNIQUE_NUMBER_BASENAME, $commercioo_unique_number_admin, 'my_plugin_settings_link' );

	}

    /**
     * Register all of the hooks related to the customizer area functionality
     * of the plugin.
     *
     * @since    0.0.1
     * @access   private
     */
    private function define_customizer_unique_number_hooks() {

        // Unique Number Settings Checkout Customizer
        $comm_customizer_unique_number = new Commercioo_Unique_Number_Customizer($this->get_commercioo_unique_number(),$this->get_version());
        // Set default settings unique number for Setting unique number checkout customizer
        $this->loader->add_action( 'commercioo_set_default_settings_unique_number', $comm_customizer_unique_number, 'commercioo_set_default_settings');
        // Register Setting unique number checkout customizer
        $this->loader->add_action( 'customize_register', $comm_customizer_unique_number, 'checkout_customizer');

    }
	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 */
	private function define_public_hooks() {

		$commercioo_unique_number_public = new Commercioo_Unique_Number_Public( $this->get_commercioo_unique_number(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $commercioo_unique_number_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $commercioo_unique_number_public, 'enqueue_scripts' );

        // View Unique Number
        $this->loader->add_action( 'commercioo_view_unique_number', $commercioo_unique_number_public, 'commercioo_view_unique_number');
		// Generate Unique Number
        $this->loader->add_action( 'commercioo_unique_number', $commercioo_unique_number_public, 'commercioo_unique_number',10,2);
        // Update Post Meta
        $this->loader->add_action( 'commercioo_update_post_meta', $commercioo_unique_number_public, 'commercioo_update_post_meta',10,2);
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    0.0.1
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     0.0.1
	 * @return    string    The name of the plugin.
	 */
	public function get_commercioo_unique_number() {
		return $this->commercioo_unique_number;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     0.0.1
	 * @return    Commercioo_Unique_Number_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     0.0.1
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
