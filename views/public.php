<?php
/**
* funciones del plugiin en la parte pública
*
* @package    zalemto-editor
* @subpackage zalemto-editor/views
* @author     ZALEMTO STUDIOS <soporte@zalemto.com>
* @link https://zalemto.com
*
*/

class Public{

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

	

}