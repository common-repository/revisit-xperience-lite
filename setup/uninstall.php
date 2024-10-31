<?php 
function delete(){
	global $wpdb;
	$wpdb->query( 'DROP table ' . $wpdb->prefix .'emi_slider' );
	delete_option('emiSlider');
}
delete();
?>