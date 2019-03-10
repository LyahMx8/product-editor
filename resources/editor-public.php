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
		?>
		<a class="btnEditor" onclick="fnctnajaxpcrgpg('popUp','<?php echo plugin_dir_url(__FILE__); ?>editor/editor.php')">Editar Producto</a>
		<a class="btnEditor" id="perros">Editar Producto 2</a>
		<div id="popContainer">
			<div id="popLayer" onclick="closeModal()">
				<span>X</span>
			</div>
			<section class="popUp" id="popUp"></section>
		</div>

		<script>
			/**
			*	Abrir el editor 
			*/
			fnctnajaxpcrgpg = function(vrbldivdestino,vrblurlorigen){
				document.getElementById("popContainer").style.display = "block";
				jQuery.ajax({
					url: vrblurlorigen,
					type: 'GET',
				  	success: function(vrblprdctscplt){return jQuery('#'+vrbldivdestino).html(vrblprdctscplt);}
				});
			}

			jQuery("#perros").click(function(){
				document.getElementById("popContainer").style.display = "block";
				jQuery("#popUp").load("<?php echo plugin_dir_url(__FILE__); ?>editor/editor.php");
			});

			function closeModal(){
				document.getElementById("popContainer").style.display = "none";
			}
		</script>
		<?php
	}
	

}