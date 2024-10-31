<?php
class Visitor{
     protected $userId=0;
     protected $uniqId=FALSE;
     protected $ip;
     protected $firstVisitTime;
     protected $lastVisitTime;
     protected $isFirstVisit = false;
     protected $missedPosts="";
     protected $totalMissedPosts=0;
     private   $_arMissedPosts=array();
     function __construct(){
          $this->ip=getenv('REMOTE_ADDR');
     }
     public function getIp(){
     	return $this->ip;
     }
     public function setUserId($t_id){
          $this->userId=$t_id;
     }
     public function getUserId(){
          return $this->userId;
     }
     public function setUniqId($t_id){
     	$this->uniqId=$t_id;
     }
     public function getUniqId(){
     	return $this->uniqId;
     }
     public function setFirstVisitTime($t_time){
     	$this->firstVisitTime=$t_time;
     }
     public function getFirstVisitTime(){
     	return $this->firstVisitTime;
     }
     public function setLastVisitTime($t_time){
     	$this->lastVisitTime=$t_time;
     }
     public function getLastVisitTime(){
     	return $this->lastVisitTime;
     }
     public function setIsFirstVisit($t_control){
     	$this->isFirstVisit=$t_control;
     }
     public function isFirstVisit(){
     	return $this->isFirstVisit;
     }
     public function setMissedPosts($t_ids, $t_updateArray = true){
     	$this->missedPosts=$t_ids;
     	if($t_updateArray){
     		if(strlen(trim($this->missedPosts))>0){
     			$this->_arMissedPosts = explode(',',$this->missedPosts);
     		}
     		else{
     			$this->_arMissedPosts = array();
     		}
     	}
     	$this->setTotalMissedPosts(count($this->_arMissedPosts));
     	
     }
     public function getMissedPosts(){
     	return $this->missedPosts;
     }
     public function setTotalMissedPosts($t_count){
     	$this->totalMissedPosts=$t_count;
     }
     public function getTotalMissedPosts(){
     	return $this->totalMissedPosts;
     }
     public function removeMissedPost($t_id){
     	$tempSearchResult = array_search($t_id, $this->_arMissedPosts);
     	
     	if($tempSearchResult !== FALSE){
     	
     		unset($this->_arMissedPosts[$tempSearchResult]);
     		$this->setTotalMissedPosts(count($this->_arMissedPosts));
     		$this->setMissedPosts(implode(',',$this->_arMissedPosts),false);
     		return true;
     	} 
     	return false;
     }
     public function toJson(){
          $tempObj = new stdClass();
          $tempObj->userId=$this->userId;
          $tempObj->uniqId=$this->uniqId;
          $tempObj->firstVisitTime=$this->firstVisitTime;
          $tempObj->lastVisitTime=$this->lastVisitTime;
          $tempObj->missedPosts=$this->missedPosts;
          return json_encode($tempObj);
     }
}
?>