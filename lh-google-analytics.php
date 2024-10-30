<?php
/**
 * Plugin Name: LH Google Analytics
 * Plugin URI: https://lhero.org/portfolio/lh-google-analytics/
 * Description: Add google analytics unobtrusively
 * Version: 1.03
 * Author: Peter Shaw
 * Author URI: https://shawfactor.com/
 * Text Domain: lh_google_analytics
 * Domain Path: /languages
 * Tags: UTM, analytics, google, tracking
*/


if (!class_exists('LH_Google_analytics_plugin')) {


class LH_Google_analytics_plugin {


var $namespace = 'lh_google_analytics';
var $opt_name = 'lh_google_analytics-options';
var $filename;
var $options;

private static $instance;



 /**
     * Helper function for registering and enqueueing scripts and styles.
     *
     * @name    The    ID to register with WordPress
     * @file_path        The path to the actual file
     * @is_script        Optional argument for if the incoming file_path is a JavaScript source file.
     */
    protected function load_file( $name, $file_path, $is_script = false, $deps = array(), $in_footer = true, $atts = array() ) {
        $url  = plugins_url( $file_path, __FILE__ );
        $file = plugin_dir_path( __FILE__ ) . $file_path;
        if ( file_exists( $file ) ) {
            if ( $is_script ) {
                wp_register_script( $name, $url, $deps, filemtime($file), $in_footer ); 
                wp_enqueue_script( $name );
            }
            else {
                wp_register_style( $name, $url, $deps, filemtime($file) );
                wp_enqueue_style( $name );
            } // end if
        } // end if
	  
	  if (isset($atts) and is_array($atts) and isset($is_script)){
		
		
  $atts = array_filter($atts);

if (!empty($atts)) {

  $this->script_atts[$name] = $atts; 
  
}

		  
	 add_filter( 'script_loader_tag', function ( $tag, $handle ) {
	   

	   
if (isset($this->script_atts[$handle][0]) and !empty($this->script_atts[$handle][0])){
  
$atts = $this->script_atts[$handle];

$implode = implode(" ", $atts);
  
unset($this->script_atts[$handle]);

return str_replace( ' src', ' '.$implode.' src', $tag );

unset($atts);
usent($implode);

		 

	 } else {
	   
 return $tag;	   
	   
	   
	 }
	

}, 10, 2 );
 

	
	  
	}
		
    } // end load_file
  
    
    
    
public function plugin_menu() {
    
   
add_options_page( __('LH Google Analytics', $this->namespace ), __('Google Analytics', $this->namespace ), 'manage_options', $this->filename, array($this,"plugin_options"));


}



public function plugin_options() {

if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}

if( isset($_POST[ $this->namespace."-nonce" ]) && wp_verify_nonce($_POST[ $this->namespace."-nonce" ], $this->namespace."-nonce" )) {
    


if (isset($_POST[$this->namespace.'-tracking_codes']) and ($_POST[$this->namespace.'-tracking_codes'] != "")){
    
    
    $pieces = explode(",", wp_kses(trim($_POST[$this->namespace.'-tracking_codes'])));
    
    $result = array_map('trim', $pieces);
    
    
$options[$this->namespace.'-tracking_codes'] = $result;
}
    
    
    
  
if (update_option( $this->opt_name, $options )){

$this->options = get_option($this->opt_name);

?>
<div class="updated"><p><strong><?php _e('Values saved', $this->namespace ); ?></strong></p></div>
<?php


}  
    
    
    
    
    
} 
    
// Now display the settings screen
include ('partials/option-settings.php');
    
    

    
    

}

    
    
private function register_scripts_and_styles() {

if (!is_admin()){

$array = array('defer="defer"');


$tracking_codes = apply_filters( 'lh_google_analytics_tracking_codes_filter', $this->options[$this->namespace.'-tracking_codes']);

if (is_array($tracking_codes)){
    
 $tracking_codes =  implode(",", $tracking_codes);  
    
}

$array[] = 'data-tracking_codes="'.$tracking_codes.'"';


if (is_user_logged_in()){
    
 $array[] = 'data-user_id="'.get_current_user_id().'"';   
    
}

// include the add-to-home-screen-js library
$this->load_file( 'lh-google-analytics-js', '/scripts/lh-google-analytics.js',   true, array(), true, $array);

}


}


public function general_init() {
  
          // Load JavaScript and stylesheets
        $this->register_scripts_and_styles();
  
  

}
    

    /**
     * Gets an instance of our plugin.
     *
     * using the singleton pattern
     */
    public static function get_instance(){
        if (null === self::$instance) {
            self::$instance = new self();
        }
 
        return self::$instance;
    }
    
    

public function __construct() {
    
/* Initialize the plugin */
$this->filename = plugin_basename( __FILE__ );
$this->options = get_option($this->opt_name);

/* Add menu */
add_action('admin_menu', array($this, 'plugin_menu'));

    
//register required styles and scripts
add_action('init', array($this,"general_init"));
    
}


}

$lh_google_analytics_instance = LH_Google_analytics_plugin::get_instance();


}

?>