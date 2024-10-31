<?php
/*
* Plugin Name: Remove WP Footer Credit
* Version: 1.0.2
* Description: A very simple plugin to remove or replace wordpress footer credit text
* Author: Faisal Irshad
* Author URI: https://profiles.wordpress.org/faisalirshad
* License: GPLv3 or later
* Text Domain: remove-wpcredit
*/

/*
Copyright 2018 Faisal Irshad Ahmad

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/


	add_action('init','wprc_plugin_activate');
	register_activation_hook( __FILE__, 'wprc_plugin_activate'); //activate hook
	register_deactivation_hook(__FILE__, 'wprc_plugin_deactivate'); //deactivate hook

	/* Add option in setting, General page for new footer text */
	function wprc_plugin_activate(){
		add_filter('admin_init', 'wprc_register_fields');
		add_action( 'wp_footer', 'wprc_remove_show_new_credit' );		
	}
	
	/* Remove option in setting, General page for new footer text */
	function wprc_plugin_deactivate(){
		delete_option('wprc_credit_text');
	}
	
	// Register setting and field to wordpress
	function wprc_register_fields()
	{
		register_setting('general', 'wp_credit_text', 'esc_attr');
		add_settings_field('wprc_credit_text', '<label for="wprc_credit_text">'.__('Footer Text' , 'wprc_credit_text' ).'</label>' , 'wprc_print_custom_field', 'general');
	}
	
	//  Show textbox in setting, general page
	function wprc_print_custom_field()
	{
		$value = get_option( 'wprc_credit_text' );
		echo '<input type="text" id="wprc_credit_text" name="wprc_credit_text" value="' . $value . '" />';
	}
	
	//  show footer credit with new text
	function wprc_remove_show_new_credit() {
		$savedOption = get_option('wprc_credit_text');
		echo '<script>jQuery(document).ready(function() {
				jQuery(".site-info").replaceWith("'.$savedOption .'");   }); </script>';
	}
	

?>
