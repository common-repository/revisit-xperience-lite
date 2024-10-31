<?php
/**
 * EMI: emi.code.tm@gmail.com;
 * http://emicode.wordpress.com
 */
?>
<?php
class EmiSlider_View{
	protected static $instance;
	public static function singleton() {
		if (! isset ( self::$instance )) {
			$c = __CLASS__;
			self::$instance = new $c ( );
		}
		return self::$instance;
	}

	public static function adminOptions($fnControl){
		require_once 'templates/adminOptions.php';
	}
	public static function slider($t_data) {
		if( is_home() && !EmiSlider::$options['showInHomepage']){
			return;
		}
		echo EmiSlider::$Template->render(file_get_contents(dirname(__FILE__) . '/templates/slider.html'), $t_data);
		
	}
}

?>