<?php
/**
* funciones del plugiin en la parte pública
*
* @package    zalemto-editor
* @subpackage zalemto-editor/resources
* @author     ZALEMTO STUDIOS <soporte@zalemto.com>
* @link https://zalemto.com
*
*/

class Editor_Public{

	/**
	 * Edit es el identificador general del plugin
	 */
	protected $editor;

	/**
	 * Inicializar clase y brindarle propiedades
	 *
	 * @since   1.0
	 * @param   string  $editor   El nombre del plugin.
	 */
	public function __construct($editor) {
		$this->editor = $editor;
	}

	/**
	 * Registro de los estilos para el lado público
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
	 * Registro de scripts para el lado público
	 *
	 * @since   1.0
	 */
	public function enqueue_scripts() {
		GLOBAL $wpd_settings;
		$options = $wpd_settings['wpc-general-options'];
		wp_enqueue_script('jquery');
		wp_enqueue_script($this->editor, plugin_dir_url(__FILE__) . 'js/scripts.js', array('jquery'), false);
	}
	
	public function register_shortcodes() {
		add_shortcode('open-modal', array($this, 'button_action'));
	}
	
	function button_action(){
		global $wpdb;

		$thepostid = get_the_ID();
		$product_editor = $wpdb->get_row( "SELECT producto_frontal, producto_alfa_frontal, producto_trasero, producto_alfa_trasero FROM zalemto_editor WHERE id_product = '$thepostid'" );
		echo $product_editor->producto_frontal;
		?>
		<button class="btnEditor" id="Editor">Editar Producto</button>
		<div id="popContainer">
			<div id="popLayer" onclick="closeModal()">
				<span>X</span>
			</div>
			<section class="popUp" id="popUp"></section>
		</div>

		<script>
			/**
			* Funcion que abre el modal y carga el editor dentro del div popUp
			*/
			jQuery(document).ready(function(){
				fnctnajaxpcrgpg('popUp','<?php echo plugin_dir_url(__FILE__); ?>editor/editor.php'); 
				jQuery('#Editor').click(function(e){
					e.preventDefault();
					document.getElementById("popContainer").style.display = "block"; 
					fnctnajaxpcrgpg('popUp','<?php echo plugin_dir_url(__FILE__); ?>editor/editor.php');
				});
				jQuery(window).load(function(){ jQuery('#Editor').removeAttr('disabled'); });
			});
			fnctnajaxpcrgpg = function(vrbldivdestino,vrblurlorigen){
				jQuery.ajax({
					url: vrblurlorigen,
					type: 'GET',
					beforeSend: function(){
						jQuery("#"+vrbldivdestino).html("Cargando Editor...");
						jQuery('#Editor').attr('disabled','disabled');
					},
					success: function(vrblprdctscplt){ return jQuery('#'+vrbldivdestino).html(vrblprdctscplt); }
				});
			}

			/**
			* Funcion que cierra el modal
			*/
			function closeModal(){
				document.getElementById("popContainer").style.display = "none"; jQuery('#Editor').removeAttr('disabled');
			}
		</script>
		<?php
	}
	

}