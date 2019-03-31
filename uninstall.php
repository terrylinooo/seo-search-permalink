<?php
/**
 * SEO Search Permalink (SSP)
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.0.0
 * @version 1.0.0
 */

// if uninstall.php is not called by WordPress, die.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

$options_names = array(
	'ssp_permalink',
	'ssp_letter_type_option',
	'ssp_filter_words',
	'ssp_filter_character_option',
	'ssp_separate_symbol_option',
);

foreach ( $options_names as $option_name ) {
	delete_option( $option_name );
	delete_site_option( $option_name );
}
