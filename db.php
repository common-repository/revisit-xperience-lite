<?php
/**
 * EMI: emi.code.tm@gmail.com;
 * http://emicode.wordpress.com
*/
?>
<?php
if(function_exists('revisitxperience_pro_init_process')) {
    deactivate_plugins( plugin_basename( __FILE__ ) );
    wp_die( __( 'Already installed Revisit Xperience Pro Plugin on your site. After deactivate older plugin, please re-activate.', 'emiSlider' ) );
}

class EmiSlider_DB{
     protected static $instance;
     public static function singleton() {
          if (! isset ( self::$instance )) {
               $c = __CLASS__;
               self::$instance = new $c ( );
          }
          return self::$instance;
     }
     public static function getUser($t_userId){
     	global $wpdb;
     	return $wpdb->get_row($wpdb->prepare( '
     		SELECT
     			ES.user_id,
     			UNIX_TIMESTAMP(ES.first_visit_time) AS first_visit_time,
     			UNIX_TIMESTAMP(ES.last_visit_time) AS last_visit_time,
     			COALESCE(ES.missed_posts,\'\') AS missed_posts
     		FROM 
     			'.$wpdb->prefix.'emi_slider ES
     		WHERE ES.user_id = %d
     	',$t_userId));
     }
     public static function insertUser($t_userId){
     	global $wpdb;
		return $wpdb->get_results( $wpdb->prepare( '
     		INSERT INTO 
				'.$wpdb->prefix.'emi_slider
			SET
				user_id = %d,
				first_visit_time = CURRENT_TIMESTAMP
     		ON DUPLICATE KEY UPDATE
     			last_visit_time=CURRENT_TIMESTAMP
     	', $t_userId));
     }
     public static function updateFirstVisitTime($t_userId, $t_postIds){
     	global $wpdb;
     	return $wpdb->get_var( $wpdb->prepare( '
     		UPDATE
     			'.$wpdb->prefix.'emi_slider
     		SET
     			first_visit_time = last_visit_time,
     			missed_posts = %s
     		WHERE
     			user_id = %d
     	', $t_postIds, $t_userId));
     }
     public static function updateMissedPosts($t_userId, $t_postIds){
     	global $wpdb;
     	return $wpdb->get_var( $wpdb->prepare( '
     		UPDATE
     			'.$wpdb->prefix.'emi_slider
     		SET
     			missed_posts = %s
     		WHERE
     			user_id = %d
     	', $t_postIds, $t_userId));
     }
     public static function getTotalByTime($t_time){
     	global $wpdb;
     	return $wpdb->get_var($wpdb->prepare( '
     		SELECT
     			COUNT(P.ID) AS total
     		FROM
     			'.$wpdb->prefix.'posts P
     		WHERE 
     			UNIX_TIMESTAMP(P.post_date)>%d
     			AND P.post_status = \'publish\'
     	',$t_time));
     }
     public static function getPostsFromTime($t_time, $t_start=0, $t_limit=10, $t_sortBy = 'post_date', $t_sortDirection='ASC'){
     	global $wpdb;
     	if($t_sortBy != 'post_date' && $t_sortBy != 'post_modified'){
     		$t_sortBy = 'post_date';
     	}
     	if($t_sortDirection != 'ASC' && $t_sortDirection != 'DESC'){
     		$t_sortDirection = 'ASC';
     	}
     	return $wpdb->get_results($wpdb->prepare( '
     		SELECT
     			P.ID,
     			P.post_title,
     			P.post_date,
     			P.post_modified,
     			UNIX_TIMESTAMP(P.post_date) AS post_date_u,
     			UNIX_TIMESTAMP(P.post_modified) AS post_modified_u
     		FROM
     			'.$wpdb->prefix.'posts P
     		WHERE
     			UNIX_TIMESTAMP(P.post_modified)>%d
     			AND P.post_status = \'publish\'
     		ORDER BY '.$t_sortBy.' '.$t_sortDirection.'
     	     LIMIT '.$t_start.','.$t_limit.'
     	', $t_time));
     }
     public static function getPostIdStirngFromTime($t_time, $t_start=0, $t_limit=10,$t_sortBy ="post_date", $t_sortDirection = "ASC" ){
     	global $wpdb;
     	if($t_sortBy != 'post_date' && $t_sortBy != 'post_modified'){
     		$t_sortBy = 'post_date';
     	}
     	if($t_sortDirection != 'ASC' && $t_sortDirection != 'DESC'){
     		$t_sortDirection = 'ASC';
     	}
     	
     	return $wpdb->get_var($wpdb->prepare( '
     		SELECT
     			GROUP_CONCAT(P.ID)
     		FROM
     			'.$wpdb->prefix.'posts P
     		WHERE
     			UNIX_TIMESTAMP(P.'.$t_sortBy.')>%d
     			AND P.post_status = \'publish\'
     			ORDER BY '.$t_sortBy.' '.$t_sortDirection.'
     		LIMIT '.$t_start.','.$t_limit.'
     	', $t_time));
     }
     public static function getPostsWithIds($t_ids, $t_start=0, $t_limit=10, $t_sortBy ='post_date', $t_sortDirection='ASC'){
     	global $wpdb;
     	if($t_sortBy != 'post_date' && $t_sortBy != 'post_modified'){
     		$t_sortBy = 'post_date';
     	}
     	if($t_sortDirection != 'ASC' && $t_sortDirection != 'DESC'){
     		$t_sortDirection = 'ASC';
     	}
     	if(!EmiSlider::$Controller->_checkIdString($t_ids)){
     		$t_ids = '0';
     	}
     	return $wpdb->get_results('
     		SELECT
     			P.ID,
     			P.post_title,
     			P.post_date,
     			P.post_modified,
     			UNIX_TIMESTAMP(P.post_date) AS post_date_u,
     			UNIX_TIMESTAMP(P.post_modified) AS post_modified_u
     		FROM
     			'.$wpdb->prefix.'posts P
     		WHERE
     			P.post_status = \'publish\'
     			AND P.ID IN ('.$t_ids.')
     		ORDER BY '.$t_sortBy.' '.$t_sortDirection.'
     		LIMIT '.$t_start.','.$t_limit.'
     	');
     }
}

?>