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
	 * Registro de los estilos para el lado administrativo
	 *
	 * @since   1.0
	 */
	public function enqueue_styles() {

		/**
		 * la instancia de esta clase inicia con el método run()
		 * El Loader puede crear una relacion entre los hooks definidos y las funciones definidas en esta clase
		 */
		wp_enqueue_style($this->editor, plugin_dir_url(__FILE__) . 'css/style.css', array(), 'all');
	}
	
	/**
	 * Crear item en el menu
	 */
	public function api_plugin_menu(){
		$icon = W_URL . 'assets/img/zalemto-logo.png';
		add_menu_page(
			'Productos Editados', //Titulo de la pagina
			'Productos Editados', //Titulo en el menu
			'edit_posts', //Rol de usuario
			'editor', //Sku en el menu
			array($this, 'adminsitrar_editor'), //Funcion que llama
			$icon); //Icono
	}

	function adminsitrar_editor(){
		global $wpdb;
	?>
		<h1>Lista de productos editados</h1>
		<table id="productos">
			<tr>
				<th>id</th>
				<th>Nombre</th>
				<th>Celular</th>
				<th>Email</th>
				<th>Producto Editado</th>
				<th>Fecha</th>
			</tr>
	<?php
		$resultados= $wpdb->get_results( "SELECT * FROM zalemto_editor" );

		foreach ( $resultados as $rows ) {
	?>
			<tr>
				<td><?php  echo $rows->id; ?></td>
				<td><?php echo $rows->name_usr; ?></td>
				<td><?php echo $rows->cel_usr; ?></td>
				<td><?php echo $rows->email_usr; ?></td>
				<td><img style="width:100px;height:70px;object-fit:cover;" src="<?php echo URL_PB.$rows->producto_editado; ?>">
				<a style="margin-top:calc((70px / 2) - 10px)" href="<?php echo URL_PB.$rows->producto_editado; ?>" download class="dashicons dashicons-download"></a></td>
				<td><?php echo $rows->fecha; ?></td>
			</tr>
	<?php
		}
	?>
		</table>
	<?php
	}


	

}