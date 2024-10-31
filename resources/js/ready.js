/*
* EMI: emi.code.tm@gmail.com; 
* http://emicode.wordpress.com
*/
jQuery(document).ready(function( ) {
	(function(){
		var $emiSlider = jQuery('#referenceEmiSlider');
		var $toggle = $emiSlider.find('.selectorToggle');
		var $totalBox = $emiSlider.find('.selectorTotalBox');
		var fnToggle = function(t_callback){
			
			var callback = t_callback || function(){};
			if($emiSlider.height()==15){
				$emiSlider.animate({
					width:EmiSliderBox.width,
					height:EmiSliderBox.height
				},500,function(){
					$toggle.html('-');
					callback();
				});		
			}
			else{
				$emiSlider.animate({
					width:45,
					height:15
				},500,function(){
					$toggle.html('+');
					callback();
				});
			}
		}
		$toggle.click(function(){fnToggle()});
		$totalBox.click(function(){fnToggle()});
	
		if(EmiSliderBox.totalMissedPosts>0 && EmiSliderBox.splashAnimation){
			window.setTimeout(function(){
				$emiSlider.animate({
					right:100
				},600,function(){
					$emiSlider.animate({
						right:10
					},200,function(){
						fnToggle(function(){fnToggle(fnToggle)});
					});
				});
			},500);
		}
		else{
			$emiSlider.animate({
				right:10
			},1);
		}
	})();
});
