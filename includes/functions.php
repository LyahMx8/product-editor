<?php
/**
* Registro de acciones y funciones del plugin
*
* @package    edicion-de-productos
* @subpackage edicion-de-productos/includes
* @author     ZALEMTO STUDIOS <soporte@zalemto.com>
*
*/

class Functions{
	/**
	 * El loader mantiene y registra los hooks del plugin
	 */
	protected $loader;

	/**
	 * Editor es el identificador general del plugin
	 */
	protected $editor;

	/**
	 * Inicializar clase y brindarle propiedades
	 *
	 * @since 	1.0
	 * @param 	string 	$editor 	El nombre del plugin.
	 */
	public function __construct($editor) {
		$this->editor = $editor;
	}

	/**
	 * Crear la base de datos para almacenar imagenes editadas
	 * 
	 * @since 1.0
	 */
	public function create_editor_table(){
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS zalemto_editor (
			id int NOT NULL AUTO_INCREMENT,
			id_product int NOT NULL,
			name_usr varchar(60) NOT NULL,
			email_usr varchar(60) NOT NULL,
			cel_usr bigint(15) NOT NULL,
			producto_editado varchar(255) DEFAULT '' NOT NULL,
			producto_frontal varchar(255) NOT NULL,
			producto_alfa_frontal varchar(255) NOT NULL,
			producto_trasero varchar(255) NOT NULL,
			producto_alfa_trasero varchar(255) NOT NULL,
			fecha DATETIME NOT NULL,
			PRIMARY KEY (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
	public function create_images_table(){
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS zalemto_editor_img (
			cmpidimg int(10) NOT NULL AUTO_INCREMENT,
			cmpidprdct int(15) NOT NULL,
			cmpidtipimg int(10) NOT NULL,
			cmpurlimg varchar(255) DEFAULT '' NOT NULL,
			cmpfechup DATETIME NOT NULL,
			PRIMARY KEY (cmpidimg)
		) $charset_collate;";		

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );				
	}
	/*
	 * Obtener la versión de WooCommerce
	 */
	private function wpc_get_woo_version_number() {
		// If get_plugins() isn't available, require it
		if (!function_exists('get_plugins'))
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		// Create the plugins folder and file variables
		$plugin_folder = get_plugins('/' . 'woocommerce');
		$plugin_file = 'woocommerce.php';

		// If the plugin version number is set, return it 
		if (isset($plugin_folder[$plugin_file]['Version'])) {
			return $plugin_folder[$plugin_file]['Version'];
		} else {
			// Otherwise return null
			return NULL;
		}
	}

	/**
	 * Redefine los filtros de variables de Woocommerce
	 */
	function set_variable_action_filters() {
		GLOBAL $wpd_settings;
		$options = $wpd_settings['wpc-general-options'];
		$woo_version = $this->wpc_get_woo_version_number();
		if ($options['wpc-parts-position-cart'] == "name") {
			if ($woo_version < 2.1) {
				//Old WC versions
				add_filter("woocommerce_in_cart_product_title", array($this, "get_wpd_data"), 10, 3);
			} else {
				//New WC versions
				add_filter("woocommerce_cart_item_name", array($this, "get_wpd_data"), 10, 3);
			}
		} else {
			if ($woo_version < 2.1) {
				//Old WC versions
				add_filter("woocommerce_in_cart_product_thumbnail", array($this, "get_wpd_data"), 10, 3);
			} else {
				//New WC versions
				add_filter("woocommerce_cart_item_thumbnail", array($this, "get_wpd_data"), 10, 3);
			}
		}
		$append_content_filter = $options['wpc-content-filter'];

		if ($append_content_filter !== "0" && !is_admin()) {

			add_filter("the_content", array($this, "filter_content"), 99);
		}
	}

	/**
	 * Agrega nuevas variables
	 */
	public function wpd_add_query_vars($aVars) {
		$aVars[] = "product_id";
		$aVars[] = "tpl";
		$aVars[] = "edit";
		$aVars[] = "design_index";
		$aVars[] = "oid";
		return $aVars;
	}

	public function wpd_add_rewrite_rules($param) {
		GLOBAL $wpd_settings;
		GLOBAL $wp_rewrite;
		$options = $wpd_settings['wpc-general-options'];
		$wpc_page_id = $options['wpc_page_id'];
		if (function_exists("icl_object_id"))
			$wpc_page_id = icl_object_id($wpc_page_id, 'page', false, ICL_LANGUAGE_CODE);
		$wpc_page = get_post($wpc_page_id);
		if (is_object($wpc_page)) {
			//$slug = $wpc_page->post_name;
			$raw_slug = get_permalink($wpc_page->ID);
			$home_url = home_url('/');
			$slug = str_replace($home_url, '', $raw_slug);
			//If the slug does not have the trailing slash, we get 404 (ex postname = /%postname%)
			$sep="";
			if(substr($slug, -1)!="/")
				$sep="/";
//            var_dump(substr($slug, -1));
			add_rewrite_rule(
					// The regex to match the incoming URL
					$slug . $sep.'design' . '/([^/]+)/?$',
					// The resulting internal URL: `index.php` because we still use WordPress
					// `pagename` because we use this WordPress page
					// `designer_slug` because we assign the first captured regex part to this variable
					'index.php?pagename=' . $slug . '&product_id=$matches[1]',
					// This is a rather specific URL, so we add it to the top of the list
					// Otherwise, the "catch-all" rules at the bottom (for pages and attachments) will "win"
					'top'
			);
			add_rewrite_rule(
					// The regex to match the incoming URL
					$slug . $sep.'design' . '/([^/]+)/([^/]+)/?$',
					// The resulting internal URL: `index.php` because we still use WordPress
					// `pagename` because we use this WordPress page
					// `designer_slug` because we assign the first captured regex part to this variable
					'index.php?pagename=' . $slug . '&product_id=$matches[1]&tpl=$matches[2]',
					// This is a rather specific URL, so we add it to the top of the list
					// Otherwise, the "catch-all" rules at the bottom (for pages and attachments) will "win"
					'top'
			);
			add_rewrite_rule(
					// The regex to match the incoming URL
					$slug . $sep.'edit' . '/([^/]+)/([^/]+)/?$',
					// The resulting internal URL: `index.php` because we still use WordPress
					// `pagename` because we use this WordPress page
					// `designer_slug` because we assign the first captured regex part to this variable
					'index.php?pagename=' . $slug . '&product_id=$matches[1]&edit=$matches[2]',
					// This is a rather specific URL, so we add it to the top of the list
					// Otherwise, the "catch-all" rules at the bottom (for pages and attachments) will "win"
					'top'
			);
			add_rewrite_rule(
					// The regex to match the incoming URL
					$slug . $sep.'ordered-design' . '/([^/]+)/([^/]+)/?$',
					// The resulting internal URL: `index.php` because we still use WordPress
					// `pagename` because we use this WordPress page
					// `designer_slug` because we assign the first captured regex part to this variable
					'index.php?pagename=' . $slug . '&product_id=$matches[1]&oid=$matches[2]',
					// This is a rather specific URL, so we add it to the top of the list
					// Otherwise, the "catch-all" rules at the bottom (for pages and attachments) will "win"
					'top'
			);

			add_rewrite_rule(
					// The regex to match the incoming URL
					$slug . $sep.'saved-design' . '/([^/]+)/([^/]+)/?$',
					// The resulting internal URL: `index.php` because we still use WordPress
					// `pagename` because we use this WordPress page
					// `designer_slug` because we assign the first captured regex part to this variable
					'index.php?pagename=' . $slug . '&product_id=$matches[1]&design_index=$matches[2]',
					// This is a rather specific URL, so we add it to the top of the list
					// Otherwise, the "catch-all" rules at the bottom (for pages and attachments) will "win"
					'top'
			);

			$wp_rewrite->flush_rules(false);
		}
	}

	
}