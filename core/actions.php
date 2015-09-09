<?php


class MPP_Media_View_Counter_Actions_Helper {
	
	private static $instance = null; 
	
	private function __construct () {
		
		$this->setup_hooks();
	}
	
	private function setup_hooks() {
		//update view count
		add_action( 'mpp_before_single_media_item', array( $this, 'update_count' ) );
		add_action( 'mpp_before_lightbox_media', array( $this, 'update_count' ) );
		
		//show the count on single media page/lightbox
		add_action( 'mpp_after_media_item', array( $this, 'gallery_media_entry' ) );
		add_action( 'mpp_after_single_media_item', array( $this, 'gallery_media_entry' ) );
		add_action( 'mpp_after_lightbox_media', array( $this, 'lightbox_media_entry' ) );
	}
	
	
	public static function get_instance() {
		
		if( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		
		return self::$instance;
	}
	
	public function update_count( $media = 0 ) {
		
		if( ! $media ) {
			$media = mpp_get_media( $media );
		}
		
		if( ! mpp_get_option( 'count_uploader_user_views' ) && $media->user_id == get_current_user_id() ) {
			return ;//do not count for the media uploader's own view if it is disabled in the backend
		}
		
		mpp_media_increment_view_count( $media );
				
	}
	
	public function gallery_media_entry() {
		$media = mpp_get_media();
		
		$count = mpp_media_get_view_count( $media );
		echo '<span class="mpp-media-view-count">'. sprintf( _x( 'Total Views: %d','On single gallery media page', 'mpp-media-view-counter' ), $count ) . '</span>';
	}
	
	public function lightbox_media_entry(  $media ) {
		$media = mpp_get_media();
		
		$count = mpp_media_get_view_count( $media );
		echo '<span class="mpp-media-view-count">'. sprintf( _x( 'Total Views: %d', 'lightbox',  'mpp-media-view-counter' ), $count ) . '</span>';
	}
}

MPP_Media_View_Counter_Actions_Helper::get_instance();