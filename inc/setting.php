<?php
/**
 * SEO Search Permalink (SSP)
 *
 * @author Terry Lin
 * @link https://terryl.in/
 * @since 1.0.0
 * @version 1.0.0
 */

/**
 * Message block 1
 */
function ssp_message_one() { ?>
	<div id="message" class="updated fade">
		<p>
			<?php $url_html = '<a href="' . get_bloginfo( 'url' ) . '/wp-admin/options-permalink.php">' . __( 'Permalink Setting', 'seo-search-permalink' ) . '</a>'; ?>
			<?php _e( 'You has updated the <strong>search permalink</strong> successfully', 'seo-search-permalink' ); ?><br />
			<?php printf( __( 'You have to go %s page and click on "Save Changes" button to take effect.', 'seo-search-permalink' ), $url_html ); ?>
		</p>
	</div><?php
}

/**
 * Message block 2
 */
function ssp_message_two() { ?>
	<div id="message" class="updated fade">
		<p><?php _e( 'You has updated the <strong>search permalink</strong> successfully', 'seo-search-permalink' ); ?></p>
	</div><?php
}

/**
 * Update setting page.
 */
function ssp_update_form_options() {
	global $ssp_settings;

	if ( current_user_can( 'manage_options' ) ) {

		// Form section 1.
		if ( isset( $_POST['submit_ssp_permalink'] ) && check_admin_referer( 'check_form_section_1', 'ssp_form_section_1' ) ) {
			update_option('ssp_permalink', sanitize_text_field( $_POST['ssp_permalink'] ) );

			add_action( 'admin_notices', 'ssp_message_one' );
		}
		
		// Form section 2.
		if ( isset( $_POST['submit_general_settings'] ) && check_admin_referer( 'check_form_section_2', 'ssp_form_section_2' ) ) {

			if ( ! empty( $_POST['ssp_separate_symbol_option'] ) ) {
				$ssp_separate_symbol_option = $_POST['ssp_separate_symbol_option'];

				switch ( $ssp_separate_symbol_option ) {
					case '1':
					case '2':
					case '3':
					case '4':
						update_option( 'ssp_separate_symbol_option', $ssp_separate_symbol_option );
						break;
					default:
						break;
				}
			}

			if ( ! empty( $_POST['ssp_filter_character_option'] ) ) {
				$ssp_filter_character_option = $_POST['ssp_filter_character_option'];

				switch ( $ssp_filter_character_option ) {
					case '1':
					case '2':
						update_option( 'ssp_filter_character_option', $ssp_filter_character_option );
						break;
					default:
						break;
				}
			}
			
			if ( ! empty( $_POST['ssp_letter_type_option'] ) ) {
				$ssp_letter_type_option = $_POST['ssp_letter_type_option'];

				switch ( $ssp_letter_type_option ) {
					case '1':
					case '2':
						update_option( 'ssp_letter_type_option', $ssp_letter_type_option );
						break;
					default:
						break;
				}
			}

			if ( ! empty( $_POST['ssp_filter_words'] ) ) {
				update_option( 'ssp_filter_words', sanitize_text_field( $_POST['ssp_filter_words'] ) );
			}

			add_action( 'admin_notices', 'ssp_message_two' );
		}

		$ssp_settings = array(
			'ssp_permalink'               => get_option( 'ssp_permalink' ),
			'ssp_filter_words'            => get_option( 'ssp_filter_words' ),
			'ssp_filter_character_option' => get_option( 'ssp_filter_character_option' ),
			'ssp_separate_symbol_option'  => get_option( 'ssp_separate_symbol_option' ),
			'ssp_letter_type_option'      => get_option( 'ssp_letter_type_option' )
		);
	}
}

/**
 * Display setting page.
 */
function ssp_administrator_page() {
	ssp_print_admin_page_header();
	ssp_print_admin_page_main();
	ssp_print_admin_page_footer();
}

/**
 * Display donation section.
 */
