<?php
/*
Plugin Name: ClientFlow
Plugin URI: http://themes.tradesouthwest.com/wordpress/plugins/clientflow
Description: Email Form from custom post type to handle new website client information.
Version: 0.1.0
Author: tradesouthwest
Author URI: http://tradesouthwest.com/
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
WordPress Available:  yes
Requires License:    no
*/
if ( ! function_exists( 'add_action' ) ) {
	die( 'Nothing to see here...' );
}
/* Important constants */
define( 'CLFL_VERSION', '0.1.0' );
define( 'CLFL_FORMS_URL', plugin_dir_url( __FILE__ ) );

//activate/deactivate hooks
function clientflow_plugin_activation() {

return false;
}

function clientflow_plugin_deactivation() {

    clfl_delete_post_type();
    add_action('init','clfl_delete_post_type');
    //flush_rewrite_rules();
        return false;
}

function clfl_delete_post_type(){
    unregister_post_type( 'clfl_client' );
}

/**
 * Include loadable plugin files
 */
// Initialise - load in translations
function clientflow_loadtranslations () {
    $plugin_dir = basename(dirname(__FILE__)).'/languages';
    load_plugin_textdomain( 'clientflow', false, $plugin_dir );
}
add_action('plugins_loaded', 'clientflow_loadtranslations');


/**
 * Plugin Scripts
 *
 * Register and Enqueues plugin scripts
 *
 * @since 0.0.1
 */
function clientflow_scripts() {

    // Register Scripts
    wp_register_script( 'clientflow', plugins_url(
                        'js/clientflow.js', __FILE__ ), array( 'jquery' ), true );
    // Register Styles
    wp_register_style( 'clientflow-style', CLFL_FORMS_URL . 'css/clientflow-style.css' );

    wp_enqueue_style( 'clientflow-style' );
    wp_enqueue_script( 'clientflow' );
   /* wp_enqueue_script( 'clientflowajax', get_template_directory_uri().'/js/clientflowajax.js',
                        array('jquery') );
    //ajax form submit
    wp_localize_script( 'clientflowajax.js', 'clflFormJSObject', array(
                        'ajaxUrl' => admin_url( 'admin-ajax.php' ) //url to process ajax request to WP
                        ) ); */
}
add_action( 'wp_enqueue_scripts', 'clientflow_scripts' );

register_activation_hook( __FILE__, 'clientflow_plugin_activation');
register_deactivation_hook( __FILE__, 'clientflow_plugin_deactivation');

//include admin and public views
//require ( plugin_dir_path( __FILE__ ) . 'inc/clientflow-posttype-client.php' );
require ( plugin_dir_path( __FILE__ ) . 'inc/clientflow-adminpage.php' );
require ( plugin_dir_path( __FILE__ ) . 'inc/clientflow-formpage.php' );
?>
