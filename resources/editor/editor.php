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
		@import url(http://fonts.googleapis.com/css?family=Noto+Sans);
		div #tui-image-editor-container{
			height: 100%;
			margin: 0;
		}
		.tui-image-editor .tui-image-editor-canvas-container{
			background:url('/wordpress/wp-content/plugins/edicion-de-productos/<?php echo $_GET["producto"]; ?>');
			background-size:contain;
			background-repeat:no-repeat;
		}
		
	</style>
</head>
	

<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ).'js/editor.js'; ?>"></script>
	<script type="text/javascript" src="https://uicdn.toast.com/tui.code-snippet/v1.5.0/tui-code-snippet.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.3/FileSaver.min.js"></script>
	<script type="text/javascript" src="https://uicdn.toast.com/tui-color-picker/v2.2.0/tui-color-picker.js"></script>
	<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ).'js/tui-image-editor.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ).'js/theme/white-theme.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ).'js/theme/black-theme.js'; ?>"></script>
	
	<div id="tui-image-editor-container"></div>
	
	<script>

	 // Image editor
	var imageEditor = new tui.ImageEditor('#tui-image-editor-container', {
		includeUI: {
			loadImage: {
				path: '/wordpress/wp-content/plugins/edicion-de-productos/assets/img/background.png',
				name: 'SampleImage'
			},
			theme: blackTheme, // or whiteTheme
			initMenu: '',
			menuBarPosition: 'left'
		},
		cssMaxWidth: 700,
		cssMaxHeight: 500
	});

	 window.onresize = function() {
		 imageEditor.ui.resizeEditor();
	 }
	</script>
	<script>
		$(function(){
			$('#font').fontselect().change(function(){
			
				// replace + signs with spaces for css
				var font = $(this).val().replace(/\+/g, ' ');
				
				// split font into family and weight
				font = font.split(':');
				
				// set family on paragraphs 
				$('p').css('font-family', font[0]);
			});
		});
	</script>

	<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ).'js/require.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ).'js/jquery.fontselect.js'; ?>"></script>
	
</body>
</html>