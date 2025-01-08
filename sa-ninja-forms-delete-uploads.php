<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://sylvere.fr
 * @since             1.0.0
 * @package           Sa_Ninja_Forms_Delete_Uploads
 *
 * @wordpress-plugin
 * Plugin Name:       Ninja Forms - Delete Uploads
 * Plugin URI:        
 * Description:       Delete related file uploads when deleting a form submission. This is not an official Ninja Forms plugin.
 * Version:           1.0.0
 * Author:            Sylvère Armange
 * Author URI:        https://sylvere.fr/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sa-ninja-forms-delete-uploads
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('SA_NINJA_FORMS_DELETE_UPLOADS_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sa-ninja-forms-delete-uploads-activator.php
 */
function activate_sa_ninja_forms_delete_uploads()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-sa-ninja-forms-delete-uploads-activator.php';
	Sa_Ninja_Forms_Delete_Uploads_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sa-ninja-forms-delete-uploads-deactivator.php
 */
function deactivate_sa_ninja_forms_delete_uploads()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-sa-ninja-forms-delete-uploads-deactivator.php';
	Sa_Ninja_Forms_Delete_Uploads_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_sa_ninja_forms_delete_uploads');
register_deactivation_hook(__FILE__, 'deactivate_sa_ninja_forms_delete_uploads');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-sa-ninja-forms-delete-uploads.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sa_ninja_forms_delete_uploads()
{

	$plugin = new Sa_Ninja_Forms_Delete_Uploads();
	$plugin->run();

}
run_sa_ninja_forms_delete_uploads();