<?php 
if ( !defined('ABSPATH') ) {
	//If wordpress isn't loaded load it up.
	$path = $_SERVER['DOCUMENT_ROOT']."/wordpress";
	include_once $path . '/wp-load.php';
	include_once $path."/wp-content/plugins/zalemto-editor/includes/settings.php";
}
if($_SERVER["REQUEST_METHOD"]=="POST"){
	//$foo = new mCntrolFileSave(); print_r($_FILES);
	global $wpdb;
	$producto_alfa_frontal = $_FILES["ImageRequest"]["name"];
	$wpdb->insert("zalemto-editor", array(
		//"producto_frontal" => $producto_frontal,
		"producto_alfa_frontal" => $producto_alfa_frontal,
		//"producto_trasero" => $producto_trasero,
		//"producto_alfa_trasero" => $producto_alfa_trasero
	));
	$wpdb->print_error();
	echo "carga exitosa";
}
?>
