<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      0.0.1
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      0.0.1
 * @author     Your Name <email@example.com>
 */
class Commercioo_Unique_Number_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    0.0.1
	 */
	public static function activate() {
        do_action("commercioo_set_default_settings_unique_number");
	}

}
