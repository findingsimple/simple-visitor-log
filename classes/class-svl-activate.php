<?php

if ( ! class_exists( 'SVL_Activate' ) ) {

	/**
	 * SVL_Activate Class.
	 *
	 */
	class SVL_Activate {

		/**
		 * Initialise
		 */
		function SVL_Activate() {

			/* do nothing */

		}

		function svl_add_db_table() {

			global $wpdb;

			global $svl_db_version;

			$table_name = $wpdb->prefix . "simple_visitor_log";
		      
			$sql = "CREATE TABLE $table_name (
		    	id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	            time INT NOT NULL,
	            post_id BIGINT(20) UNSIGNED NOT NULL,
	            uuid VARCHAR(36) NOT NULL,
	            KEY post_id (post_id),
	            KEY time (time),
				PRIMARY KEY id (id)
			);";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

			if ( function_exists('dbDelta') ) {
		        dbDelta($sql);
			}
		 
			add_option( 'svl_db_version', $svl_db_version );

		}	

	}

	$SVL_Activate = new SVL_Activate();

}