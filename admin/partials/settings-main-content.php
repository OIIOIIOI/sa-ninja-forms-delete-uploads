<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://sylvere.fr
 * @since      1.0.0
 *
 * @package    Sa_Ninja_Forms_Delete_Uploads
 * @subpackage Sa_Ninja_Forms_Delete_Uploads/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<h1>Ninja Forms - Delete Uploads</h1>

<?php
$is_nf_active = is_plugin_active("ninja-forms/ninja-forms.php");
$is_nf_uploads_active = is_plugin_active("ninja-forms-uploads/file-uploads.php");

$active_plugins = get_option('active_plugins', array());
var_dump($active_plugins);