<?php
/**
 * Get the total view count for the given media
 * 
 * @param int|MPP_Media $media
 * @return int the view count
 */
function mpp_media_get_view_count( $media ) {
	
	$media_id = $media;
	
	if( is_object( $media ) ) {
		$media_id = $media->id;
	}
	
	$count = absint( mpp_get_media_meta( $media_id, '_mpp_view_count', true ) );
	
	return $count;
	
}
/**
 * Update view count for given media
 * 
 * @param int|MPP_Media $media
 * @param int $count
 * @return int|bool Meta ID if the key didn't exist, true on successful update, false on failure.
 */
function mpp_media_update_view_count( $media, $count = 0 ) {
	
	$media_id = $media;
	
	if( is_object( $media ) ) {
		$media_id = $media->id;
	}
	
	$count = absint( $count );
	
	//doing direct query is better here
	global $wpdb;
	
	$query = $wpdb->prepare( "UPDATE {$wpdb->postmeta} SET meta_value = %d WHERE meta_key = %s AND post_id = %d ", $count, '_mpp_view_count', $media_id );
	
	$wpdb->query( $query );
	
	//update meta cache
	$cache_key = 'post_meta';
	$cached_object = wp_cache_get( $media_id, $cache_key );
	$cached_object['_mpp_view_count'] = array( 0 => $count );
	
	wp_cache_set( $media_id, $cached_object, $cache_key );
	
	return $count;
	//we do not use update_post_meta as that uses 4 db queries
	//using direct update save 3 db queries
	//return mpp_update_media_meta( $media_id, '_mpp_view_count', $count );
	
}
/**
 * Reset view count for given media to zero
 * 
 * @param int|MPP_Media $media
 * @return int|bool Meta ID if the key didn't exist, true on successful update, false on failure.
 */
function mpp_media_reset_view_count( $media ) {

	return mpp_media_update_view_count( $media, 0 );
	
}
/**
 * Reset view count for given media to zero
 * 
 * @param int|MPP_Media $media
 * @return int|bool Meta ID if the key didn't exist, true on successful update, false on failure.
 */
function mpp_media_increment_view_count( $media, $by_count = 1 ) {
	
	if( empty( $media ) ) {
		return false;
	}
	
	$count = mpp_media_get_view_count( $media );
	
	$count = $count + $by_count;
	
	return mpp_media_update_view_count( $media, $count );
	
}


/**
 * remove view counter key
 * 
 * @param int|MPP_Media $media
 * @return bool True on success, false on failure.
 */
function mpp_media_delete_view_count( $media ) {

	return mpp_delete_media_meta( $media, '_mpp_view_count' );
	
}
