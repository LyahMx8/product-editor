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
		wp_enqueue_style($this->editor, '/wordpress/wp-admin/load-styles.php', array(), 'all');
	}
	
	/**
	 * Funcion que agrega el nuevo metabox de edición de productos
	 */
	function meta_box_editor(){
		add_meta_box( 'image-galery-product-edit', __( 'Galería de Imagenes Edición(En Desarrollo)', 'woocommerce' ), 'Editor_Admin::out_carrousel_image', 'product', 'normal', 'low' );
		/*add_meta_box( 'product-variations', __( 'Variaciones del producto(En Desarrollo)', 'woocommerce' ), 'Editor_Admin::variations', 'product', 'side', 'low' );*/
		add_meta_box( 'image-alpha-product', __( 'Imagen Alpha Frontal', 'woocommerce' ), 'Editor_Admin::output', 'product', 'side', 'low' );
		add_meta_box( 'image-alpha-product-back', __( 'Imagen Alpha Trasera', 'woocommerce' ), 'Editor_Admin::outputb', 'product', 'side', 'low' );
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
		add_submenu_page(
			'editor',
			'Agregar Íconos',
			'Íconos',
			'edit_posts', //Rol de usuario
			'subir-icono',
			array($this, 'cargar_iconos')
		);
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
				<th>Producto Editado Frontal</th>
				<th>Fecha Subida</th>
				<th>Producto Editado Trasero</th>
				<th>Fecha Subida</th>
			</tr>
	<?php
		$resultados= $wpdb->get_results( "SELECT * FROM zalemto_editor", ARRAY_A );

		foreach ( $resultados as $rows => $ch ) {
			$_frntl_etado = $wpdb->get_row("SELECT cmpurlimg, cmpfechup FROM zalemto_editor_img WHERE cmpidimg = ".$ch['producto_editado'], ARRAY_A);

			$_trsro_etado = $wpdb->get_row("SELECT cmpurlimg, cmpfechup FROM zalemto_editor_img WHERE cmpidimg = ".$ch['producto_trasero'], ARRAY_A);
	?>
			<tr>
				<td><?php  echo $ch['id']; ?></td>
				<td><?php echo $ch['name_usr']; ?></td>
				<td><?php echo $ch['cel_usr']; ?></td>
				<td><?php echo $ch['email_usr']; ?></td>
				<td><img style="width:100px;height:70px;object-fit:cover;" src="<?php echo URL_PB."/".$_frntl_etado['cmpurlimg']; ?>">
				<a style="margin-top:calc((70px / 2) - 10px)" href="<?php echo URL_PB."/".$ch['cmpurlimg']; ?>" download class="dashicons dashicons-download"></a></td>
				<td><?php echo $_frntl_etado['cmpfechup']; ?></td>
				<td><img style="width:100px;height:70px;object-fit:cover;" src="<?php echo URL_PB."/".$_trsro_etado['cmpurlimg']; ?>">
				<a style="margin-top:calc((70px / 2) - 10px)" href="<?php echo URL_PB."/".$_trsro_etado['cmpurlimg']; ?>" download class="dashicons dashicons-download"></a></td>
				<td><?php echo $_trsro_etado['cmpfechup']; ?></td>
			</tr>
	<?php
		}
	?>
		</table>
	<?php
	}

	/**
	*
	*/
	public function cargar_iconos(){
		global $wpdb;
	?>
	<div class="wrap" id="wp-media-grid" data-search="">
		<h1 class="wp-heading-inline">Biblioteca de Íconos( En Desarrollo)</h1>
<div class="media-frame wp-core-ui mode-grid mode-edit hide-menu">
	<div class="uploader-inline" style="padding:20px;">
		
		<div class="uploader-inline-content no-upload-message" style="display:flex;justify-content:center;">
		
			<div class="upload-ui">
				<input type="file" multiple class="custom-file-input" name="mImageAddIcon" id="mImageAddIcon" style="display:none;" onchange="loadFilesGaleryIcon(event)">
				<input type="hidden" id="_icon_prodct" value="0">
				<input type="hidden" id="_icon_tiprodct" value="6">
				<button type="button" class="browser button button-hero" onclick="document.getElementById('mImageAddIcon').click();" style="display: inline-block; position: relative; z-index: 1;" id="__wp-uploader-id-1">Seleccionar archivos</button>

			</div>

		</div>
		<div class="post-upload-ui">
			<p class="max-upload-size">Tamaño máximo de archivo: 512 MB.</p>
		</div>
	</div>
	<div class="upload-inline-status" id="_charge_img" style="padding:50px;"><?php echo Editor_Admin::show_preimages(0,6); ?></div>
</div>
	</div>
	<script>
		function loadFilesGaleryIcon(event){
			console.log(event.target.files);

			var mGetFleRequest = new FormData();

			jQuery.each(event.target.files, function(i, file) { mGetFleRequest.append('ImageRequest[]',file); });
			
			mGetFleRequest.append('IdProduct',jQuery("#_icon_prodct").val()); mGetFleRequest.append('TiProduct',jQuery("#_icon_tiprodct").val());

			jQuery.ajax({ url: "<?php echo plugin_dir_url(__FILE__)."editor-admin-up.php"; ?>", data: mGetFleRequest, processData: false,
				contentType: false, type: 'POST', beforeSend: function(){jQuery("#_charge_img").html("Guardando Imagen(es)...");}, success: function(vrblprdctscplt){ return jQuery('#_charge_img').html(vrblprdctscplt);} });

		}
	</script>
	<?php
	}

	public static function variations( $post ){
		/*global $thepostid, $product_object;

		$thepostid      = $post->ID;
		$product_object = $thepostid ? wc_get_product( $thepostid ) : new WC_Product();
		wp_nonce_field( 'woocommerce_save_data', 'woocommerce_meta_nonce' );

		?>
		<label>¿Este producto es full color? - <input type="checkbox"></label>

		<?php*/
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
				<input type="file" class="custom-file-input" name="mImageAdd" id="mImageAdd" onchange="loadFile(event)" style="display:none;">
				<label class="custom-file-label" for="mImageAdd">
					<div id="uprecall" ><?php echo Editor_Admin::show_preimages($thepostid,0); ?></div>
					<a style="text-decoration:underline;">Establecer imagen alpha matte frontal</a>
				</label>
			</div>
			<div style="display:none;" id="alphaSend">
				<p>Haz clic en la imagen para editarla o actualizarla</p>
				<input type="hidden" id="idproductup" value="<?php print($thepostid); ?>">
				<input type="hidden" id="tipproduct" value="0">
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
				mGetFleRequest.append('ImageRequest',$(vrbldtscntrl)[0].files[0]); mGetFleRequest.append('IdProduct',$("#idproductup").val()); mGetFleRequest.append('TiProduct',$("#tipproduct").val());
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
	public static function outputb($post){
		/*
			El Funcionamiento de cada subida es muy parecida se espera optimizar y modificar esta seccion para utilizar solo
			una function en JS para este caso
		*/
		global $thepostid, $product_object;

		$thepostid      = $post->ID;
		$product_object = $thepostid ? wc_get_product( $thepostid ) : new WC_Product();
		wp_nonce_field( 'woocommerce_save_data', 'woocommerce_meta_nonce' );
		?>
		<form enctype="multipart/form-data" class="vFormImg">
			<div class="col-sm-5 custom-file">
				<input type="file" class="custom-file-input" name="mImageAddBack" id="mImageAddBack" onchange="loadFileBck(event)" style="display:none;">
				<label class="custom-file-label" for="mImageAddBack">
					<div id="uprecallbck" ><?php echo Editor_Admin::show_preimages($thepostid,1); ?></div>
					<a style="text-decoration:underline;">Establecer imagen alpha matte trasera</a>
				</label>
			</div>
			<div style="display:none;" id="alphaSendbck">
				<p>Haz clic en la imagen para editarla o actualizarla</p>
				<input type="hidden" id="idproductupbck" value="<?php print($thepostid); ?>">
				<input type="hidden" id="tipproductbck" value="1">
				<button id="upalphaback" class="button button-primary button-large" rel="<?php echo plugin_dir_url(__FILE__); ?>editor-admin-up.php">Subir imagen</button>
			</div>
		</form>
		
		<script>
			$('#upalphaback').click(function(e){ e.preventDefault();
				mFnctnajaxflereqstbck("uprecallbck","#mImageAddBack",$(this).attr("rel"));
			});

			var loadFileBck = function(event) {
				document.getElementById('alphaSendbck').style.display = "block";
				var outputbck = document.getElementById('outputbck');
				outputbck.src = URL.createObjectURL(event.target.files[0]);
			};

			mFnctnajaxflereqstbck = function(vrbldivdestino,vrbldtscntrl,vrblurlorigen){
				var mGetFleRequest = new FormData();
				mGetFleRequest.append('ImageRequest',$(vrbldtscntrl)[0].files[0]); mGetFleRequest.append('IdProduct',$("#idproductupbck").val()); mGetFleRequest.append('TiProduct',$("#tipproductbck").val());
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
	public static function out_carrousel_image($post){
		
		$thepostid = $post->ID;

		?>
		<form enctype="multipart/form-data" class="vFormImgGalMuch">
			<div class="col-sm-5 custom-file">
				<input type="file" multiple class="custom-file-input" name="mImageAddMuchas[]" id="mImageAddMuchas" onchange="loadFilesGaleryMuch(event)" style="display:none;">
				<label class="custom-file-label" for="mImageAddMuchas">
					<div id="uprecallmuchas" class="carrusel-prods">
					<?php echo Editor_Admin::show_preimages($thepostid,2); ?>
					</div>
					<a style="text-decoration:underline;">Establecer imagenes para Edición</a>
				</label>
			</div>
			<div style="display:none;" id="GallerySendMuchas">
				<p>Haz clic en la X para eliminar la imagen de la lista</p>
				<input type="hidden" id="idproductGalMuch" value="<?php print($thepostid); ?>">
				<input type="hidden" id="tipproductGalMuch" value="2">
				<button id="upImagGalMuch" class="button button-primary button-large" rel="<?php echo plugin_dir_url(__FILE__); ?>editor-admin-up.php">Subir imagenes</button>
			</div>
		</form>
		
		<script>
			$('#upImagGalMuch').click(function(e){ e.preventDefault();
				mFnctnajaxflereqstGalMuch("uprecallmuchas",$(this).attr("rel"));
			});

			var FilesAdd = [];

			function loadFilesGaleryMuch(event) {
				document.getElementById('GallerySendMuchas').style.display = "block";
				console.log(event.target.files);
				
				for (var i=0;i<event.target.files.length;i++) {

					$("#uprecallmuchas").append("<div class='variationGallery'><img id =\"ImGaleryMuch"+i+"\" class=\"ImgCont\" style=\"width:200px;\" src="+URL.createObjectURL(event.target.files[i])+" rel=\"0\" /><a href=\"#\" style=\"position:absolute;top:5px;right:5px;\" onclick=\"_CallDeleteImg(event,this);\" rel="+i+">X</a></div>");

					FilesAdd.push(event.target.files[i]);
				}
				console.log(FilesAdd);
			};

			mFnctnajaxflereqstGalMuch = function(vrbldivdestino,vrblurlorigen){
				var mGetFleRequest = new FormData();

				$.each(FilesAdd, function(i, file) { mGetFleRequest.append('ImageRequest[]',file); });
				
				mGetFleRequest.append('IdProduct',$("#idproductGalMuch").val()); mGetFleRequest.append('TiProduct',$("#tipproductGalMuch").val());

				$.ajax({
					url: vrblurlorigen,
					data: mGetFleRequest,
					processData: false,
					contentType: false,
					type: 'POST',
					beforeSend: function(){$("#"+vrbldivdestino).html("Guardando Imagen...");},
					success: function(vrblprdctscplt){ FilesAdd = []; return $('#'+vrbldivdestino).html(vrblprdctscplt);}
				});
			}
			function _CallDeleteImg(e,_this){ 
				e.preventDefault();
				
				if($(_this).prev().attr("rel")!=0) {
					FilesAdd = []; $.ajax({ url:"<?php echo plugin_dir_url(__FILE__)."editor-admin-down.php"; ?>",data:{"down":$(_this).prev().attr("rel")},type:'POST',beforeSend: function(){$("#uprecallmuchas").html("Eliminando Imagen...");},success: function(vrblprdctscplt){ return $('#uprecallmuchas').html(vrblprdctscplt);} });
				} else {
					FilesAdd.splice($(_this).attr("rel"),1); $(_this).prev().remove(); $(_this).remove();
				}
			}
		</script>
		<?php
	}

	public static function show_preimages($id_post,$tip_post){
		global $wpdb;

		if($tip_post==3 || $tip_post==2){

			$_order = "";

			$result =  $wpdb->get_results( "SELECT cmpurlimg,cmpidimg FROM zalemto_editor_img WHERE cmpidtipimg = 3 OR cmpidtipimg = ".$tip_post." AND cmpidprdct = ".$id_post, ARRAY_A );

			if(!is_null($result)){
				foreach ($result as$k=>$e){
					$_order .= '<div class="variationGallery"><img id="output" style="width:200px;"  src="'.W_URL.$e['cmpurlimg'].'" rel="'.$e['cmpidimg'].'"/><a href="#" style="position:absolute;top:5px;right:5px;" onclick="_CallDeleteImg(event,this);">X</a></div>';
				}
			}

			return $_order;
		}
		else{
			
			$result = $wpdb->get_row("SELECT cmpurlimg FROM zalemto_editor_img WHERE cmpidtipimg = ".$tip_post." AND cmpidprdct = ".$id_post, ARRAY_A);

			if(!is_null($result['cmpurlimg'])) return '<img id="output" style="width:100%;max-height:500px;object-fit:cover;"  src="'.W_URL.$result['cmpurlimg'].'"/>';
		}

		return "";
	}

}