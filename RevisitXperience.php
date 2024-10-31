<?php
/**
Plugin Name: Revisit Xperience Lite
Plugin URI: http://revisitxperience.com
Description: The plugin that automatically updates the reader what was posted after his last visit!
Version: 1.0.0
Author: UltraCool Plugins
Author URI: http://revisitxperience.com
License: Copyright Nicusor Prefac  (email : nino@revisitxperience.com)
*/
?>
<?php
register_activation_hook(  __FILE__  ,'rx_activation_process');

if (!class_exists('Mustache')) {
	require_once plugin_dir_path(__FILE__) . '/lib/Mustache.php';
}

require_once(plugin_dir_path(__FILE__) . '/db.php');
require_once(plugin_dir_path(__FILE__) . '/objects/Visitor.php') ;
require_once(plugin_dir_path(__FILE__) . '/controller.php');
require_once(plugin_dir_path(__FILE__) . '/view.php');

class EmiSlider{
	public static $Controller;
	public static $View;
	public static $DB;
	public static $options;
	public static $pluginUrl;
	public static $pluginPath;
	public static $Visitor;
	public static $Template;
	public static function init() {
		

		register_deactivation_hook(  __FILE__ , 'EmiSlider::deactivation' ) ;
		register_uninstall_hook( __FILE__, 'EmiSlider::uninstall' );
		
		add_action('init', 'EmiSlider::load');
		add_action( 'admin_init', 'EmiSlider::adminInit' );
		add_action( 'admin_menu', 'emiSlider::addMenu' );

		add_action('wp_footer', 'EmiSlider::_footer');
		add_action('wp', 'EmiSlider::_wp' );
		
		self::$Visitor = new Visitor();
		self::$Controller = new EmiSlider_Controller();
		self::$DB = new EmiSlider_DB;
		self::$Template = new Mustache();
		self::$View = new EmiSlider_View();
		self::$options = get_option( 'emiSlider' );
	}
	public static function activation(){
		include plugin_dir_path( __FILE__ ).'setup/activation.php';
	}
	public static function deactivation(){
		include plugin_dir_path( __FILE__ ).'setup/deactivation.php';
	}
	public static function uninstall(){
		include plugin_dir_path( __FILE__ ).'setup/uninstall.php';
	}
	public static function load() {
		global $current_user;
		$lang_loaded = load_plugin_textdomain( 'EmiSlider', FALSE, basename( dirname( __FILE__ ) ) . '/languages' );
		self::$pluginUrl = WP_PLUGIN_URL . '/' . plugin_basename( dirname( __FILE__ ) );
		self::$pluginPath = dirname( __FILE__ );
		if(!is_admin()){
			wp_enqueue_style( 'emiSlider__resources_css_style', self::$pluginUrl . '/resources/css/style.css' );
			wp_enqueue_script("jquery");
			wp_enqueue_script( 'emiSlider__resources_js_ready', self::$pluginUrl . '/resources/js/ready.js', array( 'jquery'));
		}
		self::$Controller->initializeVisitor();
	}
	public static function _wp(){
		self::$Controller->finalizeVisitor();
	}
	public static function _footer($t_content){
		self::$View->slider(self::$Controller->slider()).$t_content;
	}
	public static function adminInit( ) {
		register_setting( 'emiSlider_option_group', 'emiSlider' );
	}
	public static function addMenu( ) {
		add_options_page( __( 'Revisit Xperience Options', 'emiSlider' ), __( 'Revisit Xperience Lite', 'emiSlider' ), 'manage_options', 'emiSlider', 'EmiSlider::adminOptions' );
	}
	public static function adminOptions( ) {
		self::$View->adminOptions(self::$Controller->adminOptions());
	}
}

/** Activation process */

function rx_activation_process(){
    if(function_exists('revisitxperience_pro_init_process')) {
        deactivate_plugins( plugin_basename( __FILE__ ) );
        wp_die( __( 'Already installed Revisit Xperience Pro Plugin on your site. After deactivate older plugin, please re-activate.', 'emiSlider' ) );
    }

    include plugin_dir_path( __FILE__ ).'setup/activation.php';
}

/**
 * Plugin entry point Process
 * */

add_action( 'revisitxperience_init', 'revisitxperience_init_process' );

function revisitxperience_init_process() {
    EmiSlider::init();
}

do_action( 'revisitxperience_init' );

?>