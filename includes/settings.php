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
	define('URL_PS', $_SERVER['HTTP_HOST']."wp-content/plugins/zalemto-editor/");
	define('URL_PB', "/wp-content/plugins/zalemto-editor");
}else{
	//Mostrar errores de php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	define('SERV', $_SERVER['DOCUMENT_ROOT']."/wordpress/wp-content/plugins/zalemto-editor");
	define('URL_PS', $_SERVER['HTTP_HOST']."/wordpress/wp-content/plugins/zalemto-editor");
	//echo URL;
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
	 * Registro de hooks relacionados con la funcionalidad del plugin
	 * 
	 * @since 1.0
	 * @access   private
	 */
	private function define_function_hooks(){

		$plugin_functions = new Functions( $this->editor() );

		//Variable filters
		//Add query vars and rewrite rules
		$this->loader->add_action( 'init', $plugin_functions, 'set_variable_action_filters', 99);
		$this->loader->add_filter('init', $plugin_functions, 'wpd_add_rewrite_rules',99);
		$this->loader->add_action('init', $plugin_functions, 'create_editor_table',99);
		$this->loader->add_filter('query_vars', $plugin_functions, 'wpd_add_query_vars');

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
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );

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