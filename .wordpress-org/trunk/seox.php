<?php
/**
 * Plugin Name: SEO X
 * Plugin URI: https://wordpress.org/plugins/seox
 * Description: SEO X is a very light SEO plugin.
 * Version: 1.0.1
 * Author: VISER X Limited
 * Author URI: https://viserx.com/
 * Requires at least: 5.0
 * Tested up to: 6.1
 * Requires PHP: 7.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: seox
 * Domain Path: /languages
 */

defined( 'ABSPATH' ) || exit;

// Plugin Basename 
define( 'SEOX_BASENAME', basename( dirname( __FILE__ ) ));

// Plugin Path
define( 'SEOX_PATH', plugin_dir_path( __FILE__ ) );

// Plugin URL
define( 'SEOX_URL', plugins_url( '' , __FILE__ ));

/**
 * Load Textdomain
 * Load Plugin Localization files.
 */
if( ! function_exists( 'seox_i10n' ) ){
    function seox_i10n(){
        load_plugin_textdomain( 'seox', false, SEOX_BASENAME . '/languages' );
    }
    add_action( 'plugins_loaded', 'seox_i10n' );
}

/**
 * Enqueue style & scripts
 */
function seox_assets(){
    wp_enqueue_style( 'seox', SEOX_URL . '/assets/css/style.css', null, time(), 'all');

    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'seox', SEOX_URL . '/assets/js/main.js', array( 'jquery' ), time(), true );
}
add_action( 'admin_enqueue_scripts', 'seox_assets' );

/**
 * Create Database table
 */
function seox_create_table(){
    global $wpdb;

    $seox_table_name = $wpdb->prefix . 'seox_redirects';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $seox_table_name (
        id int(11) NOT NULL AUTO_INCREMENT,
        url_source text NOT NULL,
        url_to text NOT NULL,
        status varchar(25) NOT NULL DEFAULT 'active',
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
add_action( 'init', 'seox_create_table' );

/**
 * Create new field into Database
 */
function seox_options(){
    $seox_dashboard_data = [
        '404'                   =>  '',
        'schema'                =>  '',
        'sitemap'               =>  '',
    ];

    $seox_option_data = array(
        'baidu'         =>  '',
        'bing'          =>  '',
        'google'        =>  '',
        'yandex'        =>  '',
        'analytics'     =>  '',
        'adsense'       =>  '',
    );

    $seox_ihf_data = [
        'header'    =>  '',
        'body'      =>  '',
        'footer'    =>  ''
    ];
    add_option( 'seox', $seox_option_data, '', 'yes' );
    add_option( 'seox-dashboard', $seox_dashboard_data, '', 'yes' );
    add_option( 'seox-ihf', $seox_ihf_data, '', 'yes' );
}

/**
 * Activate the plugin.
 */
function seox_activate() { 
    // Create Database table on plugin activation
    seox_create_table();
    // Create options field
    seox_options();
}
register_activation_hook( __FILE__, 'seox_activate' );

/**
 * Register Menu
 */
if( ! function_exists( 'seox_menu' ) ){
    function seox_menu(){
        /**
         * Register Main Menu
         */
        add_menu_page( __('SEO X', 'seox'), __('SEO X', 'seox'), 'manage_options', 'seox-dashboard', 'seox_dashboard_callback', SEOX_URL . '/assets/images/seox.svg', 99 );
        /**
         * Register Submenu
         */
        add_submenu_page( 'seox-dashboard', __('General', 'seox'), __('General', 'seox'), 'manage_options', 'seox-dashboard', 'seox_general_dashboard_callback', null );
        add_submenu_page( 'seox-dashboard', __('Redirects', 'seox'), __('Redirects', 'seox'), 'manage_options', 'seox-redirects', 'seox_redirects_dashboard_callback', null );
        add_submenu_page( 'seox-dashboard', __('Tools', 'seox'), __('Tools', 'seox'), 'manage_options', 'seox-tools', 'seox_tools_dashboard_callback', null );
    }
    add_action( 'admin_menu', 'seox_menu');
}

/**
 * Include 
 */
if ( ! class_exists( 'seox_list_table' ) ) {
    require_once( SEOX_PATH . '/inc/class-seox-list-table.php' );
}

/**
 * Redirect functions
 */
require_once ( SEOX_PATH . '/inc/seox-redirects-functions.php' );

/**
 * Include dashboard admin pages
 */
require_once( SEOX_PATH . '/inc/dashboard.php' );

/**
 * Webmaster Tools Data Display
 */
require_once( SEOX_PATH . '/inc/webmaster-tools.php' );

/**
 * Analytics Tools Data Display
 */
require_once( SEOX_PATH . '/inc/analytics-tools.php' );

/**
 * Insert Header Footer Data Display
 */
require_once( SEOX_PATH . '/inc/insert-header-footer.php' );

/**
 * Functions
 */
require_once( SEOX_PATH . '/inc/functions.php' );

/**
 * Codestar framework
 */
require_once( SEOX_PATH . '/lib/codestar-framework/codestar-framework.php' );
require_once( SEOX_PATH . '/admin/metabox/metabox.php' );
require_once( SEOX_PATH . '/admin/metabox/metabox-display.php' );

/**
 * Initialize the plugin tracker
 *
 * @return void
 */
function appsero_init_tracker_seo_x() {

    if ( ! class_exists( 'Appsero\Client' ) ) {
      require_once __DIR__ . '/lib/appsero/src/Client.php';
    }

    $client = new Appsero\Client( '5c725893-1c9d-41fa-a94e-f0fab5ccdda8', 'SEO X', __FILE__ );

    // Active insights
    $client->insights()->init();

}
appsero_init_tracker_seo_x();