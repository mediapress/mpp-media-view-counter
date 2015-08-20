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
		
		$panel->add_section( 'addon-counter', __( 'Media View Counter Settings' ) ) ->add_field( array(
					'name'		=> 'count_uploader_user_views',
					'label'		=> __( "Count Media Owner's view to the media?", 'mpp-media-view-counter' ),
					'type'		=> 'radio',
					'default'	=> 1,
					'options'	=> array(
									1 => __( 'Yes', 'mpp-media-view-counter' ),
									0 => __( 'No', 'mpp-media-view-counter' ),
								)
		) );
	}
}

MPP_Media_View_Counter_Admin::get_instance();