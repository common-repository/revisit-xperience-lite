<?php 

function activate(){
	global $wpdb;

	$wpdb->query('			
CREATE TABLE IF NOT EXISTS `'.$wpdb->prefix.'emi_slider` (
  `user_id` bigint(20) unsigned NOT NULL,
  `first_visit_time` timestamp NULL DEFAULT NULL,
  `last_visit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `missed_posts` text,
  PRIMARY KEY (`user_id`)
) DEFAULT CHARSET=utf8;	
	');
	
	update_option( 'emiSlider', array(
			'activityTimeRange' => 15,
			'cookieLifeTime' => 30,
			'maxPostInList' => 10,
			'sortBy' => 'post_date',
			'sortDirection' => 'ASC',
			'boxTitle' => 'Missed Posts',
            'boxNoPostText' => 'No missed posts :)',
			'customLinkUrl' => '',
			'customLinkName' => '',
			'boxWidth' => 300,
			'boxHeight' => 485,
			'maxTitleLength' => 30,
			'splashAnimation' => 1,
			'showInHomepage' => 1
	), '', 'no' );
}
activate();
?>