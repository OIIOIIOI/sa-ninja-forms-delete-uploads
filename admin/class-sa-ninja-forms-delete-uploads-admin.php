<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://sylvere.fr
 * @since      1.0.0
 *
 * @package    Sa_Ninja_Forms_Delete_Uploads
 * @subpackage Sa_Ninja_Forms_Delete_Uploads/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sa_Ninja_Forms_Delete_Uploads
 * @subpackage Sa_Ninja_Forms_Delete_Uploads/admin
 * @author     Sylvère Armange <sa@gmail.com>
 */
class Sa_Ninja_Forms_Delete_Uploads_Admin
{

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sa_Ninja_Forms_Delete_Uploads_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sa_Ninja_Forms_Delete_Uploads_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/sa-ninja-forms-delete-uploads-admin.css', array(), $this->version, 'all');

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sa_Ninja_Forms_Delete_Uploads_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sa_Ninja_Forms_Delete_Uploads_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/sa-ninja-forms-delete-uploads-admin.js', array('jquery'), $this->version, false);

	}

	/* public function setup_settings_menus(): void
		  {
			  add_menu_page(
				  'Ninja Forms - Delete Uploads',
				  'NF - Delete',
				  'manage_options',
				  'sa_ninja_forms_delete_uploads',
				  array($this, 'settings_main_content'),
				  'dashicons-trash',
				  3
			  );
		  }

		  public function settings_main_content(): void
		  {
			  include plugin_dir_path(__FILE__) . 'partials/settings-main-content.php';
		  } */

	public function wp_trash_post(int $post_id, string $previous_status)
	{
		// error_log("Post trashed: " . $post_id . " - Type: " . get_post_type($post_id));

		// Check if both Ninja Forms and Ninja Forms Uploads are active
		$is_nf_active = is_plugin_active("ninja-forms/ninja-forms.php");
		$is_nf_uploads_active = is_plugin_active("ninja-forms-uploads/file-uploads.php");
		if (!$is_nf_active || !$is_nf_uploads_active) {
			$is_nf_active = $is_nf_active ? "true" : "false";
			$is_nf_uploads_active = $is_nf_uploads_active ? "true" : "false";
			// error_log("Requirements not met: " . $is_nf_active . " / " . $is_nf_uploads_active);
			return;
		}

		// Check if trashed post is a Ninja Forms submission
		if (get_post_type($post_id) != "nf_sub")
			return;

		// Get submission object
		$sub = Ninja_Forms()->form()->sub($post_id)->get();

		// Get related form ID
		$form_id = $sub->get_extra_value("_form_id");
		// error_log("Submission Form ID: " . $form_id);
		if (!$form_id)
			return;

		// Get related form fields
		$fields = Ninja_Forms()->form($form_id)->get_fields();
		foreach ($fields as $model) {
			// If field is not of type "file_upload", continue
			if ($model->get_setting("type") != NF_FU_File_Uploads::TYPE)
				continue;

			// Get field ID and key
			$field_id = $model->get_id();
			$field_key = $model->get_setting('key');

			// error_log(NF_FU_File_Uploads::TYPE . " type field found: " . $field_id . " - " . $field_key);

			// Get all uploads for field and submission
			$uploads = NF_File_Uploads()->controllers->uploads->get_field_uploads_by_submission_id($field_id, $post_id);

			// Delete uploaded file and update submission
			foreach ($uploads as $upload) {
				// Get upload ID
				$upload_id = $upload["id"];

				// Get upload and check if empty
				$file_upload = NF_File_Uploads()->controllers->uploads->get($upload_id);
				if (!$file_upload)
					continue;

				// Get file path and check if exists
				$file_path = $file_upload->file_path;
				// error_log("File found: " . $file_path);
				if (!file_exists($file_path))
					continue;

				// error_log("All checks passed. Deleting file...");

				// Empty submission field
				$sub->update_field_value($field_key, null)->save();
				// Delete upload from database
				NF_File_Uploads()->model->delete($upload_id);
				// Delete file
				unlink($file_path);
			}
		}
	}

}