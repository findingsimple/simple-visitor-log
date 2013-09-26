<?php

if ( ! class_exists( 'SVL_Log' ) ) {

	/**
	 * SVL_Log Class.
	 *
	 */
	class SVL_Log {

		/**
		 * Initialise
		 */
		function SVL_Log() {

			add_action( 'wp_enqueue_scripts', array( $this, 'svl_log_visit_script' ) );

       		// log visit using ajax    
        	add_action( 'wp_ajax_nopriv_svl-log-visit', array( $this, 'svl_log_visit' ) );
        	add_action( 'wp_ajax_svl-log-visit', array( $this, 'svl_log_visit' ) );

		}

		/**
		 * Enqueue the logging script - only on singulat posts
		 */
		function svl_log_visit_script() {

			if ( ! is_singular() || is_admin() )
				return;

			global $svl_plugin_dir_url, $post;

			wp_enqueue_script("jquery");

			/* jQuery Cookie */
 			wp_register_script( 'jquery-cookie', $svl_plugin_dir_url . 'js/jquery.cookie.min.js', 'jquery', '1', true );
 			wp_enqueue_script( 'jquery-cookie' );

			wp_register_script( 'svl-log-visit', $svl_plugin_dir_url . 'js/svl-log-visit.js' , array( 'jquery', 'json2', 'jquery-cookie' ), true );
			wp_enqueue_script( 'svl-log-visit' );

			wp_localize_script( 'svl-log-visit', 'LogVisit', array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ), 
				'wpnonce' => wp_create_nonce( 'svl-log-visit' ),
				'post_id' => $post->ID
				)
			);

		}

		function svl_log_visit() {

			$nonce = $_REQUEST['nonce'];
				 
			// check nonce
			if ( ! wp_verify_nonce( $nonce, 'svl-log-visit' ) )
				die ( 'Busted!');

			$post_id = intval( $_REQUEST['post_id'] );

		    $data = array();
		    $format = array();

		    /**
		     * Time
		     */
		    $data['time'] = time();
		    $format[] = '%d';

		    /**
		     * Post ID
		     */
		    $data['post_id'] = $post_id;
		    $format[] = '%d';

		    /** 
		     * UUID
		     */
			if ( isset($_COOKIE['svl_visitor']['uuid'] ) ) {
				$data['uuid'] = mysql_real_escape_string( stripslashes( $_COOKIE['svl_visitor']['uuid'] ) );
		    	$format[] = '%s';	
			} else {
			    $data['uuid'] = 0;
		    	$format[] = '%s';
		    }

		    /**
		     * Insert activity log row into database.
		     */
			global $wpdb;

		    $wpdb->insert( $wpdb->prefix . "simple_visitor_log" , $data, $format);

		}

	}

	$SVL_Log = new SVL_Log();

}