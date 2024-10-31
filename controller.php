<?php
/**
 * EMI: emi.code.tm@gmail.com;
 * http://emicode.wordpress.com
*/
?>
<?php 
class EmiSlider_Controller{
	protected static $instance;
	public static function singleton() {
		if (! isset ( self::$instance )) {
			$c = __CLASS__;
			self::$instance = new $c ( );
		}
		return self::$instance;
	}
	public static function shotText($t_text, $t_count) {
		if(strlen($t_text)>$t_count){
			$t_text = substr($t_text, 0,$t_count-3).'...';
		}
		return $t_text;
	}
	public static function adminOptions(){
		$fnControl = new stdClass;
		$fnControl->options = get_option('emiSlider');
		return $fnControl;
	}
	public static function _checkIdString($t_ids){
		if(preg_match('/[^0-9\,]/',$t_ids) === 1){
			return false;
		}
		return true;
	}
	public static function initializeVisitor(){
		global $current_user;
	
		$fnControl = new stdClass;
		$fnControl->sortBy = EmiSlider::$options['sortBy'];
		$fnControl->sortDirection = EmiSlider::$options['sortDirection'];
		if($current_user->ID>0){
			
			EmiSlider::$Visitor->setUserId($current_user->ID);
			$tempUserRow = EmiSlider::$DB->getUser(EmiSlider::$Visitor->getUserId());

			if(isset($tempUserRow->user_id)){
				EmiSlider::$Visitor->setFirstVisitTime($tempUserRow->first_visit_time);
				EmiSlider::$Visitor->setLastVisitTime($tempUserRow->last_visit_time);
				EmiSlider::$Visitor->setMissedPosts($tempUserRow->missed_posts);
			}
			else{
				EmiSlider::$Visitor->setFirstVisitTime(time());
				EmiSlider::$Visitor->setLastVisitTime(time());				
			}
			
			if(time()-EmiSlider::$Visitor->getLastVisitTime()>intval(EmiSlider::$options['activityTimeRange'])*60){
				
				EmiSlider::$Visitor->setFirstVisitTime(EmiSlider::$Visitor->getLastVisitTime());
				EmiSlider::$Visitor->setMissedPosts(EmiSlider::$DB->getPostIdStirngFromTime(EmiSlider::$Visitor->getFirstVisitTime(),0,190, $fnControl->sortBy, $fnControl->sortDirection));
				
				EmiSlider::$DB->updateFirstVisitTime(EmiSlider::$Visitor->getUserId(),EmiSlider::$Visitor->getMissedPosts());
				EmiSlider::$Visitor->setIsFirstVisit(true);
			}
			
			EmiSlider::$DB->insertUser(EmiSlider::$Visitor->getUserId());
			
		}
		else{
			if(isset($_COOKIE['emiSlider'])){
				$tempUserObject = json_decode(base64_decode($_COOKIE['emiSlider']));
			
				if(isset($tempUserObject->uniqId) && isset($tempUserObject->missedPosts)){
					if( self::_checkIdString($tempUserObject->missedPosts)){
						EmiSlider::$Visitor->setUniqId($tempUserObject->uniqId);
						EmiSlider::$Visitor->setFirstVisitTime($tempUserObject->firstVisitTime);
						EmiSlider::$Visitor->setLastVisitTime($tempUserObject->lastVisitTime);
						EmiSlider::$Visitor->setMissedPosts($tempUserObject->missedPosts);
					}
					else{
						/*
							invalid cookie input
						*/
					}
				}	
			}
			
			if(EmiSlider::$Visitor->getUniqId() == FALSE){
				EmiSlider::$Visitor->setUniqId(uniqid());
				EmiSlider::$Visitor->setFirstVisitTime(time());
				EmiSlider::$Visitor->setLastVisitTime(time());
			}
			if(time()-EmiSlider::$Visitor->getLastVisitTime()>intval(EmiSlider::$options['activityTimeRange'])*60){
				EmiSlider::$Visitor->setFirstVisitTime(EmiSlider::$Visitor->getLastVisitTime());
				EmiSlider::$Visitor->setMissedPosts(EmiSlider::$DB->getPostIdStirngFromTime(EmiSlider::$Visitor->getFirstVisitTime(),0,190, $fnControl->sortBy, $fnControl->sortDirection));
				EmiSlider::$Visitor->setIsFirstVisit(true);
			}
			EmiSlider::$Visitor->setLastVisitTime(time());
			
			setcookie("emiSlider", base64_encode(EmiSlider::$Visitor->toJson()), time()+intval(EmiSlider::$options['activityTimeRange'])*24*60*60, COOKIEPATH, COOKIE_DOMAIN, false, true);
		}
	
		
	}
	public static function finalizeVisitor(){
		global $post;

		$fnControl->removed = false;
		if(!is_home() && isset($post->ID) && intval($post->ID>0)){
			$fnControl->removed = EmiSlider::$Visitor->removeMissedPost($post->ID);
		}
		
		if(EmiSlider::$Visitor->getUserId()>0){
			if($fnControl->removed){
				EmiSlider::$DB->updateMissedPosts(EmiSlider::$Visitor->getUserId(),EmiSlider::$Visitor->getMissedPosts());
			}
		}
		else{
			setcookie("emiSlider", base64_encode(EmiSlider::$Visitor->toJson()), time()+intval(EmiSlider::$options['activityTimeRange'])*24*60*60, COOKIEPATH, COOKIE_DOMAIN, false, true);
		}
	}
	public static function slider(){
	 
		$fnControl = new stdClass;
		$fnControl->maxPostInList = intVal(EmiSlider::$options['maxPostInList']);
		$fnControl->maxTitleLength = intVal(EmiSlider::$options['maxTitleLength']);
		$fnControl->sortBy = EmiSlider::$options['sortBy'];
		$fnControl->sortDirection = EmiSlider::$options['sortDirection'];
		
		$fnControl->result = new stdClass;
		
		$fnControl->result->boxWidth = intVal(EmiSlider::$options['boxWidth']);
		$fnControl->result->boxHeight = intVal(EmiSlider::$options['boxHeight']);
		$fnControl->result->boxInnerHeight = intVal(EmiSlider::$options['boxHeight'])-30;
        $fnControl->result->boxNoPostText = EmiSlider::$options['boxNoPostText'];

		$fnControl->result->boxTitle = EmiSlider::$options['boxTitle'];
		$fnControl->customLinkUrl = EmiSlider::$options['customLinkUrl'];
		$fnControl->customLinkName = EmiSlider::$options['customLinkName'];
		$fnControl->splashAnimation = EmiSlider::$options['splashAnimation'];
		
		$fnControl->result->splashAnimation = 1;
		switch ($fnControl->splashAnimation){
			case 1:
				$fnControl->result->splashAnimation = 1;
			break;
			case 2:
				if(EmiSlider::$Visitor->isFirstVisit()){
					$fnControl->result->splashAnimation = 1;
				}
				else{
					$fnControl->result->splashAnimation = 0;
				}
			break;
			case 0:
				$fnControl->result->splashAnimation = 0;
			break;
			default:
				$fnControl->result->splashAnimation = 1;
			break;
		}

		$fnControl->result->customLink = false;
		if(strlen($fnControl->customLinkUrl)>0 && strlen($fnControl->customLinkName)>0){
			$fnControl->result->customLink = '<a href="'.$fnControl->customLinkUrl.'">'.$fnControl->customLinkName.'</a>';
		}
		
		$tempArPosts = array();
		$fnControl->result->totalMissedPosts = EmiSlider::$Visitor->getTotalMissedPosts();
		if(strlen(trim(EmiSlider::$Visitor->getMissedPosts()))>0){
			if($fnControl->result->totalMissedPosts>0){
				$fnControl->posts = EmiSlider::$DB->getPostsWithIds(EmiSlider::$Visitor->getMissedPosts(),0,$fnControl->maxPostInList, $fnControl->sortBy, $fnControl->sortDirection);
				foreach ($fnControl->posts as $ePost){
					$tempPost = new stdClass();
					$tempPost->title=self::shotText($ePost->post_title,$fnControl->maxTitleLength);
					$tempPost->link=get_permalink($ePost->ID);
					$tempPost->date=$ePost->post_date;
					$tempPost->modified=$ePost->post_modified;
					$tempPost->dateHuman=human_time_diff($ePost->post_date_u);
					$tempPost->modifiedHuman=human_time_diff($ePost->post_modified_u);
				
					array_push($tempArPosts, $tempPost);
				}
			}
		}
		$fnControl->result->posts = $tempArPosts;
		
		return $fnControl->result;
	}
}
?>