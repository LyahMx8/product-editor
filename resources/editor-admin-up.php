<?php 
if ( !defined('ABSPATH') ) {
	//If wordpress isn't loaded load it up.
	$path = $_SERVER['DOCUMENT_ROOT']."/wordpress";
	include_once $path . '/wp-load.php';
	include_once $path."/wp-content/plugins/edicion-de-productos/includes/settings.php";
}

$fecha = date("Y-m-d H:i:s");
if($_SERVER["REQUEST_METHOD"]=="POST"){
	$foo = new mCntrolFileSave($_FILES["ImageRequest"]);

	global $wpdb;

	if($foo){
		
		//$sql = ("INSERT INTO zalemto_editor (producto_alfa_frontal,fecha) values ('$producto_alfa_frontal','$fecha')");
		//$wpdb->query($sql);
		
		echo "Subida Exitosa";

	}else{
		echo $wpdb->error();
	}
}
?>
