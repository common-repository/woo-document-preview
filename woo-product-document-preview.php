<?php
/**
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://wbcomdesigns.com
 * @since             1.0.0
 * @package           Wc_Document_Preview
 *
 * @wordpress-plugin
 * Plugin Name:       Document Preview For WooCommerce
 * Plugin URI:        http://wbcomdesigns.com
 * Description:       This will allow you to add document preview at single product page. Which helps to offer more better idea when you are selling ebooks, pdf or some documents.
 * Version:           1.4.3
 * Author:            Wbcom Designs <admin@wbcomdesigns.com>
 * Author URI:        http://wbcomdesigns.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wc-document-preview
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WC_DOCUMENT_PREVIEW_VERSION', '1.4.3' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wc-document-preview-activator.php
 */
function activate_wc_document_preview() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-document-preview-activator.php';
	Wc_Document_Preview_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wc-document-preview-deactivator.php
 */
function deactivate_wc_document_preview() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-document-preview-deactivator.php';
	Wc_Document_Preview_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wc_document_preview' );
register_deactivation_hook( __FILE__, 'deactivate_wc_document_preview' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wc-document-preview.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wc_document_preview() {

	$plugin = new Wc_Document_Preview();
	$plugin->run();

}
run_wc_document_preview();

/**
 * Check plugin requirement on plugins loaded
 * this plugin requires WooCommerce to be installed and active
 */
function wcdp_check_require_plugins() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		add_action( 'admin_notices', 'wcdp_plugin_admin_notice' );
		deactivate_plugins( plugin_basename( __FILE__ ) );
		if ( null !== filter_input( INPUT_GET, 'activate' ) ) {
			$activate = filter_input( INPUT_GET, 'activate' );
			unset( $activate );
		}
	}
}
add_action( 'admin_init', 'wcdp_check_require_plugins' );
/**
 * Required Plugin Admin Notice.
 */
function wcdp_plugin_admin_notice() {
	$wcdp_plugin         = esc_html__( 'WooCommerce Document Preview', 'wc-document-preview' );
	$wc_plugin           = esc_html__( 'WooCommerce', 'wc-document-preview' );
	$action              = 'install-plugin';
	$slug                = 'woocommerce';
	$plugin_install_link = '<a href="' . wp_nonce_url(
		add_query_arg(
			array(
				'action' => $action,
				'plugin' => $slug,
			),
			admin_url( 'update.php' )
		),
		$action . '_' . $slug
	) . '">' . $wc_plugin . '</a>';
	echo '<div class="error"><p>'
	. sprintf( '%1$s is ineffective now as it requires %2$s to function correctly.', '<strong>' . esc_html( $wcdp_plugin ) . '</strong>', '<strong>' . wp_kses_post( $plugin_install_link ) . '</strong>' )
	. '</p></div>';
	if ( null !== filter_input( INPUT_GET, 'activate' ) ) {
		$activate = filter_input( INPUT_GET, 'activate' );
		unset( $activate );
	}
}

/**
 * Redirect to plugin settings page after activated.
 *
 * @since  1.0.0
 *
 * @param string $plugin Path to the plugin file relative to the plugins directory.
 */
function woo_document_preview_activation_redirect_settings( $plugin ) {
	if ( plugin_basename( __FILE__ ) === $plugin && class_exists( 'WooCommerce' ) ) {
		if ( isset( $_REQUEST['action'] ) && $_REQUEST['action']  == 'activate' && isset( $_REQUEST['plugin'] ) && $_REQUEST['plugin'] == $plugin) {
			wp_safe_redirect( admin_url( 'admin.php?page=woo-document-preview-settings&tab=woo-document-preview-welcome' ) );
			exit;
		}
	}
}
add_action( 'activated_plugin', 'woo_document_preview_activation_redirect_settings' );
