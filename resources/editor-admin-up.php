<?php 
if ( !defined('ABSPATH') ) {
	//If wordpress isn't loaded load it up.
	$path = $_SERVER['DOCUMENT_ROOT']."/wordpress";
	include_once $path . '/wp-load.php';
	include_once $path."/wp-content/plugins/edicion-de-productos/includes/settings.php";
}

$fecha = date("Y-m-d H:i:s");
if($_SERVER["REQUEST_METHOD"]=="POST"){
	/* 
	* El uso de INSERT se puede dar por descartado ya que tendría que implementarse para cada una de las opciones de subida
	* eso quiere decir que si suben una con el ID del producto se tendría que inspeccionar si ya esta el id creado y hacer updates dependiendo la cituacion de cada uno de los casos se estima un rediseño de la base de datos para guardar cada img
	*/
	$foo = new mCntrolFileSave($_FILES["ImageRequest"]);

	global $wpdb;

	if($foo){
		
		print("ID->".$_POST["IdProduct"]);
		//$sql = ("INSERT INTO zalemto_editor (producto_alfa_frontal,fecha) values ('$producto_alfa_frontal','$fecha')");
		//$wpdb->query($sql);
		
		echo "Subida Exitosa";

	}else{
		print("Problema al subir la imagen");
	}
}
?>
