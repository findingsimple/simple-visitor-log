<?php

if ( ! class_exists( 'SVL_Uninstall' ) ) {

	/**
	 * SVL_Deactivate Class.
	 *
	 */
	class SVL_Uninstall {

		/**
		 * Initialise
		 */
		function SVL_Uninstall() {

			/* do nothing */

		}

		/**
		 * Remove svl logging table
		 */
		function svl_remove_db_table() {

		    global $wpdb;

			$table_name = $wpdb->prefix . "simple_visitor_log";

		    $wpdb->query('DROP TABLE `' . $table_name . '`');

		    delete_option( 'svl_db_version' );

		}

	}

	$SVL_Uninstall = new SVL_Uninstall();

}