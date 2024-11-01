<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wbcomdesigns.com
 * @since      1.0.0
 *
 * @package    Woo_Document_Preview
 * @subpackage Woo_Document_Preview/admin/partials
 */
?>
<div class="wbcom-tab-content woo-document-pro">
	<div class="wbcom-welcome-main-wrapper">
		<div class="wbcom-admin-title-section">
			<h3><?php esc_html_e( 'General Settings', 'wc-document-preview' ); ?></h3>
		</div>
		<div class="wbcom-admin-option-wrap wbcom-admin-option-wrap-view">
			<form method="post" action="options.php">
				<?php do_action( 'wcdp_pro_admin_options_before' ); ?>
				<div class="form-table">
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="wcdp-pro-tab">
								<?php esc_html_e( 'Preview Button Display Position', 'wc-document-preview' ); ?>
							</label>
						</div>
						<div class="wbcom-settings-section-options">
							<label class="wcdp-pro-switch">
								<select id="wcdp-pro-btn-display-position" name="wcdp_pro_admin_general_option[preview_button_display_position]" disabled>
									<option><?php esc_html_e( 'Before Add to cart Button', 'wc-document-preview' ); ?></option>
									<option><?php esc_html_e( 'After Add to cart Button', 'wc-document-preview' ); ?></option>
								</select>
								<div class="wcdp-pro bupr-round"></div>
							</label>
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Preview Button Text Color', 'wc-document-preview' ); ?>
							</label>
						</div>
						<div class="wbcom-settings-section-options">
							<input type="color" name="wcdp_pro_admin_general_option[preview_button_text_color]" value="" disabled>
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Preview Button Hover Text Color', 'wc-document-preview' ); ?>
							</label>
						</div>
						<div class="wbcom-settings-section-options">
							<input type="color" name="wcdp_pro_admin_general_option[preview_button_hover_text_color]" value="" disabled>
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Preview Button Background Color', 'wc-document-preview' ); ?>
							</label>
						</div>
						<div class="wbcom-settings-section-options">
							<input type="color" name="wcdp_pro_admin_general_option[preview_button_bg_color]" value="" disabled>
						</div>
					</div>
					<div class="wbcom-settings-section-wrap">
						<div class="wbcom-settings-section-options-heading">
							<label for="blogname">
								<?php esc_html_e( 'Preview Button Hover Background Color', 'wc-document-preview' ); ?>
							</label>
						</div>
						<div class="wbcom-settings-section-options">
							<input type="color" name="wcdp_pro_admin_general_option[preview_button_hover_bg_color]" value="" disabled>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
