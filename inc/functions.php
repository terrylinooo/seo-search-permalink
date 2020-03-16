<?php
/**
 * SEO Search Permalink (SSP)
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.0.0
 * @version 1.0.2
 */

/**
 * Replace the search permallink.
 *
 * @param array $search_rewrite
 * @return string
 */
function ssp_change_search_permalink( $search_rewrite ) {
	global $ssp_settings;
	
	if( ! is_array( $search_rewrite ) ) {
		return $search_rewrite;
	}

	$new_rewrite = array();

	foreach ( $search_rewrite as $pattern => $s ) {
		$regex = str_replace( 'search/', "$ssp_settings[ssp_permalink]/", $pattern );
		$new_rewrite[$regex] = $s;
	}

	$search_rewrite = $new_rewrite;

	unset( $new_rewrite );

	return $search_rewrite;
}

/**
 * Redirect the search query to the new search permallink URL.
 */
function ssp_search_redirect() {
	global $wp_rewrite, $ssp_settings;

	if (   ! isset( $wp_rewrite ) 
		|| ! is_object( $wp_rewrite ) 
		|| ! $wp_rewrite->using_permalinks() 
		|| ! isset( $_SERVER['REQUEST_URI'] ) 
		|| '' === $ssp_settings['ssp_permalink'] 
	) {
		return;
	}

	$search_base = $wp_rewrite->search_base;

	if ( is_search() && ! is_admin() && false === strpos( $_SERVER['REQUEST_URI'], "/$ssp_settings[ssp_permalink]/" ) ) {
		$search_query_vars = ssp_filter_spec_chars( get_query_var('s') );
		$search_query_vars = ssp_filter_bad_words( $search_query_vars );

		switch ( $ssp_settings['ssp_separate_symbol_option'] ) {
			case 1: $search_query_vars = str_replace( ' ', '+', $search_query_vars ); break;
			case 2: $search_query_vars = str_replace( ' ', '-', $search_query_vars ); break;
			case 3: $search_query_vars = str_replace( ' ', '/', $search_query_vars ); break;
			case 4: $search_query_vars = str_replace( ' ', '_', $search_query_vars ); break;
		}
		if ( 2 === $ssp_settings['ssp_letter_type_option'] ) {
			$search_query_vars = strtolower( $search_query_vars );
		}
		wp_redirect( home_url( "/$ssp_settings[ssp_permalink]/" . $search_query_vars ) );
		exit();
	}
}

/**
 * Keep search structure.
 * 
 * @param $object $query
 */
function ssp_keep_structure( $query ) {
	global $wp_query;

	if ( $query->get('s') && empty( $_GET['s'] ) && $wp_query->is_main_query() ) {

		$s_vars_tmp          = urldecode( $query->get('s') );
		$ssp_separate_symbol = array( '/', '_', '+', '-' );
		$s_vars_tmp          = str_replace( $ssp_separate_symbol, ' ', $s_vars_tmp );

		$query->set( 's', $s_vars_tmp );
	}
}

/**
 * Remove unwanted characters.
 *
 * @param string $query_strings
 * @return string
 */
function ssp_filter_spec_chars($query_strings) {
	global $ssp_settings;
	
	if ( $ssp_settings['ssp_filter_character_option'] == 2 ) {
		$query_strings = rawurldecode($query_strings);
		$ssp_unwanted_characters = array( '"', "'", '[', ']', '~', '=', ',', '*', '&', '^', '$', '#', '@', '!', '<', '>', ';', '.', '|', '/', '+', '-', '_' );
	
		if ( is_array( $ssp_unwanted_characters ) ) {
			$query_strings = trim( str_replace( $ssp_unwanted_characters, ' ', $query_strings ) );
		}
	}

	return $query_strings;
}

/**
 * Remove bad words.
 *
 * @param string $query_strings
 * @return string
 */
function ssp_filter_bad_words( $query_strings ) {
	global $ssp_settings;

	if ( '' !== $ssp_settings['ssp_filter_words'] ) {
		$ssp_bad_words = explode( ',', $ssp_settings['ssp_filter_words'] );
		$query_strings = str_replace( $ssp_bad_words, ' ', $query_strings );
	}
	$query_strings = preg_replace( '/\s{2,}/', ' ', $query_strings );

	return $query_strings;
}
