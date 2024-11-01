<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://wbcomdesigns.com
 * @since      1.0.0
 *
 * @package    Wc_Document_Preview
 * @subpackage Wc_Document_Preview/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wc_Document_Preview
 * @subpackage Wc_Document_Preview/admin
 * @author     Wbcom Designs <admin@wbcomdesigns.com>
 */
class Wc_Document_Preview_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wc_Document_Preview_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wc_Document_Preview_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wc-document-preview-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wc_Document_Preview_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wc_Document_Preview_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wc-document-preview-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script(
			$this->plugin_name,
			'wcdp_ajax_object',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'ajax-nonce' ),
			)
		);
	}

	/**
	 * Wbcom_hide_all_admin_notices_from_setting_page
	 *
	 * @return void
	 */
	public function wbcom_hide_all_admin_notices_from_setting_page() {
		$wbcom_pages_array  = array( 'wbcomplugins', 'wbcom-plugins-page', 'wbcom-support-page', 'woo-document-preview-settings' );
		$wbcom_setting_page = filter_input( INPUT_GET, 'page' ) ? filter_input( INPUT_GET, 'page' ) : '';

		if ( in_array( $wbcom_setting_page, $wbcom_pages_array, true ) ) {
			remove_all_actions( 'admin_notices' );
			remove_all_actions( 'all_admin_notices' );
		}
	}

	/**
	 * Actions performed to create a submenu page content.
	 *
	 * @since    1.0.0
	 * @access public
	 */
	public function bp_profile_views_admin_options_page() {
		global $allowedposttags;
		$tab = filter_input( INPUT_GET, 'tab' ) ? filter_input( INPUT_GET, 'tab' ) : 'woo-document-preview-welcome';
		?>
	<div class="wrap">
		<div class="wbcom-bb-plugins-offer-wrapper">
			<div id="wb_admin_logo">
				<a href="https://wbcomdesigns.com/downloads/buddypress-community-bundle/" target="_blank">
					<img src="<?php echo esc_url( WOO_DOCUMENT_PREVIEW_URL ) . 'admin/wbcom/assets/imgs/wbcom-offer-notice.png'; ?>">
				</a>
			</div>
		</div>
		<div class="wbcom-wrap">
			<div class="bupr-header">
				<div class="wbcom_admin_header-wrapper">
					<div id="wb_admin_plugin_name">
						<?php esc_html_e( 'Woo Document Preview', 'wc-document-preview' ); ?>
						<span><?php printf( __( 'Version %s', 'wc-document-preview' ), WC_DOCUMENT_PREVIEW_VERSION ); //phpcs:ignore ?></span>
					</div>
					<?php echo do_shortcode( '[wbcom_admin_setting_header]' ); ?>
				</div>
			</div>
			<div class="wbcom-admin-settings-page">
				<?php
				settings_errors();
				$this->woo_document_preview_plugin_settings_tabs();
				settings_fields( $tab );
				do_settings_sections( $tab );
				?>
			</div>
		</div>
	</div>
		<?php
	}

	/**
	 * Actions performed on loading plugin settings
	 *
	 * @since    1.0.9
	 * @access   public
	 * @author   Wbcom Designs
	 */
	public function woo_document_preview_init_plugin_settings() {
		$this->plugin_settings_tabs['woo-document-preview-welcome'] = esc_html__( 'Welcome', 'wc-document-preview' );
		register_setting( 'bp_profile_views_admin_welcome_options', 'bp_profile_views_admin_welcome_options' );
		add_settings_section( 'woo-document-preview-welcome', ' ', array( $this, 'woo_document_preview_admin_welcome_content' ), 'woo-document-preview-welcome' );

		$this->plugin_settings_tabs['woo-document-preview-pro'] = esc_html__( 'General (PRO)', 'wc-document-preview' );
		add_settings_section( 'woo-document-preview-general-pro', ' ', array( $this, 'woo_document_preview_general_pro' ), 'woo-document-preview-pro' );

		$this->plugin_settings_tabs['woo-document-preview-faq'] = esc_html__( 'FAQ', 'wc-document-preview' );
		register_setting( 'bp_profile_views_general_options', 'bp_profile_views_general_options' );
		add_settings_section( 'woo-document-preview-faq', ' ', array( $this, 'woo_document_preview_general_options_content' ), 'woo-document-preview-faq' );
	}

	/**
	 * Actions performed to create tabs on the sub menu page.
	 */
	public function woo_document_preview_plugin_settings_tabs() {
		$current_tab = filter_input( INPUT_GET, 'tab' ) ? filter_input( INPUT_GET, 'tab' ) : 'woo-document-preview-welcome';
		// xprofile setup tab.
		echo '<div class="wbcom-tabs-section"><div class="nav-tab-wrapper"><div class="wb-responsive-menu"><span>' . esc_html( 'Menu' ) . '</span><input class="wb-toggle-btn" type="checkbox" id="wb-toggle-btn"><label class="wb-toggle-icon" for="wb-toggle-btn"><span class="wb-icon-bars"></span></label></div><ul>';
		foreach ( $this->plugin_settings_tabs as $tab_key => $tab_caption ) {
			$active = $current_tab === $tab_key ? 'nav-tab-active' : '';
			echo '<li><a class="nav-tab ' . esc_attr( $active ) . '" id="' . esc_attr( $tab_key ) . '-tab" href="?page=woo-document-preview-settings&tab=' . esc_attr( $tab_key ) . '">' . esc_attr( $tab_caption ) . '</a></li>';
		}
		echo '</div></ul></div>';
	}

	/**
	 * Woo Document Preview admin welcome tab content.
	 *
	 * @return void
	 */
	public function woo_document_preview_admin_welcome_content() {
		include plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/woo-document-preview-welcome-page.php';
	}

	/**
	 * Woo Document Preview admin faq tab content.
	 *
	 * @return void
	 */
	public function woo_document_preview_general_options_content() {
		include plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/woo-document-preview-faq.php';
	}

	/**
	 * Woo Document Preview admin general pro tab content.
	 *
	 * @return void
	 */
	public function woo_document_preview_general_pro() {
		include plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/woo-document-preview-general-pro.php';
	}

	/**
	 * Actions performed on loading admin_menu.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @author   Wbcom Designs
	 */
	public function woo_document_preview_views_add_admin_settings() {
		if ( empty( $GLOBALS['admin_page_hooks']['wbcomplugins'] ) && class_exists( 'WooCommerce' ) ) {
			add_menu_page( esc_html__( 'WB Plugins', 'wc-document-preview' ), esc_html__( 'WB Plugins', 'wc-document-preview' ), 'manage_options', 'wbcomplugins', array( $this, 'bp_profile_views_admin_options_page' ), 'dashicons-lightbulb', 59 );
			add_submenu_page( 'wbcomplugins', esc_html__( 'Welcomw', 'wc-document-preview' ), esc_html__( 'Welcome', 'wc-document-preview' ), 'manage_options', 'wbcomplugins' );

		}
		add_submenu_page( 'wbcomplugins', esc_html__( 'Woo Document Preview', 'wc-document-preview' ), esc_html__( 'Woo Document Preview', 'wc-document-preview' ), 'manage_options', 'woo-document-preview-settings', array( $this, 'bp_profile_views_admin_options_page' ) );
	}

	/**
	 * Added upload support in form.
	 */
	public function update_edit_form() {
		echo ' enctype="multipart/form-data"';
	}

	/**
	 * Register meta box(es).
	 */
	public function wcdp_register_meta_boxes() {
		add_meta_box( 'wc-preview-doc-mata-id', __( 'Preview Item <span class="wcdp-required-span"> ( Only Doc, Xlsx and PDF allowed here. )</span>', 'wc-document-preview' ), array( $this, 'wcdp_display_callback' ), 'product' );
	}

	/**
	 * Meta box display callback.
	 *
	 * @param WP_Post $post Current post object.
	 */
	public function wcdp_display_callback( $post ) {
		// Add nonce for security and authentication.
		wp_nonce_field( 'wcdp_nonce_action', 'wcdp_nonce' );
		$wcdp_documents = get_post_meta( $post->ID, 'wcdp_documents', true );
		$preview_data   = get_post_meta( $post->ID, 'wcdp_preview_attachment', true );
		?>
		<div class="form-field preview_files">
			<table class="widefat woo-document-preview-table">
				<thead>
					<tr>
						<th class="sort">&nbsp;</th>
						<th><?php esc_attr_e( 'Name', 'wc-document-preview' ); ?><span class="woocommerce-help-tip"></span></th>
						<th colspan="2"><?php esc_attr_e( 'File URL', 'wc-document-preview' ); ?> <span class="woocommerce-help-tip"></span></th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody class="ui-sortable wcdp-preview-tr">
				<p class="wcdp-del-msg"></p>
				<?php
				if ( ! empty( $wcdp_documents ) ) :
					?>
						<?php
						foreach ( $wcdp_documents['wcdp_file_names'] as $key => $value ) :
							?>
							<tr class="wcdp-document-file">
								<td class="sort"></td>
								<td class="file_name"><input class="input_text" placeholder="File Name" name="wcdp_documents[wcdp_file_names][]" value="<?php echo esc_attr( isset( $wcdp_documents['wcdp_file_names'][ $key ] ) ) ? esc_attr( $wcdp_documents['wcdp_file_names'][ $key ] ) : ''; ?>" type="text"></td>
								<td class="file_url"><input id="wcdp_file_urls" class="input_text" placeholder="http://" name="wcdp_documents[wcdp_file_urls][]" value="<?php echo esc_attr( isset( $wcdp_documents['wcdp_file_urls'][ $key ] ) ) ? esc_attr( $wcdp_documents['wcdp_file_urls'][ $key ] ) : ''; ?>" type="text"></td>
								<td class="file_url_choose" width="1%"><input type="file" id="wcdp_preview_attachment" name="wcdp_documents[wcdp_preview_attachment][]" value="" size="25"/></td>
								<td width="15%">
									<a href="javascript:void(0)"  class="wcdp-add-document-cl button button-primary button-small"><?php esc_html_e( 'Add', 'wc-document-preview' ); ?></a>&nbsp;
									<a href="javascript:void(0)" data-p_id="<?php echo esc_attr( $post->ID ); ?>" data-file="<?php echo esc_attr( isset( $preview_data['file'] ) ) ? esc_attr( $preview_data['file'] ) : ''; ?>" class="wcdp-delete-document-cl button button-primary button-small" id="wcdp-delete-document-id"><?php esc_html_e( 'Remove', 'wc-document-preview' ); ?></a>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php
					else :
						?>
							<tr class="wcdp-document-file">
								<td class="sort"></td>
								<td class="file_name"><input class="input_text" placeholder="File Name" name="wcdp_documents[wcdp_file_names][]" value="<?php echo esc_attr( isset( $preview_data['name'] ) ) ? esc_attr( $preview_data['name'] ) : ''; ?>" type="text"></td>
								<td class="file_url"><input id="wcdp_file_urls" class="input_text" placeholder="http://" name="wcdp_documents[wcdp_file_urls][]" value="<?php echo esc_attr( isset( $preview_data['url'] ) ) ? esc_attr( $preview_data['url'] ) : ''; ?>" type="text"></td>
								<td class="file_url_choose" width="1%"><input type="file" id="wcdp_preview_attachment" name="wcdp_documents[wcdp_preview_attachment][]" value="<?php echo esc_attr( isset( $preview_data['file'] ) ) ? esc_attr( $preview_data['file'] ) : ''; ?>" size="25"/></td>
								<td width="15%">
									<a href="javascript:void(0)"  class="wcdp-add-document-cl button button-primary button-small"><?php esc_html_e( 'Add', 'wc-document-preview' ); ?></a>&nbsp;
									<a href="javascript:void(0)" data-p_id="<?php echo esc_attr( $post->ID ); ?>" data-file="<?php echo esc_attr( isset( $preview_data['file'] ) ) ? esc_attr( $preview_data['file'] ) : ''; ?>" class="wcdp-delete-document-cl button button-primary button-small" id="wcdp-delete-document-id"><?php esc_html_e( 'Remove', 'wc-document-preview' ); ?></a>
								</td>
							</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
		<?php
	}

	/**
	 * Save meta box content.
	 *
	 * @param int $post_id Post ID.
	 */
	public function wcdp_save_meta_box( $post_id ) {
		// Add nonce for security and authentication.
		$nonce_name   = isset( $_POST['wcdp_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['wcdp_nonce'] ) ) : '';
		$nonce_action = 'wcdp_nonce_action';

		// Check if nonce is set.
		if ( ! isset( $nonce_name ) ) {
			return;
		}

		// Check if nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
			return;
		}

		// Check if user has permissions to save data.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Check if not an autosave.
		if ( wp_is_post_autosave( $post_id ) ) {
			return;
		}

		// Check if not a revision.
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

		if ( isset( $_POST['post_type'] ) && 'product' === $_POST['post_type'] ) {

			if ( isset( $_POST['wcdp_documents'] ) && ! empty( $_POST['wcdp_documents'] ) ) {

				if ( isset( $_FILES['wcdp_documents']['name'] ) && ! empty( $_FILES['wcdp_documents']['name'] ) ) {
					$supported_types = array( 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel' );
					$wcdp_upload_doc = map_deep( wp_unslash( $_FILES['wcdp_documents'] ), 'sanitize_text_field' );
					foreach ( $wcdp_upload_doc['name']['wcdp_preview_attachment'] as $key => $value ) {
						$arr_file_type = wp_check_filetype( basename( $value ) );
						$uploaded_type = $arr_file_type['type'];
						if ( in_array( $uploaded_type, $supported_types ) ) {
							// Use the WordPress API to upload the file.
							if ( ! function_exists( 'wp_handle_upload' ) ) {
								require_once ABSPATH . 'wp-admin/includes/file.php';
							}

							$uploadedfile['name']     = $wcdp_upload_doc['name']['wcdp_preview_attachment'][ $key ];
							$uploadedfile['type']     = $wcdp_upload_doc['type']['wcdp_preview_attachment'][ $key ];
							$uploadedfile['tmp_name'] = $wcdp_upload_doc['tmp_name']['wcdp_preview_attachment'][ $key ];
							$uploadedfile['error']    = $wcdp_upload_doc['error']['wcdp_preview_attachment'][ $key ];
							$uploadedfile['size']     = $wcdp_upload_doc['size']['wcdp_preview_attachment'][ $key ];
							$upload_overrides         = array( 'test_form' => false );

							add_filter( 'upload_dir', array( $this, 'wcdp_set_upload_dir' ) );
							$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
							remove_filter( 'upload_dir', array( $this, 'wcdp_set_upload_dir' ) );
							$_POST['wcdp_documents']['wcdp_file_urls'][ $key ] = $movefile['url'];

						}
					}
					$uploaded_doc_data = map_deep( wp_unslash( $_POST['wcdp_documents'] ), 'sanitize_text_field' );
					update_post_meta( $post_id, 'wcdp_documents', $uploaded_doc_data );
				}
			}

			if ( isset( $_POST['wcdp_file_names'] ) ) {
				$wcdp_preview_doc = isset( $_FILES['wcdp_preview_attachment'] ) ? map_deep( wp_unslash( $_FILES['wcdp_preview_attachment'] ), 'sanitize_text_field' ) : '';
				$wcdp_file_names  = sanitize_text_field( wp_unslash( $_POST['wcdp_file_names'] ) );
				if ( '' == $wcdp_file_names ) {
					$file_name                = explode( '.', $wcdp_preview_doc['name'] );
					$_POST['wcdp_file_names'] = $file_name[0];
				}
				if ( isset( $_POST['wcdp_file_names'] ) && ! empty( $_POST['wcdp_file_names'] ) ) {

					// Make sure the file array isn't empty.
					if ( ! empty( $_FILES['wcdp_preview_attachment']['name'] ) ) {

						// Setup the array of supported file types. In this case, it's just PDF.
						$supported_types = array( 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' );

						// Get the file type of the upload.
						$arr_file_type = wp_check_filetype( basename( $wcdp_preview_doc['name'] ) );
						$uploaded_type = $arr_file_type['type'];
						// Check if the type is supported. If not, throw an error.
						if ( in_array( $uploaded_type, $supported_types ) ) {
							// Use the WordPress API to upload the file.
							if ( ! function_exists( 'wp_handle_upload' ) ) {
								require_once ABSPATH . 'wp-admin/includes/file.php';
							}
							$uploadedfile     = $wcdp_preview_doc;
							$upload_overrides = array( 'test_form' => false );

							add_filter( 'upload_dir', array( $this, 'wcdp_set_upload_dir' ) );
							$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
							remove_filter( 'upload_dir', array( $this, 'wcdp_set_upload_dir' ) );

							if ( $movefile && ! isset( $movefile['error'] ) ) {
								$movefile['name'] = sanitize_text_field( wp_unslash( $_POST['wcdp_file_names'] ) );
								add_post_meta( $post_id, 'wcdp_preview_attachment', $movefile );
								update_post_meta( $post_id, 'wcdp_preview_attachment', $movefile );
							} else {
								/**
								 * Error generated by _wp_handle_upload()
								 *
								 * @see _wp_handle_upload() in wp-admin/includes/file.php
								 */
								echo wp_kses( $movefile['error'] );
							}
						}// end if/else.
					} else {
						if ( isset( $_POST['wcdp_file_urls'] ) && ! empty( $_POST['wcdp_file_urls'] ) ) {
							$supported_types = array( 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' );
							$upload_file     = map_deep( wp_unslash( $_POST['wcdp_file_urls'] ), 'sanitize_text_field' );
							$arr_file_type   = wp_check_filetype( $upload_file );
							$uploaded_type   = $arr_file_type['type'];
							if ( in_array( $uploaded_type, $supported_types ) ) {
								$doc_url         = array();
								$doc_url['name'] = sanitize_text_field( wp_unslash( $_POST['wcdp_file_names'] ) );
								$doc_url['url']  = sanitize_text_field( wp_unslash( $_POST['wcdp_file_urls'] ) );
								add_post_meta( $post_id, 'wcdp_preview_attachment', $doc_url );
								update_post_meta( $post_id, 'wcdp_preview_attachment', $doc_url );
							}
						}
					}
				}
			}
		}
	}

	/**
	 * Function contains the document delete functionality.
	 *
	 * @return void
	 */
	public function wcdp_delete_document_ajax() {
		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ajax-nonce' ) ) {
			die( 'Busted!' );
		}
		if ( isset( $_POST ) ) {
			$post_id       = isset( $_POST['p_id'] ) ? sanitize_text_field( wp_unslash( $_POST['p_id'] ) ) : '';
			$fileurl       = isset( $_POST['file_url'] ) ? sanitize_text_field( wp_unslash( $_POST['file_url'] ) ) : '';
			$filename      = basename( $fileurl );
			$upload_dir    = wp_upload_dir();
			$upload_path   = $upload_dir['basedir'];
			$uploaded_file = $upload_path . '/wcdp_files/' . $filename;
			if ( file_exists( $uploaded_file ) ) {
				@unlink( $uploaded_file );
				update_post_meta( $post_id, 'wcdp_preview_attachment', '' );
			}
		}
		die();
	}

	/**
	 * Set Upload Directory
	 *
	 * Sets the upload dir to edd. This function is called from
	 * wcdp_change_audio_upload_dir()
	 *
	 * @since 1.0
	 * @return array Upload directory information
	 */
	public function wcdp_set_upload_dir( $upload ) {
		$upload['subdir'] = '/wcdp_files';
		$upload['path']   = $upload['basedir'] . $upload['subdir'];
		$upload['url']    = $upload['baseurl'] . $upload['subdir'];
		return $upload;
	}

}
