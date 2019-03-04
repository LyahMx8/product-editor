<?php
/**
* Registro de configuraciones del plugin
*
* @package    zalemto-editor
* @subpackage zalemto-editor/includes
* @author     ZALEMTO STUDIOS <soporte@zalemto.com>
* @link https://zalemto.com
*
*/

define('app_env', 'development');
define( 'W_URL', plugins_url('/zalemto-editor/') );
ini_set('max_execution_time', 300);

/**
* Configurar el entorno 
*/
if(app_env == 'production'){
	define('api', 'apiProd.php');
	define('SERV', $_SERVER['DOCUMENT_ROOT']."/wp-content/plugins/zalemto-editor");
	define('URL', $_SERVER['HTTP_HOST']."/wp-content/plugins/zalemto-editor");
	define('URL_PB', "/wp-content/plugins/zalemto-editor");
}else{
	//Mostrar errores de php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	define('api', 'apiDevelop.php');
	define('SERV', $_SERVER['DOCUMENT_ROOT']."/wordpress/wp-content/plugins/zalemto-editor");
	define('URL', $_SERVER['HTTP_HOST']."/wordpress/wp-content/plugins/zalemto-editor");
	define('URL_PB', "/wordpress/wp-content/plugins/zalemto-editor");
}

class Settings{
	//header('Content-type: application/json; charset=utf-8');

	 


