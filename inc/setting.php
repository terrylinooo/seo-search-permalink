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
			<?php $url_html = '<a href="' . get_bloginfo( 'url' ) . '/wp-admin/options-permalink.php">' . __( 'Permalink Setting', 'ssp_plugin' ) . '</a>'; ?>
			<?php _e( 'You has updated the <strong>search permalink</strong> successfully', 'ssp_plugin' ); ?><br />
			<?php printf( __( 'You have to go %s page and click on "Save Changes" button to take effect.', 'ssp_plugin' ), $url_html ); ?>
		</p>
	</div><?php
}

/**
 * Message block 2
 */
function ssp_message_two() { ?>
	<div id="message" class="updated fade">
		<p><?php _e( 'You has updated the <strong>search permalink</strong> successfully', 'ssp_plugin' ); ?></p>
	</div><?php
}

/**
 * Update setting page.
 */
function ssp_update_form_options() {

	if ( isset( $_POST['submit_ssp_permalink'] ) ) {
		update_option('ssp_permalink', $_POST['ssp_permalink']);

		add_action( 'admin_notices', 'ssp_message_one' );
	}

	if ( isset( $_POST['submit_general_settings'] ) ) {
		update_option( 'ssp_separate_symbol_option',  $_POST['ssp_separate_symbol_option'] );
		update_option( 'ssp_filter_character_option', $_POST['ssp_filter_character_option'] );
		update_option( 'ssp_filter_words',            $_POST['ssp_filter_words'] );
		update_option( 'ssp_letter_type_option',      $_POST['ssp_letter_type_option'] );

		add_action( 'admin_notices', 'ssp_message_two' );
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
			<input name="business" value="terrylin412@gmail.com" type="hidden" />
			<input name="item_name" value="<?php _e( 'Donation for SEO Search Permalink plugin', 'ssp_plugin' ); ?>" type="hidden" />
			<input name="item_number" value="wp-admin" type="hidden" />
			<select name="currency_code" value="USD">
				<option value="AUD">AUD</option>
				<option value="EUR">EUR</option>
				<option value="GBP">GBP</option>
				<option value="USD" selected>USD</option>
			</select>
			<select name="amount" value="5">
				<option value="5" selected>5</option>
				<option value="10">10</option>
				<option value="15">15</option>
				<option value="20">20</option>
				<option value="25">25</option>
				<option value="50">50</option>
				<option value="99">99</option>
			</select>
			<input name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest" type="hidden" />
			<p>
				<input src="https://www.paypal.com/en_US/GB/i/btn/btn_donateCC_LG.gif" name="submit" alt="<?php echo esc_attr( __( 'Donate with PayPal', 'ssp_plugin' ) ); ?>" style="border: medium none; background: none repeat scroll 0% 0% transparent;" type="image" style="border: 0" />
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
		<div class="icon32" id="icon-options-general"><br></div>
		<h2><?php echo __( 'SEO Search Permalink', 'ssp_plugin' ); ?></h2>
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
					<h3 class="hndle"><span><?php _e( 'Permalink Settings', 'ssp_plugin' ); ?></span></h3>
					<div class="inside">
						<form id="ssp-options" method="post" action="">
							<table class="ssp-table">
								<tr>
									<td width="25%" class="ssp-label">
										<?php _e( 'Search Base', 'ssp_plugin' ); ?>
									</td>
									<td width="75%">
										<p>
											<?php printf( __( 'After you have activated this plugin, the search permalink will be changed from %1$s to %2$s.', 'ssp_plugin' ), $string_from, $string_to ); ?><br />
											<?php _e( 'If you want yo change the search base, please fill in the field with the new one. Keeping this field blank will apply the default.', 'ssp_plugin' ); ?>
										</p>
										<input type="text" value="<?php if ( $ssp_settings['ssp_permalink'] != '' ) { echo $ssp_settings['ssp_permalink']; }; ?>" size="20" name="ssp_permalink" />
										<span class="submit" style="margin-top: 14px;">
											<input class="button-primary" type = "submit" name="submit_ssp_permalink" value="<?php _e( 'Save Changes', 'ssp_plugin' ); ?>" />
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
					<h3 class="hndle"><span><?php _e( 'General Settings', 'ssp_plugin' ); ?></span></h3>
					<div class="inside">
						<form id="ssp-options2" method="post" action="">
							<table class="ssp-table">
								<tr>
									<td width="25%" class="ssp-label">
										<?php _e( 'Letter type', 'ssp_plugin' ); ?>
									</td>
									<td width="75%">
										<input name="ssp_letter_type_option" type="radio" value="1" <?php checked( $ssp_settings['ssp_letter_type_option'], 1 ); ?>  /> <?php _e( 'No change (default)', 'ssp_plugin' ); ?>&nbsp;&nbsp;&nbsp;
										<input name="ssp_letter_type_option" type="radio" value="2" <?php checked( $ssp_settings['ssp_letter_type_option'], 2 ); ?>  /> <?php _e( 'Lowercase letters', 'ssp_plugin' ); ?>
									</td>
								</tr>
							</table>
							<div class="hr"></div>
							<table class="ssp-table">
								<tr>
									<td width="25%" class="ssp-label">
										<?php _e( 'Separation symbol', 'ssp_plugin' ); ?>
									</td>
									<td width="75%">
										<table class="ssp-table2" cellspacing="1" cellpadding="5" width="100%">
											<tr>
												<td width="33%">
													<input id="ssp-radio-1" name="ssp_separate_symbol_option" type="radio" value="1" <?php checked( $ssp_settings['ssp_separate_symbol_option'], 1 ); ?>  /> <label class="ssp-radio-label" for="ssp-radio-1">+</label> (default)
												</td>
												<td width="67%">
													<?php _e( 'e.g.', 'ssp_plugin' ); ?> <code class="ssp-code-inline">/search/how+are+you</code>
												</td>
											</tr>
											<tr>
												<td width="33%">
													<input id="ssp-radio-2" name="ssp_separate_symbol_option" type="radio" value="2" <?php checked( $ssp_settings['ssp_separate_symbol_option'], 2 ); ?>  /> <label class="ssp-radio-label" for="ssp-radio-2">-</label>
												</td>
												<td width="67%">
													<?php _e( 'e.g.', 'ssp_plugin' ); ?> <code class="ssp-code-inline">/search/how-are-you</code><br />
												</td>
											</tr>
											<tr>
												<td width="33%">
													<input id="ssp-radio-3" name="ssp_separate_symbol_option" type="radio" value="3" <?php checked( $ssp_settings['ssp_letter_type_option'], 3 ); ?> /> <label class="ssp-radio-label" for="ssp-radio-3">/</label>
												</td>
												<td width="67%">
													<?php _e( 'e.g.', 'ssp_plugin' ); ?> <code class="ssp-code-inline">/search/how/are/you</code>
												</td>
											</tr>
											<tr>
												<td width="33%">
													<input id="ssp-radio-4" name="ssp_separate_symbol_option" type="radio" value="4" <?php checked( $ssp_settings['ssp_letter_type_option'], 4 ); ?> /> <label class="ssp-radio-label" for="ssp-radio-4">_</label>
												</td>
												<td width="67%">
													<?php _e( 'e.g.', 'ssp_plugin' ); ?> <code class="ssp-code-inline">/search/how_are_you</code>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td></td>
									<td colspan="3">
										<p>
											<?php _e( '<b>Note</b>: It is not recommended to use "backward slash" if you need pagination in search result page. It will cause the pagination not working.', 'ssp_plugin' ); ?>
										</p>
									</td>
								</tr>
							</table>
							<div class="hr"></div>
							<table class="ssp-table">
								<tr>
									<td width="25%" class="ssp-label">
										<?php _e( 'Unwanted special character filtering', 'ssp_plugin' ); ?>
									</td>
									<td width="75%">
										<table class="ssp-table2" cellspacing="1" cellpadding="5">
											<tr>
												<td width="50%">
													<input name="ssp_filter_character_option" type="radio" value="1" <?php checked( $ssp_settings['ssp_filter_character_option'], 1 ); ?> /> (default)
												</td>
												<td width="50%">
													<input name="ssp_filter_character_option" type="radio" value="2" <?php checked( $ssp_settings['ssp_filter_character_option'], 2 ); ?>  /> (recommended)
												</td>
											</tr>
											<tr>
												<td width="50%">
													<?php _e( 'Accept all characters.', 'ssp_plugin' ); ?>
												</td>
												<td width="50%">
													<?php _e( 'Remove all special characters.', 'ssp_plugin' ); ?><br />
													<?php _e( 'e.g.', 'ssp_plugin' ); ?> <code class="ssp-code-inline">"'[]/\_+-~=,*&^%$#@!;.!?|</code>
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
										<?php _e( 'Bad words filtering', 'ssp_plugin' ); ?>
									</td>
									<td width="75%">
										<p><?php _e( 'Enter the words you want to remove from search, separate them with a comma. ( e.g.: keyword_1,keyword_2,keyword_3 )', 'ssp_plugin' ); ?></p>
										<p><?php _e( 'For example, an user submit a search term "Taiwan is a keyword_1 beautiful country" that includes "keyword_1", after filtering, the search term will be "Taiwan is a beautiful country".', 'ssp_plugin' ); ?></p>
										<textarea name="ssp_filter_words" cols="75" rows="3"><?php echo $ssp_settings['ssp_filter_words']; ?></textarea>
									</td>
								</tr>
							</table>
							<table class="ssp-table">
								<tr>
									<td style="text-align: center">
										<span class="submit">
											<input class="button-primary" type="submit" name="submit_general_settings" value="<?php _e( 'Save Changes', 'ssp_plugin' ); ?>" />
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
					<h3 class="hndle"><span><?php _e( 'Donation', 'ssp_plugin' ); ?></span></h3>
					<div class="inside">
						<p><?php _e( 'If you think this plugin is useful to you, buy me a coffee.', 'ssp_plugin' ); ?></p>
						<div class="frame list">
							<?php echo ssp_admin_donate(); ?>
						</div>
						<ol class="donate-note">
							<li><?php printf( __( 'Top 5 donators, including their names or company name and URLs, will be listed on <a href="%s">my homepage</a>.', 'ssp_plugin' ), 'https://terryl.in/'); ?></li>
							<li><?php printf( __( 'All donators will be listed on  <a href="%s">Thank You</a> page.', 'ssp_plugin' ), 'https://terryl.in/thank-you/'); ?></li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div style="clear:both"></div>

<?php
}
