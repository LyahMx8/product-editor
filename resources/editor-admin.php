<?php
/**
* funciones del plugiin en la parte administrativa
*
* @package    edicion-de-productos
* @subpackage edicion-de-productos/resources
* @author     ZALEMTO STUDIOS <soporte@zalemto.com>
* @link https://zalemto.com
*
*/


class Editor_Admin{

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

	/**
	 * Administrador que consulta las ediciones de producto realizadas
	 */
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

	/**
	 * Creacion de la caja en que se adjunta la imagen alpha 
	 */
	public static function output( $post ){
		global $thepostid, $product_object;

		$thepostid      = $post->ID;
		$product_object = $thepostid ? wc_get_product( $thepostid ) : new WC_Product();
		wp_nonce_field( 'woocommerce_save_data', 'woocommerce_meta_nonce' );
		?>
		<form enctype="multipart/form-data" class="vFormImg">
			<div class="col-sm-5 custom-file">
				<input type="file" multiple class="custom-file-input" name="mImageAdd" id="mImageAdd" onchange="loadFile(event)" style="display:none;">
				<label class="custom-file-label" for="mImageAdd">
					<div id="uprecall" ><img id="output" style="width:100%;max-height:500px;object-fit:cover;"/></div>
					<a style="text-decoration:underline;">Establecer imagen alpha matte frontal</a>
				</label>
			</div>
			<div style="display:none;" id="alphaSend">
				<p>Haz clic en la imagen para editarla o actualizarla</p>
				<input type="hidden" id="idproductup" value="<?php print($thepostid); ?>">
				<button id="upalpha" class="button button-primary button-large" rel="<?php echo plugin_dir_url(__FILE__); ?>editor-admin-up.php">Subir imagen</button>
			</div>
		</form>
		
		<script>
			$('#upalpha').click(function(e){ e.preventDefault();
				mFnctnajaxflereqst("uprecall","#mImageAdd",$(this).attr("rel"));
			});

			var loadFile = function(event) {
				document.getElementById('alphaSend').style.display = "block";
				var output = document.getElementById('output');
				output.src = URL.createObjectURL(event.target.files[0]);
			};

			mFnctnajaxflereqst = function(vrbldivdestino,vrbldtscntrl,vrblurlorigen){
				var mGetFleRequest = new FormData();
				mGetFleRequest.append('ImageRequest',$(vrbldtscntrl)[0].files[0]); mGetFleRequest.append('IdProduct',$("#idproductup").val());
				$.ajax({
					url: vrblurlorigen,
					data: mGetFleRequest,
					processData: false,
					contentType: false,
					type: 'POST',
					beforeSend: function(){$("#"+vrbldivdestino).html("Guardando Imagen...");},
					success: function(vrblprdctscplt){return $('#'+vrbldivdestino).html(vrblprdctscplt);}
				});
			}
		</script>
		<?php
	}

	/**
	 * Funcion que almacena los datos contenidos en el metabox
	 *
	 * @param int     $post_id
	 * @param WP_Post $post
	 */
	public static function save( $post_id, $post ) {
		$product_type   = empty( $_POST['product-type'] ) ? WC_Product_Factory::get_product_type( $post_id ) : sanitize_title( stripslashes( $_POST['product-type'] ) );
		$classname      = WC_Product_Factory::get_product_classname( $post_id, $product_type ? $product_type : 'simple' );
		$product        = new $classname( $post_id );
		$attachment_ids = isset( $_POST['product_image_gallery'] ) ? array_filter( explode( ',', wc_clean( $_POST['product_image_gallery'] ) ) ) : array();

		$product->set_gallery_image_ids( $attachment_ids );
		$product->save();
	}


	/**
	 * Funcion que agrega el nuevo metabox de edición de productos
	 */
	function meta_box_editor(){
		add_meta_box( 'image-alpha-product', __( 'Image Alpha', 'woocommerce' ), 'Editor_Admin::output', 'product', 'side', 'low' );
	}


	

}