function ssp_admin_donate(){
?>
	<div style="text-align: center;">
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
			<input name="cmd" value="_donations" type="hidden" />
			<input name="business" value="donate@terryl.in" type="hidden" />
			<input name="item_name" value="<?php esc_attr_e( __( 'Donation for SEO Search Permalink plugin', 'seo-search-permalink' ) ); ?>" type="hidden" />
			<input name="item_number" value="seo-search-permalink" type="hidden" />
			<select name="currency_code" value="USD">
				<option value="USD" selected>USD</option>
			</select>
			<select name="amount" value="4.65">
				<option value="4.65" selected>4.65 (<?php esc_attr_e( __( 'Caffe Mocha', 'seo-search-permalink' ) ); ?> x 1)</option>
				<option value="46.5">46.5 (<?php esc_attr_e( __( 'Caffe Mocha', 'seo-search-permalink' ) ); ?> x 10)</option>
				<option value="460">460 (<?php esc_attr_e( __( 'Caffe Mocha', 'seo-search-permalink' ) ); ?> x 100)</option>
			</select>
			<input name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest" type="hidden" />
			<p>
				<input src="https://www.paypal.com/en_US/GB/i/btn/btn_donateCC_LG.gif" name="submit" alt="<?php esc_attr_e( __( 'Donate with PayPal', 'seo-search-permalink' ) ); ?>" style="border: medium none; background: none repeat scroll 0% 0% transparent;" type="image" style="border: 0" />
				<img alt="" src="https://www.paypal.com/en_US/i/scr/pixel.gif" style="border:0;height:1px;width:1px" />
			</p>
		</form>
	</div>
	<?php
}

/**
 * Setting page: header.
 */
