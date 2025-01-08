<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://sylvere.fr
 * @since      1.0.0
 *
 * @package    Sa_Ninja_Forms_Delete_Uploads
 * @subpackage Sa_Ninja_Forms_Delete_Uploads/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Sa_Ninja_Forms_Delete_Uploads
 * @subpackage Sa_Ninja_Forms_Delete_Uploads/includes
 * @author     Sylvère Armange <sa@gmail.com>
 */
class Sa_Ninja_Forms_Delete_Uploads_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'sa-ninja-forms-delete-uploads',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
