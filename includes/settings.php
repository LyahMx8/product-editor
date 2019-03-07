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
	define('SERV', $_SERVER['DOCUMENT_ROOT']."/wp-content/plugins/zalemto-editor");
	define('URL', $_SERVER['HTTP_HOST']."/wp-content/plugins/zalemto-editor");
	define('URL_PB', "/wp-content/plugins/zalemto-editor");
}else{
	//Mostrar errores de php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	define('SERV', $_SERVER['DOCUMENT_ROOT']."/wordpress/wp-content/plugins/zalemto-editor");
	define('URL', $_SERVER['HTTP_HOST']."/wordpress/wp-content/plugins/zalemto-editor");
	define('URL_PB', "/wordpress/wp-content/plugins/zalemto-editor");
}

class Settings{
	//header('Content-type: application/json; charset=utf-8');

	/**
	 * El loader mantiene y registra los hooks del plugin
	 */
	protected $loader;

	/**
	 * Edit es el identificador general del plugin
	 */
	protected $editor;


	/**
	 * Constructor del núcleo del plugin
	 */
	public function __construct() {

		$this->editor = 'editor';

		$this->load_dependencies();
		$this->define_function_hooks();
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
	 * @since    1.0
	 * @access   private
	 */
	private function load_dependencies() {
		//La clase que carga todos los hooks del plugin
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/loader.php';

		//La clase que trae todas las funcionalidades usadas en el plugin
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/functions.php';

		//Clase con las funciones de las vistas publicas
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'resources/editor-public.php';

		//Clase con las funciones de las vistas administrativas
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'resources/editor-admin.php';

		
		$this->loader = new Loader();

	}

	/**
	 * Registro de hooks relacionados con el area de administracion de wordpress
	 *
	 * @since    3.0
	 * @access   private
	 */
	/*private function define_admin_hooks() {

		$plugin_admin = new WPD_Admin( $this->editor(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'wpc_redirect' );
		
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_woo_parts_submenu');
		
		//General
		$this->loader->add_action('init', $plugin_admin, 'init_globals');
		$this->loader->add_action('wpc_admin_field_wpc-icon-select', $plugin_admin, 'get_icon_selector_field');
		$this->loader->add_action('admin_notices', $plugin_admin, 'notify_customization_page_missing');
		$this->loader->add_action('admin_notices', $plugin_admin, 'notify_minmimum_required_parameters');
		$this->loader->add_action('admin_notices', $plugin_admin, 'run_wpc_db_updates_requirements');
		$this->loader->add_action('admin_notices', $plugin_admin, 'get_help_notices');
		$this->loader->add_action('admin_notices', $plugin_admin, 'get_missing_parts_notice');
		$this->loader->add_action('wp_ajax_run_updater', $plugin_admin, 'run_wpd_updater');
		$this->loader->add_filter('upload_mimes', $plugin_admin, 'wpc_add_custom_mime_types');
		$this->loader->add_action('admin_notices', $plugin_admin, 'get_max_input_vars_php_ini' );
		
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


	}*/

	/**
	 * Registro de hooks relacionados con la funcionalidad del plugin
	 * 
	 * @since 1.0
	 * @access   private
	 */
	private function define_function_hooks(){

		$plugin_functions = new Functions( $this->editor() );

		//Variable filters
		//Add query vars and rewrite rules
		$this->loader->add_filter('query_vars', $plugin_functions, 'wpd_add_query_vars');
		$this->loader->add_action( 'init', $plugin_functions, 'set_variable_action_filters', 99);
		$this->loader->add_filter('init', $plugin_functions, 'wpd_add_rewrite_rules',99);

	}

	/**
	 * Registro de hooks relacionados con la parte administrativa del plugin
	 * 
	 * @since 1.0
	 * @access   private
	 */
	private function define_admin_hooks(){

		$plugin_admin = new Editor_Admin( $this->editor() );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'api_plugin_menu');

	}

	/**
	 * Registro de hooks relacionados con la parte pública del plugin
	 *
	 * @since    1.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Editor_Public( $this->editor() );


		//$plugin_admin = new WPD_Admin( $this->editor(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_public, 'register_shortcodes');
		$this->loader->add_action( 'wp_ajax_handle_picture_upload', $plugin_public, 'handle_picture_upload');
		$this->loader->add_action( 'wp_ajax_nopriv_handle_picture_upload', $plugin_public, 'handle_picture_upload');
		$this->loader->add_action( 'woocommerce_before_add_to_cart_button', $plugin_public, 'button_action', 5 );


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