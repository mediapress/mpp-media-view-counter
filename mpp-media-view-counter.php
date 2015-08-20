<?php

/**
 * Plugin Name: MediaPress - Media View Counter
 * Version: 1.0.0
 * Plugin URI: http://buddydev.com/plugins/mpp-media-view-counter/
 * Author: BuddyDev Team
 * Author URI: BuddyDev.com
 * Description: Count Media Views and show total media views for MediaPress media.
 */

class MPP_Media_View_Counter {
	
	private static $instance = null; 
	
	private $path;
	private $url;
	
	private function __construct () {
		
		$this->path = plugin_dir_path( __FILE__ );
		$this->url = plugin_dir_url( __FILE__ );
		//setup hooks
		$this->setup_hooks();
		
		$this->load_textdomain();
		
	}
	
	private function setup_hooks() {
		//load required files when MediaPress is loaded
		add_action( 'mpp_loaded', array( $this, 'load' ) );
	}
	
	
	public static function get_instance() {
		
		if( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		
		return self::$instance;
	}
	
	private function load_textdomain() {
		
		load_plugin_textdomain( 'mpp-media-view-counter', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
		
	}
	
	/**
	 * Load required files
	 */
	public function load() {
		
		$files = array(
			'core/actions.php',
			'core/functions.php'
		);
		
		if( is_admin() ) {
			
			$files[] = 'admin/admin.php';
		}
		
		foreach ( $files as $file ) {
			require_once $this->path . $file ;
		}
		
	}
}

MPP_Media_View_Counter::get_instance();