function ssp_print_admin_page_header() {
	
	$baseurl = 'options-general.php?page=' . basename( plugin_basename( __FILE__ ) );

	?>

	<style>
	.ssp-flex { display: flex; }
	.ssp-right { width: 320px; }
	.ssp-table { margin: 14px; font-size: 13px; } 
	.ssp-table tr { height: 28px; } 
	.ssp-table td { line-height: 175%; }
	.inside p { margin: 14px; font-size: 13px; } 
	.inside .frame { margin: 10px; } 
	.inside .list li { font-size: 11px; }
	.ssp-table { width: 100%; } 
	.ssp-table2 { background-color: #ddd; font-size: 13px; width: 90%; } 
	.ssp-table2 td { background-color: #fff; border: 0; padding: 10px; } 
	.ssp-label { font-weight: 600; }
	.ssp-code-inline { background-color: #f1f1f1; padding: 5px; }
	.ssp-radio-label { font-size: 16px; font-weight: 600; background-color: #f1f1f1; padding: 3px 6px; border: 1px #dddddd solid; width: 30px; display: inline-block; text-align: center; }
	.donate-note a { text-decoration: none; }
	.hr { width: 100%; height: 1px; border-bottom: 1px solid #ddd; }
	</style>

	<div class="wrap">
		<h2><?php echo __( 'SEO Search Permalink', 'seo-search-permalink' ); ?></h2>
	<?php 
}

/**
 * Setting page: footer.
 */
function ssp_print_admin_page_footer() {
	?>
	</div><!--.wrap -->

	<?php
}

/**
 * Print setting sections.
 */
function ssp_print_admin_page_main() { 
	global $ssp_settings;

	$string_from = '<code class="ssp-code-inline"><b>/?s=<span style="color:red">query</span></b></code>';
	$string_to   = '<code class="ssp-code-inline"><b>/search/<span style="color:red">query</span></b></code>';

?>	
	<div class="postbox-container ssp-flex" style="width: 100%;">
		<div class="metabox-holder ssp-left">
			<div class="meta-box-sortables ui-sortable">    		
				<div id="stm-settings" class="postbox">
					<div class="handlediv" title="Click to toggle">
						<br/>
					</div>
					<h3 class="hndle"><span><?php _e( 'Permalink Settings', 'seo-search-permalink' ); ?></span></h3>
					<div class="inside">
						<form id="ssp-options" method="post" action="">
							<?php wp_nonce_field( 'check_form_section_1', 'ssp_form_section_1' ); ?>
							<table class="ssp-table">
								<tr>
									<td width="25%" class="ssp-label">
										<?php _e( 'Search Base', 'seo-search-permalink' ); ?>
									</td>
									<td width="75%">
										<p>
											<?php printf( __( 'After you have activated this plugin, the search permalink will be changed from %1$s to %2$s.', 'seo-search-permalink' ), $string_from, $string_to ); ?><br />
											<?php _e( 'If you want yo change the search base, please fill in the field with the new one. Keeping this field blank will apply the default.', 'seo-search-permalink' ); ?>
										</p>
										<input type="text" value="<?php if ( $ssp_settings['ssp_permalink'] != '' ) { echo $ssp_settings['ssp_permalink']; }; ?>" size="20" name="ssp_permalink" />
										<span class="submit" style="margin-top: 14px;">
											<input class="button-primary" type = "submit" name="submit_ssp_permalink" value="<?php _e( 'Save Changes', 'seo-search-permalink' ); ?>" />
										</span>
									</td>
								</tr>
							</table>
						</form>
					</div>
				</div>
			</div>

			<div class="meta-box-sortables ui-sortable">
				<div id="stm-settings" class="postbox">
					<h3 class="hndle"><span><?php _e( 'General Settings', 'seo-search-permalink' ); ?></span></h3>
					<div class="inside">
						<form id="ssp-options2" method="post" action="">
							<?php wp_nonce_field( 'check_form_section_2', 'ssp_form_section_2' ); ?>
							<table class="ssp-table">
								<tr>
									<td width="25%" class="ssp-label">
										<?php _e( 'Letter type', 'seo-search-permalink' ); ?>
									</td>
									<td width="75%">
										<input name="ssp_letter_type_option" type="radio" value="1" <?php checked( $ssp_settings['ssp_letter_type_option'], '1' ); ?>  /> <?php _e( 'No change (default)', 'seo-search-permalink' ); ?>&nbsp;&nbsp;&nbsp;
										<input name="ssp_letter_type_option" type="radio" value="2" <?php checked( $ssp_settings['ssp_letter_type_option'], '2' ); ?>  /> <?php _e( 'Lowercase letters', 'seo-search-permalink' ); ?>
									</td>
								</tr>
							</table>
							<div class="hr"></div>
							<table class="ssp-table">
								<tr>
									<td width="25%" class="ssp-label">
										<?php _e( 'Separation symbol', 'seo-search-permalink' ); ?>
									</td>
									<td width="75%">
										<table class="ssp-table2" cellspacing="1" cellpadding="5" width="100%">
											<tr>
												<td width="33%">
													<input id="ssp-radio-1" name="ssp_separate_symbol_option" type="radio" value="1" <?php checked( $ssp_settings['ssp_separate_symbol_option'], '1' ); ?>  /> <label class="ssp-radio-label" for="ssp-radio-1">+</label> (default)
												</td>
												<td width="67%">
													<?php _e( 'e.g.', 'seo-search-permalink' ); ?> <code class="ssp-code-inline">/search/how+are+you</code>
												</td>
											</tr>
											<tr>
												<td width="33%">
													<input id="ssp-radio-2" name="ssp_separate_symbol_option" type="radio" value="2" <?php checked( $ssp_settings['ssp_separate_symbol_option'], '2' ); ?>  /> <label class="ssp-radio-label" for="ssp-radio-2">-</label>
												</td>
												<td width="67%">
													<?php _e( 'e.g.', 'seo-search-permalink' ); ?> <code class="ssp-code-inline">/search/how-are-you</code><br />
												</td>
											</tr>
											<tr>
												<td width="33%">
													<input id="ssp-radio-3" name="ssp_separate_symbol_option" type="radio" value="3" <?php checked( $ssp_settings['ssp_separate_symbol_option'], '3' ); ?> /> <label class="ssp-radio-label" for="ssp-radio-3">/</label>
												</td>
												<td width="67%">
													<?php _e( 'e.g.', 'seo-search-permalink' ); ?> <code class="ssp-code-inline">/search/how/are/you</code>
												</td>
											</tr>
											<tr>
												<td width="33%">
													<input id="ssp-radio-4" name="ssp_separate_symbol_option" type="radio" value="4" <?php checked( $ssp_settings['ssp_separate_symbol_option'], '4' ); ?> /> <label class="ssp-radio-label" for="ssp-radio-4">_</label>
												</td>
												<td width="67%">
													<?php _e( 'e.g.', 'seo-search-permalink' ); ?> <code class="ssp-code-inline">/search/how_are_you</code>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td></td>
									<td colspan="3">
										<p>
											<?php _e( '<b>Note</b>: It is not recommended to use "backward slash" if you need pagination in search result page. It will cause the pagination not working.', 'seo-search-permalink' ); ?>
										</p>
									</td>
								</tr>
							</table>
							<div class="hr"></div>
							<table class="ssp-table">
								<tr>
									<td width="25%" class="ssp-label">
										<?php _e( 'Unwanted special character filtering', 'seo-search-permalink' ); ?>
									</td>
									<td width="75%">
										<table class="ssp-table2" cellspacing="1" cellpadding="5">
											<tr>
												<td width="50%">
													<input name="ssp_filter_character_option" type="radio" value="1" <?php checked( $ssp_settings['ssp_filter_character_option'], '1' ); ?> /> (default)
												</td>
												<td width="50%">
													<input name="ssp_filter_character_option" type="radio" value="2" <?php checked( $ssp_settings['ssp_filter_character_option'], '2' ); ?>  /> (recommended)
												</td>
											</tr>
											<tr>
												<td width="50%">
													<?php _e( 'Accept all characters.', 'seo-search-permalink' ); ?>
												</td>
												<td width="50%">
													<?php _e( 'Remove all special characters.', 'seo-search-permalink' ); ?><br />
													<?php _e( 'e.g.', 'seo-search-permalink' ); ?> <code class="ssp-code-inline">"'[]/\_+-~=,*&^%$#@!;.!?|</code>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
							<div class="hr"></div>
							<table class="ssp-table">
								<tr>
									<td width="25%" class="ssp-label">
										<?php _e( 'Bad words filtering', 'seo-search-permalink' ); ?>
									</td>
									<td width="75%">
										<p><?php _e( 'Enter the words you want to remove from search, separate them with a comma. ( e.g.: keyword_1,keyword_2,keyword_3 )', 'seo-search-permalink' ); ?></p>
										<p><?php _e( 'For example, an user submit a search term "Taiwan is a keyword_1 beautiful country" that includes "keyword_1", after filtering, the search term will be "Taiwan is a beautiful country".', 'seo-search-permalink' ); ?></p>
										<textarea name="ssp_filter_words" cols="75" rows="3"><?php echo $ssp_settings['ssp_filter_words']; ?></textarea>
									</td>
								</tr>
							</table>
							<table class="ssp-table">
								<tr>
									<td style="text-align: center">
										<span class="submit">
											<input class="button-primary" type="submit" name="submit_general_settings" value="<?php _e( 'Save Changes', 'seo-search-permalink' ); ?>" />
										</span>
									</td>
								</tr>
							</table>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="metabox-holder ssp-flex ssp-right">
			<div class="meta-box-sortables ui-sortable">
				<div id="ssp-donate" class="postbox">
					<h3 class="hndle"><span><?php _e( 'Donation', 'seo-search-permalink' ); ?></span></h3>
					<div class="inside">
						<p><?php _e( 'If you think this plugin is useful to you, buy me a coffee.', 'seo-search-permalink' ); ?></p>
						<div class="frame list">
							<?php echo ssp_admin_donate(); ?>
						</div>
						<ol class="donate-note">
							<li><?php printf( __( 'Top 5 donators, including their names or company name and URLs, will be listed on <a href="%s">my homepage</a>.', 'seo-search-permalink' ), 'https://terryl.in/'); ?></li>
							<li><?php printf( __( 'All donators will be listed on  <a href="%s">Thank You</a> page.', 'seo-search-permalink' ), 'https://terryl.in/thank-you/'); ?></li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div style="clear:both"></div>

<?php
}
