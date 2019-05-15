<?php
if ( !defined('ABSPATH') ) {
	//traer cuando wordprress cargue.
	$path = $_SERVER['DOCUMENT_ROOT'].'/wordpress';
	include_once $path.'/wp-load.php';
	include_once plugin_dir_path( dirname(__DIR__) ).'includes/settings.php';
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

	 window.onresize = function() {
		 imageEditor.ui.resizeEditor();
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