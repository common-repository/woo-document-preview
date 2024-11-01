<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wbcomdesigns.com
 * @since      1.0.0
 *
 * @package    wc-document-preview
 * @subpackage wc-document-preview/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wbcom-tab-content">      
	<div class="wbcom-faq-adming-setting">
		<div class="wbcom-admin-title-section">
			<h3><?php esc_html_e( 'Have some questions?', 'wc-document-preview' ); ?></h3>
		</div>

		<div class="wbcom-faq-admin-settings-block">
			<div id="wbcom-faq-settings-section" class="wbcom-faq-table">
				<div class="wbcom-faq-section-row">
					<div class="wbcom-faq-admin-row">
						<button class="wbcom-faq-accordion">
							<?php esc_html_e( 'Does This plugin requires Woocommerce?', 'wc-document-preview' ); ?>
						</button>
						<div class="wbcom-faq-panel">
							<p> 
								<?php esc_html_e( 'Yes, It needs you to have Woocommerce installed and activated.', 'wc-document-preview' ); ?>
							</p>
						</div>
					</div>
				</div>
				<div class="wbcom-faq-section-row">
					<div class="wbcom-faq-admin-row">
						<button class="wbcom-faq-accordion">
							<?php esc_html_e( 'Can We download the preview file?', 'wc-document-preview' ); ?>
						</button>
						<div class="wbcom-faq-panel">
							<p> 
								<?php esc_html_e( 'Yes Preview file is downloadable', 'wc-document-preview' ); ?>     
							</p>
						</div>
					</div>
				</div>
				<div class="wbcom-faq-section-row">
					<div class="wbcom-faq-admin-row">
						<button class="wbcom-faq-accordion">
							<?php esc_html_e( 'Can multiple files be uploaded to preview?', 'wc-document-preview' ); ?>
						</button>
						<div class="wbcom-faq-panel">
							<p> 
								<?php esc_html_e( 'Yes plugin provides a feature to upload multiple preview Files', 'wc-document-preview' ); ?>    
							</p>
						</div>
					</div>
				</div>
				<div class="wbcom-faq-section-row">
					<div class="wbcom-faq-admin-row">
						<button class="wbcom-faq-accordion">
							<?php esc_html_e( 'What if I need more features?', 'wc-document-preview' ); ?>
						</button>
						<div class="wbcom-faq-panel">
							<p> 
								<?php esc_html_e( 'You can hire our team to assist you.', 'wc-document-preview' ); ?>    
							</p>
						</div>
					</div>
				</div>
				<div class="wbcom-faq-section-row">
					<div class="wbcom-faq-admin-row">
						<button class="wbcom-faq-accordion">
							<?php esc_html_e( 'What if I have a question?', 'wc-document-preview' ); ?>
						</button>
						<div class="wbcom-faq-panel">

						<?php
						$contatct_page = '<a href="https://wbcomdesigns.com/contact/">contact page</a>';
						?>
							<p> 
								<?php esc_html_e( 'No problem. Please get in touch with us via our', 'wc-document-preview' ); ?>   
								<a href="https://wbcomdesigns.com/contact/" target="_blank"><?php echo esc_html( 'contact page.' ); ?></a> 
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

