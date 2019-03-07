<?php
/**
* funciones del plugiin en la parte administrativa
*
* @package    zalemto-editor
* @subpackage zalemto-editor/resources
* @author     ZALEMTO STUDIOS <soporte@zalemto.com>
* @link https://zalemto.com
*
*/

class Editor_Admin{

	/**
	 * Edit es el identificador general del plugin
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
	 * Crear item en el menu
	 */
	public function api_plugin_menu(){
		$icon = W_URL . 'assets/img/zalemto-logo.png';
		add_menu_page(
			'Editar productos', //Titulo de la pagina
			'Editar productos', //Titulo en el menu
			'edit_posts', //Rol de usuario
			'editor', //Sku en el menu
			'adminsitrar_editor', //Funcion que llama
			$icon); //Icono
	}

	public function adminsitrar_editor(){
		echo "popotl";
	}


	

}