<?php

/**
 * The admin-specific functionality of the plugin.
 *
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * @author     Your Name <email@example.com>
 */
class Commercioo_Unique_Number_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      string    $commercioo_unique_number    The ID of this plugin.
	 */
	private $commercioo_unique_number;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
    public $has_commercioo;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.0.1
	 * @param      string    $commercioo_unique_number       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $commercioo_unique_number, $version ) {

		$this->commercioo_unique_number = $commercioo_unique_number;
		$this->version = $version;
	}
    /**
     * Check if plugins is already installed.
     *
     * @param  string $plugin_name Plugin slug.
     * @return boolean              Installation status.
     */
    public function is_dependent_plugin_installed($plugin_name)
    {
        if (!function_exists('get_plugins')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        $all_plugins = get_plugins();
        return !empty($all_plugins[$plugin_name]);
    }
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Commercioo_Unique_Number_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Commercioo_Unique_Number_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->commercioo_unique_number, plugin_dir_url( __FILE__ ) . 'css/commercioo-unique-number-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Commercioo_Unique_Number_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Commercioo_Unique_Number_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->commercioo_unique_number, plugin_dir_url( __FILE__ ) . 'js/commercioo-unique-number-admin.js', array( 'jquery' ), $this->version, false );

	}
    /**
     * Handles Required dependent plugin activation of Commercioo Unique Number plugin files.
     *
     * @since  0.0.1
     *
     * @return void
     */

    public function missing_commercioo_unique_number_notice()
    {
        if (class_exists('Commercioo')) {
            return;
        }
        $dependent_plugin = 'commercioo/commercioo.php';
        if ($this->is_dependent_plugin_installed($dependent_plugin)) {
            echo '<div class="error"><p>Commercioo Unique Number' . ' ' . sprintf(__('requires %s. Please activate it to continue.', 'commercioo-unique-number'), '<b>Commercioo</b>') . '</p></div>';
        }else{
            echo '<div class="error"><p>Commercioo Unique Number' . ' ' . sprintf(__('requires %s. Please install it to continue.', 'commercioo-unique-number'), '<b>Commercioo</b>') . '</p></div>';
        }
    }

    /**
     * Add Link Setting go to Customizer Settings Unique Number
     */
    public function my_plugin_settings_link($links) {
        if (class_exists('Commercioo')) {
            $comm_setting_url = admin_url();
            $link_setting = admin_url('customize.php') . '?url=' . site_url() . 'checkout/&autofocus[section]=commercioo_customize_unique_number_checkout&return=' . $comm_setting_url;
            $settings_link = '<a href="'.$link_setting.'">Settings</a>';
            array_unshift($links, $settings_link);
        }
        return $links;
    }
}
