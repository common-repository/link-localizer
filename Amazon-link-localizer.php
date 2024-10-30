<?php
/*
    Plugin Name: Amazon Link Localizer
    Plugin URI: https://www.prourls.com
    Description:  Amazon Link Localizer plugin allows you to convert all your Amazon links on Wordpress site to specific country link with your affiliate IDs in it. Once installed the plugin automatically detects the location of visitors and take them to their respective country’s Amazon storefronts (eg: a UK visitor to amazon.co.uk and US visitor to amazon.com).  
    Version: 1.6
    Author: Prourls Ltd
    Author URI: https://www.prourls.com
*/

// Checking version
global $wp_version;

if(!version_compare($wp_version, '3.0', '>='))
{
    die("Amazon Link Localizer extension requires WordPress 3.0 or above. <a href='http://codex.wordpress.org/Upgrading_WordPress'>Please update!</a>");
}
// END - Version check

//wordpress bug http://core.trac.wordpress.org/ticket/16953
$AmazonLinkLocalizer_file = __FILE__; 

if ( isset( $mu_plugin ) ) { 
    $AmazonLinkLocalizer_file = $mu_plugin; 
} 
if ( isset( $network_plugin ) ) { 
    $AmazonLinkLocalizer_file = $network_plugin; 
} 
if ( isset( $plugin ) ) { 
    $AmazonLinkLocalizer_file = $plugin; 
} 

$GLOBALS['AmazonLinkLocalizer_file'] = $AmazonLinkLocalizer_file;


if(!class_exists('AmazonLinkLocalizer')) :

    class AmazonLinkLocalizerWidget extends WP_Widget {
        function AmazonLinkLocalizerWidget() {
            parent::WP_Widget(false, 'AmazonLinkLocalizer Widget', array('description' => 'Description'));
        }

        function widget($args, $instance) {
            echo '<div id="AmazonLinkLocalizer_widget"></div>';
        }

        function update( $new_instance, $old_instance ) {
            return parent::update($new_instance, $old_instance);
        }

        function form( $instance ) {
            return parent::form($instance);
        }
    }

    function AmazonLinkLocalizer_widget_register_widgets() {
        register_widget('AmazonLinkLocalizerWidget');
    }

    class AmazonLinkLocalizer				
    {
        
        private $plugin_id;		
       
        private $options;		

        public function __construct($id)
        {

            $this->plugin_id = $id;           

            $this->options = array();         
           
            /*
            * Add Hooks
            */
            register_activation_hook(__FILE__, array(&$this, 'install'));  			
			
			
			//Run on every page
			add_action('wp_head', array(&$this, 'amazonLinkLocalizerScript'));	

            add_action('admin_init', array(&$this, 'init'));						

            add_action('admin_menu', array(&$this, 'menu'));						

            add_action('widgets_init', 'amazonLinkLocalizer_widget_register_widgets');			
           
        }

        /** function/method
        * Usage: return plugin options
        * Arg(0): null
        * Return: array
        */
        private function get_options()
        {
            $options = get_option($this->plugin_id);        
            return $options;
        }
        /** function/method
        * Usage: update plugin options
        * Arg(0): null
        * Return: void
        */
        private function update_options($options=array())
        {
            update_option($this->plugin_id, $options);          
        }

        /** function/method
        * Usage: helper for loading Prourls.js
        * Arg(0): null
        * Return: void
        */
        public function amazonLinkLocalizerScript()
        {
        	$options = $this->get_options();
            $api_key = trim($options['api_key']);
            $domain = trim($options['domain']);
            if($api_key == null) {$api_key = '3ea36f4a0db1c09a953cd19cf5cfc2d0';}
            if($domain == null) $domain = 'http://www.prourls.co/';
			$prourlsJS = '';
	  				$prourlsJS .= "<script type = \"text/javascript\">";
	  				$prourlsJS .= "var _prourls = _prourls || {};";
	  				$prourlsJS .= "_prourls['variables'] = {
			   					api_key : '".$api_key."',
			   					domain	  : '". $domain ."'
		   						};";
					$prourlsJS .= "var ss = document.createElement('script');ss.src = 'https://www.prourls.com/prourls_js/prourls.js'
						   ss.type = 'text/javascript';ss.setAttribute('defer', '');ss.setAttribute('id', 'prourls-js');var s = document.getElementsByTagName('head')[0];s.appendChild(ss);";
					$prourlsJS.="</script>";
			echo $prourlsJS;
        }
        public function install()
        {
            $this->update_options($this->options);
        }
        

        public function init()
        {
            register_setting($this->plugin_id.'_options', $this->plugin_id);
        }
                
        /** function/method
        * Usage: show options/settings form page
        * Arg(0): null
        * Return: void
        */
        public function options_page()
        {
            if (!current_user_can('manage_options'))
            {
                wp_die( __('You can manage options from the Settings->AmazonLinkLocalizer Options menu.') );
            }


            $options = $this->get_options();            
            $updated = false;

            if (!isset($options['enable_rewards'])) {
                $options['enable_rewards'] = 1;
                $updated = true;
            }

            if ($updated) {
                $this->update_options($options);
            }
            include('Amazon-link-localizer_options.php');
        }
 
        public function menu()
        {
            add_options_page('AmazonLinkLocalizer Options', 'Amazon Link Localizer', 'manage_options', $this->plugin_id.'-plugin', array(&$this, 'options_page'));
        }
    }


    $AmazonLinkLocalizer = new AmazonLinkLocalizer('AmazonLinkLocalizer');    


endif;			
?>
