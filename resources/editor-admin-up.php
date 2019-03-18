<?php 
if ( !defined('ABSPATH') ) {
	//If wordpress isn't loaded load it up.
	$path = $_SERVER['DOCUMENT_ROOT']."/wordpress";
	include_once $path . '/wp-load.php';
	include_once $path."/wp-content/plugins/zalemto-editor/includes/settings.php";
}

$fecha = date("Y"). date("m"). date("d"). date("H"). date("i"). date("s");
if($_SERVER["REQUEST_METHOD"]=="POST"){
	//$foo = new mCntrolFileSave(); print_r($_FILES);
	global $wpdb;
	$producto_alfa_frontal = $_FILES["ImageRequest"]["name"];
	if(!empty($producto_alfa_frontal)){
		$sql = ("INSERT INTO zalemto_editor (producto_alfa_frontal,fecha) values ('$producto_alfa_frontal','$fecha')");
		$wpdb->query($sql);
	}else{
		echo $wpdb->error();
	}

	echo "carga exitosa";
}
?>
