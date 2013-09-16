<?php
/*
Plugin Name: Simple Visitor Log
Plugin URI: http://plugins.findingsimple.com
Description: Simple plugin for logging site visitors
Version: 1.0
Author: Finding Simple
Author URI: http://findingsimple.com
License: GPL2
*/
/*
Copyright 2013  Finding Simple  (email : plugins@findingsimple.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! class_exists( 'Simple_Visitor_Log' ) ) {

	/**
	 * Plugin Main Class.
	 *
	 */
	class Simple_Visitor_Log {

		/**
		 * Initialise
		 */
		function Simple_Visitor_Log() {

			global $svl_db_version, $svl_plugin_dir, $svl_plugin_dir_url;
			
			$svl_db_version = "1.0";

			$svl_plugin_dir = plugin_dir_path( __FILE__ );

			$svl_plugin_dir_url = plugin_dir_url( __FILE__ );

			require_once 'classes/class-svl-activate.php';
			require_once 'classes/class-svl-uninstall.php';
			require_once 'classes/class-svl-log.php';

		}

	}

	$Simple_Visitor_Log = new Simple_Visitor_Log();

	register_activation_hook( __FILE__, array( 'SVL_Activate', 'svl_add_db_table' ) );
	register_uninstall_hook(__FILE__, array( 'SVL_Uninstall', 'svl_remove_db_table' ));

}