	/**
	 * Constructor del núcleo del plugin
	 */
	public function __construct() {

		$this->editor = 'editor';

		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Carga las dependencias requeridas para el plugin
	 *
	 * Incluye los siguientes archivos:
	 *
	 * - loader. Define los hooks del plugin.
	 * - Functions. Funciones que usa el plugin.
	 *
	 * Crear e instanciar el loader habilitará los hooks de wordpress para su uso
	 *
	 * @since    3.0
	 * @access   private
	 */
	private function load_dependencies() {
		//La clase que carga todos los hooks del plugin
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/loader.php';

		//La clase que trae todas las funcionalidades usadas en el plugin
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/functions.php';
		
		$this->loader = new Loader();

	}

	/**
	 * Registro de hooks relacionados con el area de administracion de wordpress
	 *
	 * @since    3.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new WPD_Admin( $this->editor(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'wpc_redirect' );
		
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_woo_parts_submenu');
		
		//General
		$this->loader->add_action( 'init', $plugin_admin, 'init_globals');
		$this->loader->add_action( 'wpc_admin_field_wpc-icon-select', $plugin_admin, 'get_icon_selector_field');
		$this->loader->add_action('admin_notices', $plugin_admin, 'notify_customization_page_missing');
		$this->loader->add_action('admin_notices', $plugin_admin, 'notify_minmimum_required_parameters');
		$this->loader->add_action('admin_notices', $plugin_admin, 'run_wpc_db_updates_requirements');
		$this->loader->add_action('admin_notices', $plugin_admin, 'get_help_notices');
		$this->loader->add_action('admin_notices', $plugin_admin, 'get_missing_parts_notice');
		$this->loader->add_action('wp_ajax_run_updater', $plugin_admin, 'run_wpd_updater');
		$this->loader->add_filter('upload_mimes', $plugin_admin, 'wpc_add_custom_mime_types');
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'get_max_input_vars_php_ini' );
		
		//Products
		$product_admin=new WPD_Product(false);
		$this->loader->add_filter('manage_edit-product_columns', $product_admin, 'get_product_columns');
		$this->loader->add_action('manage_product_posts_custom_column', $product_admin, 'get_products_columns_values', 5, 2);
		$this->loader->add_action('save_post_product', $product_admin, 'save_product_settings_fields');                
		$this->loader->add_action( 'woocommerce_save_product_variation', $product_admin, 'save_product_settings_fields');
		$this->loader->add_action( 'woocommerce_product_options_inventory_product_data', $product_admin, 'get_variable_product_details_location_notice');
		
		//Cliparts hooks
		$clipart=new WPD_Clipart();
		$this->loader->add_action( 'init', $clipart, 'register_cpt_cliparts');
		$this->loader->add_action( 'add_meta_boxes', $clipart, 'get_cliparts_metabox');
		$this->loader->add_action( 'save_post_wpc-cliparts', $clipart, 'save_cliparts' );
		
		$wpd_design=new WPD_Design();
		//Allow us to hide the wpc_data_upl meta from the meta list in the order details page
		$this->loader->add_filter( 'woocommerce_hidden_order_itemmeta', $wpd_design, 'unset_wpc_data_upl_meta');
		
		$wpd_config=new WPD_Config();
		//Allow us to hide the wpc_data_upl meta from the meta list in the order details page
		$this->loader->add_action( 'init', $wpd_config, 'register_cpt_config' );
		$this->loader->add_action( 'save_post_wpd-config', $wpd_config, 'save_config' );
		$this->loader->add_action( 'save_post_product', $wpd_config, 'save_config' );
		$this->loader->add_action( 'add_meta_boxes', $wpd_config, 'get_config_metabox');
		$this->loader->add_action( 'woocommerce_product_options_general_product_data', $wpd_config, 'get_product_config_selector' );
		$this->loader->add_action( 'woocommerce_product_after_variable_attributes', $wpd_config, 'get_variation_product_config_selector', 10, 3 );
		$this->loader->add_filter( 'get_user_option_meta-box-order_wpd-config', $wpd_config, 'get_metabox_order' );
		$this->loader->add_action( 'admin_action_wpd_duplicate_config', $wpd_config, 'wpd_duplicate_config' );
		$this->loader->add_filter( 'post_row_actions', $wpd_config, 'get_duplicate_post_link', 10, 2 );
		$this->loader->add_action( 'woocommerce_save_product_variation', $wpd_config, 'save_variation_settings_fields');


	}

	/**
	 * Registro de hooks relacionados con la funcionalidad del plugin
	 *
	 * @since    3.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new WPD_Public( $this->editor(), $this->get_version() );
		$plugin_admin = new WPD_Admin( $this->editor(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_public, 'register_shortcodes');
		$this->loader->add_action( 'woocommerce_after_add_to_cart_button', $plugin_public, 'get_customize_btn');
		$this->loader->add_action( 'wp_ajax_handle_picture_upload', $plugin_public, 'handle_picture_upload');
		$this->loader->add_action( 'wp_ajax_nopriv_handle_picture_upload', $plugin_public, 'handle_picture_upload');
		
		$this->loader->add_filter( 'woocommerce_loop_add_to_cart_link', $plugin_public, 'get_customize_btn_loop',10,2);
		

		//Add query vars and rewrite rules
		$this->loader->add_filter('query_vars', $plugin_public, 'wpd_add_query_vars');
		$this->loader->add_filter('init', $plugin_public, 'wpd_add_rewrite_rules',99);
		
		//Products
		$wpd_product=new WPD_Product(false);                
		$this->loader->add_action( 'woocommerce_add_to_cart', $wpd_product, 'set_custom_upl_cart_item_data',99,6);
		$this->loader->add_filter( 'body_class', $wpd_product,'get_custom_products_body_class', 10, 2 );
		$this->loader->add_action( 'woocommerce_product_duplicate', $wpd_product, 'duplicate_product_metas',10,2);

		
		//Variable filters
		$this->loader->add_action( 'init', $plugin_public, 'set_variable_action_filters', 99);
		
		//Body class
		$this->loader->add_filter('body_class', $plugin_public, 'add_class_to_body');
		
		//Shop loop item class
		$this->loader->add_filter('post_class', $plugin_public, 'get_item_class', 10, 3);
		
		//Sessions
		$this->loader->add_action( 'init', $plugin_admin, 'init_sessions', 1);
		
		//Design hooks
		$wpd_design=new WPD_Design();

		$this->loader->add_action( 'wp_ajax_add_custom_design_to_cart', $wpd_design, 'add_custom_design_to_cart_ajax' );
		$this->loader->add_action( 'wp_ajax_nopriv_add_custom_design_to_cart', $wpd_design, 'add_custom_design_to_cart_ajax' );
		$this->loader->add_action( 'wp_ajax_save_custom_design_for_later', $wpd_design, 'save_custom_design_for_later_ajax' );
		$this->loader->add_action( 'wp_ajax_nopriv_save_custom_design_for_later', $wpd_design, 'save_custom_design_for_later_ajax' );
		$this->loader->add_action( 'wp_ajax_save_canvas_to_session', $wpd_design, 'save_canvas_to_session_ajax' );
		$this->loader->add_action( 'wp_ajax_nopriv_save_canvas_to_session', $wpd_design, 'save_canvas_to_session_ajax' );
		$this->loader->add_action( 'wp_ajax_delete_saved_design', $wpd_design, 'delete_saved_design_ajax' );
		$this->loader->add_action( 'wp_ajax_nopriv_delete_saved_design', $wpd_design, 'delete_saved_design_ajax' );
		//$this->loader->add_action( 'woocommerce_admin_order_item_values', $wpd_design, 'get_order_custom_admin_data',10,3);
		$this->loader->add_action( 'woocommerce_after_order_itemmeta', $wpd_design, 'get_order_custom_admin_data',10,3);
		$this->loader->add_action( 'woocommerce_new_order_item', $wpd_design, 'save_customized_item_meta',10,3);
		//$this->loader->add_action( 'woocommerce_before_cart_item_quantity_zero', $wpd_design, 'remove_wpc_customization');
		$this->loader->add_action( 'wp_ajax_get_watermarked_preview', $wpd_design, 'get_watermarked_preview' );
		$this->loader->add_action( 'wp_ajax_nopriv_get_watermarked_preview', $wpd_design, 'get_watermarked_preview' );
		//$this->loader->add_action( 'user_register', $wpd_design, 'save_user_designs', 10, 1 );
		$this->loader->add_action( 'wp_login', $wpd_design, 'save_user_temporary_designs', 10, 2 );
		
		$this->loader->add_action( 'wp_ajax_generate_downloadable_file', $wpd_design, 'generate_downloadable_file' );
		$this->loader->add_action( 'wp_ajax_nopriv_generate_downloadable_file', $wpd_design, 'generate_downloadable_file' );
		//User my account page
		$this->loader->add_action( 'woocommerce_order_item_meta_end', $wpd_design, 'get_user_account_products_meta',11,4);
		$this->loader->add_action( 'woocommerce_before_calculate_totals', $wpd_design, 'get_cart_item_price', 10 );
		$this->loader->add_action( 'wp_ajax_get_design_price', $wpd_design, 'get_design_price_ajax' );
		$this->loader->add_action( 'wp_ajax_nopriv_get_design_price', $wpd_design, 'get_design_price_ajax' );
		//Reload an order
		$this->loader->add_action( 'woocommerce_my_account_my_orders_actions', $wpd_design, 'get_user_account_load_order_button', 10, 2);
		$this->loader->add_action( 'woocommerce_before_my_account', $wpd_design, 'get_user_saved_designs');
		//Save data to reload
		$this->loader->add_action( 'wp_ajax_save_data_to_reload', $wpd_design, 'save_data_to_reload' );
		$this->loader->add_action( 'wp_ajax_nopriv_save_data_to_reload', $wpd_design, 'save_data_to_reload' );
		
		//Allow us to hide the wpc_data_upl meta from the meta list in the order details page
		$this->loader->add_filter( 'woocommerce_hidden_order_itemmeta', $wpd_design, 'unset_wpc_data_upl_meta');
		$this->loader->add_filter( 'woocommerce_add_cart_item_data', $wpd_design,'force_individual_cart_items', 10, 2 );
		//Cart
		//$this->loader->add_filter( 'woocommerce_get_price_excluding_tax', $wpd_design,'get_price_excluding_tax', 10, 3 );

		//Emails
		$this->loader->add_action( 'woocommerce_order_item_meta_start', $plugin_public, 'set_email_order_item_meta',10,3 );

	}

	/**
	 * Iniicar loader para arrencar todos los hooks de wordpress
	 *
	 * @since    3.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * El nombre del plugin para darle un identidad y brindarle una funcionalidad global
	 *
	 * @since     3.0
	 * @return    string    El nombre del plugin
	 */
	public function editor() {
		return $this->editor;
	}

	/**
	 * Referencia a la clase que habilita los hooks del plugin
	 *
	 * @since     3.0
	 * @return    Loader    Habilita los hooks del plugin
	 */
	public function get_loader() {
		return $this->loader;
	}
}