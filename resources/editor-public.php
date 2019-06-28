<?php
/**
* funciones del plugiin en la parte pública
*
* @package    edicion-de-productos
* @subpackage edicion-de-productos/resources
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
	
	/**
	* Registro de shortcodes para el lado público
	*
	* @since 1.0
	*/
	public function register_shortcodes() {
		add_shortcode('open-modal', array($this, 'button_action'));
	}
	
	/**
	* Método que toma el id del producto actual y llama los datos correspondientes
	*/
	function button_action(){
		global $wpdb;

		$thepostid = get_the_ID();
		$product_editor = $wpdb->get_results( "SELECT cmpidtipimg FROM zalemto_editor_img WHERE cmpidprdct = '$thepostid'" );

		if ($product_editor !== null): ?>

			<button type="button" class="btnEditor Editor single_add_to_cart_button">Editar Producto <i class="fa fa-edit"></i></button>
			<div id="popContainer">
				<div class="popLayer"></div>
				<section class="popUp" id="popUp"></section>
			</div>

			<script>
				/**
				* Funcion que abre el modal y carga el editor dentro del div popUp
				*/
				jQuery(document).ready(function(){
					fnctnajaxpcrgpg('popUp','<?php echo plugin_dir_url(__FILE__); ?>editor/editor.php');
					jQuery('.Editor').click(function(e){
						e.preventDefault();
						fnctnajaxpcrgpg('popUp','<?php echo plugin_dir_url(__FILE__); ?>editor/editor.php?producto=<?php echo $thepostid; ?>');
						document.cookie = "client_ip=<?php echo $_SERVER['REMOTE_ADDR']; ?>";
						window.scrollTo(0,0);
						window.onscroll = null;

						jQuery('body.product-template-default').css({'height':'80vh','overflow':'hidden','overscroll-behavior':'contain !important'});

						jQuery('body').bind('touchmove', function(w){w.preventDefault()})

						jQuery('body.product-template-default').css({'height':'80vh','overflow':'hidden','overscroll-behavior':'contain !important','touch-action':'none'});

						document.getElementById("popContainer").style.display = "block"; 
					});
					jQuery(window).load(function(){ jQuery('#Editor').removeAttr('disabled'); });
				});
				fnctnajaxpcrgpg = function(vrbldivdestino,vrblurlorigen){
					jQuery.ajax({
						url: vrblurlorigen,
						type: 'GET',
						beforeSend: function(){
							jQuery("#"+vrbldivdestino).html("<div class='cm-spinner'></div>");
							jQuery('#Editor').attr('disabled','disabled');
						},
						success: function(vrblprdctscplt){ return jQuery('#'+vrbldivdestino).html(vrblprdctscplt); }
					});
				}

				/**
				* Funcion que cierra el modal
				*/
				function closeModal(nombreModal){
					/*document.body.exitFullscreen();
					document.body.cancelFullScreen();*/
					var r = confirm("¿Deseas cerrar el editor?\n Si lo haces perderás todo tu trabajo");
					if (r == true) {
						document.getElementById(nombreModal).style.display = "none"; jQuery('#Editor').removeAttr('disabled');
						jQuery('body.product-template-default').css({'height':'auto','overflow':'auto'});
					} else {
						console.log("Continuar");
					}
					
					
				}
				window.onbeforeunload = function() {
				  closeModal('popUp');
				};
			</script>
		<?php
		endif;
	}
	

}