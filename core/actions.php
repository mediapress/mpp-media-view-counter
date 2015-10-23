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
		
		if( ! mpp_get_option( 'media_view_counter_count_uploader_views' ) && $media->user_id == get_current_user_id() ) {
			return ;//do not count for the media uploader's own view if it is disabled in the backend
		}
		
		mpp_media_increment_view_count( $media );
				
	}
	
	public function gallery_media_entry() {
		$media = mpp_get_media();
		
		
		$count = mpp_media_get_view_count( $media );
		echo '<span class="mpp-media-view-count">'. $this->get_counter_display( $count ) . '</span>';
	}
	
	public function lightbox_media_entry(  $media ) {
		$media = mpp_get_media();
		
		$count = mpp_media_get_view_count( $media );
		echo '<span class="mpp-media-view-count">'. $this->get_counter_display( $count ) . '</span>';
	}
	
	public function get_counter_display( $count ) {
		
		$label = mpp_get_option( 'media_view_counter_label_views');
		
		if( ! $label ) {
			$label = _x( 'Total Views: %d','view count display text', 'mpp-media-view-counter' );
		}
		
		$count_text = sprintf( $label , $count );
		
		return $count_text;
		
	}
}

MPP_Media_View_Counter_Actions_Helper::get_instance();