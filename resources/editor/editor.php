<?php
if ( !defined('ABSPATH') ) {
	//traer cuando wordprress cargue.
	$path = $_SERVER['DOCUMENT_ROOT'].'/wordpress';
	include_once $path.'/wp-load.php';
	include_once plugin_dir_path( dirname(__DIR__) ).'includes/settings.php';
	global $wpdb;
	$product_editor = $wpdb->get_results( "SELECT * FROM zalemto_editor_img WHERE cmpidtipimg = 6" );
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link type="text/css" href="https://uicdn.toast.com/tui-color-picker/v2.2.0/tui-color-picker.css" rel="stylesheet">
	<link type="text/css" href="<?php echo plugin_dir_url( __FILE__ ).'css/tui-image-editor.css'; ?>" rel="stylesheet">
	<link type="text/css" href="<?php echo plugin_dir_url( __FILE__ ).'css/fontselect-alternate.css'; ?>" rel="stylesheet">
	<style>
		@import url(https://fonts.googleapis.com/css?family=Noto+Sans);
		div #tui-image-editor-container{
			height: 100%;margin: 0;
		}
		.tui-image-editor .tui-image-editor-canvas-container{
			background:url('/wordpress/wp-content/plugins/edicion-de-productos/<?php echo $_GET["producto"]; ?>');
			background-size:contain;background-repeat:no-repeat;
		}
		.tui-image-editor .tui-image-editor-canvas-container::before {
			background: url('/wordpress/wp-content/plugins/edicion-de-productos/<?php echo $_GET["alpha_frn"]; ?>');
			background-size: contain;
			background-repeat: no-repeat;
			filter: drop-shadow(0 0 5px red);
			mix-blend-mode: multiply;
		}
		.lower-canvas {
			mask-image: url('/wordpress/wp-content/plugins/edicion-de-productos/<?php echo $_GET["alpha_frn"]; ?>');
			-webkit-mask-image: url('/wordpress/wp-content/plugins/edicion-de-productos/<?php echo $_GET["alpha_frn"]; ?>');
			-webkit-mask-size: 500px 500px;
			mask-size: 500px 500px;
			mask-mode: luminance;
		}
	</style>
</head>
	

<body>
	<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ).'js/jquery.min.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ).'js/jquery.fontselect.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ).'js/editor.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ).'js/tui-code-snipped.min.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ).'js/FileSaver.min.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ).'js/tui-color-picker.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ).'js/tui-image-editor.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ).'js/theme/black-theme.js'; ?>"></script>
	
	<div id="tui-image-editor-container"></div>
	<section class="custom-file-label" id="iconContainer" style="display:none">
		<div class="ctm-icons carrusel-prods">
			<?php
				foreach ($product_editor as $key) {
					?>
					<div class="variationGallery" onclick="putIcon('/wordpress/wp-content/plugins/edicion-de-productos/<?php echo $key->cmpurlimg; ?>')"><img style="height:80px;max-width:100px;object-fit:contain;cursor:pointer;" src="/wordpress/wp-content/plugins/edicion-de-productos/<?php echo $key->cmpurlimg; ?>"></div>
					<?php
				}
			?>
		</div>
	</section>
	
	<script>

		 // Image editor
		 var locale_es_ES = {
			'Crop': 'Recortar',
			'Flip': 'Girar',
			'Rotate': 'Rotar',
			'Draw': 'Dibujar',
			'Shape': 'Forma',
			'Icon': 'Ícono',
			'Text': 'Texto'
		};
		var imageEditor = new tui.ImageEditor('#tui-image-editor-container', {
			includeUI: {
				loadImage: {
					path: '/wordpress/wp-content/plugins/edicion-de-productos/assets/img/background.png',
					name: 'SampleImage'
				},
				locale: locale_es_ES,
				theme: blackTheme,
				initMenu: '',
				menuBarPosition: 'left'
			},
			cssMaxWidth: 500,
			cssMaxHeight: 500
		});
		jQuery('#tie-btn-filter').
		replaceWith('<label style="display: block;" for="tie-icon-image-upload">\n	<li id="tie-btn-icon" title="Subir Imagen" class="tui-image-editor-item normal">\n	<svg class="svg_ic-submenu">\n	<use xlink:href="/wordpress/wp-content/plugins/edicion-de-productos/resources/editor/img/svg/icon-d.svg#icon-d-ic-icon-load" class="normal"></use>\n	<use xlink:href="/wordpress/wp-content/plugins/edicion-de-productos/resources/editor/img/svg/icon-c.svg#icon-c-ic-icon-load" class="active"></use>\n	</svg>\n	</li>\n	</label>\n	<input onchange="loadImage(event)" style="display:none;" type="file" accept="image/*" id="tie-icon-image-upload" class="tie-icon-image-file">');
		jQuery('#tie-btn-crop').
		replaceWith('<a onclick="openIcons()">\n	<li id="tie-btn-icon" title="Ícono" class="tui-image-editor-item normal">\n	<img src="/wordpress/wp-content/plugins/edicion-de-productos/assets/img/LogoZalemtoMin.png" style="width: 32px;">\n	</li>\n	</a>');

		 window.onresize = function() {
			 imageEditor.ui.resizeEditor();
		 }

		 function loadImage(event){
			var imgUrl = void 0;

			var _event$target$files = event.target.files,
				file = _event$target$files[0];

			if (file) {
				imgUrl = URL.createObjectURL(file);
				//this.actions.registCustomIcon(imgUrl, file);
				imageEditor.addImageObject(
					imgUrl
				).then(objectProps => {
					console.log(objectProps.id);
				});
			}
		}

		function openIcons(){
			var iconContainer = document.getElementById("iconContainer"); 
			if(iconContainer.style.display == "none"){
				iconContainer.style.display = "block"
			}else{
				iconContainer.style.display = "none"
			}
		}

		function putIcon(url){
			imageEditor.addImageObject(
				url
			).then(objectProps => {
				console.log(objectProps.id);
			});
		}
	</script>
	<script>
		jQuery(function(){
			jQuery('#font').fontselect().change(function(){
			
				var font = jQuery(this).val().replace(/\+/g, ' ');
				
				font = font.split(':');

				imageEditor.changeTextStyle(imageEditor.activeObjectId, {
					fontFamily: font[0]
				});
			});
		});

	</script>
	<script>
		jQuery(document).ready(function(){
			jQuery('#tui-image-editor-next-btn').click(function(e){
				e.preventDefault();
				imageEditor.addImageObject('http://localhost/wordpress/wp-content/plugins/edicion-de-productos/productos/2019-05-03-00-48-12.png', 'lena').then(result => {
					 console.log('result');
				});
				imageEditor.applyFilter('mask', {maskObjId: imageEditor.activeObjectId}).then(obj => {
					console.log('filterType: ', obj.type);
					console.log('actType: ', obj.action);
				}).catch(message => {
					console.log('error: ', message);
				});;
			});
		});
	</script>
	
</body>
</html>