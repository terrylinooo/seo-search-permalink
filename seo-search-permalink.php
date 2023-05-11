<?php
/**
 * Plugin Name: SEO Search Permalink
 * Plugin URI:  https://github.com/terrylinooo/seo-search-permalink
 * Description: Change default search URLs to the SEO friendly URLs. It may improve your SERP to boost your site traffic. The default URL ?s=keyword will be changed to /search/keyword, and you could change the {search base} for your needs.
 * Version:     1.0.3
 * Author:      Terry Lin
 * Author URI:  https://terryl.in/
 * License:     GPL 3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain: seo-search-permalink
 * Domain Path: /languages
 */

/**
 * Any issues, or would like to request a feature, please visit.
 * https://github.com/terrylinooo/seo-search-permalink/issues
 *
 * Welcome to contribute your code here:
 * https://github.com/terrylinooo/seo-search-permalink
 *
 * Thanks for using SEO Search Permalink!
 * Star it, fork it, share it if you like this plugin.
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Assign default setting values while activating SSP.
 */
function ssp_admin_activation() {
	add_option( 'ssp_permalink', '' );
	add_option( 'ssp_letter_type_option', '1' );
	add_option( 'ssp_filter_words', '' );
	add_option( 'ssp_filter_character_option', '1' );
	add_option( 'ssp_separate_symbol_option', '1' );
}

// Activating plugin.
register_activation_hook( plugin_dir_path( __FILE__ ), 'ssp_admin_activation' );

/**
 * Register the plugin setting page.
 */
function ssp_admin_option_hook() {

	if ( function_exists( 'add_options_page' ) ) {
		add_options_page(
			__( 'SEO Search Permalink', 'ssp-plugin' ),
			__( 'SEO Search Permalink', 'ssp-plugin' ),
			'manage_options',
			'seo-search-permalink.php',
			'ssp_administrator_page'
		);
	}
}

// Load SSP settings.
$ssp_settings = array(
	'ssp_permalink'               => get_option( 'ssp_permalink' ),
	'ssp_filter_words'            => get_option( 'ssp_filter_words' ),
	'ssp_filter_character_option' => get_option( 'ssp_filter_character_option' ),
	'ssp_separate_symbol_option'  => get_option( 'ssp_separate_symbol_option' ),
	'ssp_letter_type_option'      => get_option( 'ssp_letter_type_option' ),
);

/**
 * Update SSP settings.
 *
 * @return void
 */
function ssp_init() {

	load_plugin_textdomain( 'seo-search-permalink', false, basename( dirname( __FILE__ ) ) . '/languages' );

	// Only load SSP setting page in admin panel.
	if ( is_admin() ) {
		require_once plugin_dir_path( __FILE__ ) . 'inc/setting.php';

		// Detect form submitting in setting page.
		ssp_update_form_options();
	}

	// Load SSP functions.
	require_once plugin_dir_path( __FILE__ ) . 'inc/functions.php';

	// The magical things are happened here.
	add_filter( 'search_rewrite_rules', 'ssp_change_search_permalink' );
	add_action( 'admin_menu', 'ssp_admin_option_hook' );
	add_action( 'template_redirect', 'ssp_search_redirect' );
	add_action( 'pre_get_posts', 'ssp_keep_structure' );
}

add_action( 'init', 'ssp_init' );
