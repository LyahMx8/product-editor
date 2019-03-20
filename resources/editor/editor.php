<?php
if ( !defined('ABSPATH') ) {
    //If wordpress isn't loaded load it up.
    $path = $_SERVER['DOCUMENT_ROOT']."/wordpress";
    include_once $path . '/wp-load.php';
    include_once $path."/wp-content/plugins/zalemto-editor/includes/settings.php";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link type="text/css" href="https://uicdn.toast.com/tui-color-picker/v2.2.0/tui-color-picker.css" rel="stylesheet">
	<link type="text/css" href="<?php echo plugin_dir_url( __FILE__ ).'css/tui-image-editor.css'; ?>" rel="stylesheet">
	<style>
		@import url(http://fonts.googleapis.com/css?family=Noto+Sans);
		div #tui-image-editor-container{
			height: 100%;
			margin: 0;
		}
	</style>
</head>
	
<div id="tui-image-editor-container"></div>

<body>
	<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ).'js/editor.js'; ?>"></script>
	<script type="text/javascript" src="https://uicdn.toast.com/tui.code-snippet/v1.5.0/tui-code-snippet.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.3/FileSaver.min.js"></script>
	<script type="text/javascript" src="https://uicdn.toast.com/tui-color-picker/v2.2.0/tui-color-picker.js"></script>
	<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ).'js/tui-image-editor.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ).'js/theme/white-theme.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ).'js/theme/black-theme.js'; ?>"></script>
	<script>

	 // Image editor
	var imageEditor = new tui.ImageEditor('#tui-image-editor-container', {
		includeUI: {
			theme: blackTheme, // or whiteTheme
			initMenu: '',
			menuBarPosition: 'bottom'
		},
		cssMaxWidth: 700,
		cssMaxHeight: 500
	});

	 window.onresize = function() {
		 imageEditor.ui.resizeEditor();
	 }
	</script>

	
</body>
</html>