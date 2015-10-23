<?php

class MPP_Media_View_Counter_Admin {
	
	private static $instance = null; 
	
	private function __construct () {
		//setup hooks
		$this->setup_hooks();
	}
	
	
	/**
	 * 
	 * @return MPP_Media_View_Counter_Admin
	 */
	public static function get_instance() {
		
		if( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		
		return self::$instance;
	}
	
	
	private function setup_hooks() {
		//register admin settings fields
		add_action( 'mpp_admin_register_settings', array( $this, 'register_settings' ) );
	}
	/**
	 * 
	 * @param MPP_Admin_Settings_Page $page
	 */
	public function register_settings( $page ) {
		
		//$page = mpp_admin()->get_page();
		
		$panel = $page->get_panel( 'addons' );

		
		$panel->add_section( 'addon-counter', __( 'Media View Counter Settings', 'mpp-media-view-counter' ) ) 
				->add_field( array(
					'name'		=> 'media_view_counter_count_uploader_views',
					'label'		=> __( "Count Media Owner's view to the media?", 'mpp-media-view-counter' ),
					'type'		=> 'radio',
					'default'	=> 1,
					'options'	=> array(
									1 => __( 'Yes', 'mpp-media-view-counter' ),
									0 => __( 'No', 'mpp-media-view-counter' ),
								)
				) )
				->add_field( array(
					'name'			=> 'media_view_counter_label_views',
					'label'			=> __( "What label you want to display for total views", 'mpp-media-view-counter' ),
					'type'			=> 'text',
					'default'		=> __( "Total Views %d", 'mpp-media-view-counter' ),
					'description'	=> __( "Please don't forget the %d. It will be replaced by actual count.", 'mpp-media-view-counter' ), 
					
				) );
	}
}

MPP_Media_View_Counter_Admin::get_instance();
