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
	* Ya definila consulta en functions ahora se puede almacenar las imagenes con este array para definir si es frontal o algo 
	* asi....

		@$array_imagen_tipo=array(0=>"Imagen Alpha Frontal",1=>"Imagen Alpha Trasera",2=>"Imagenes Frontales",3=>"Imagenes Traseras", 4=>"Imagen Editada");
	
	*	Que dice Yimmy? asi seria mas facil saber si es imagen alpha se peude borrar al igual que las imagenes que se tienen
	*	los unicos estados que van a tener mayor cantidad de imagenes van a ser el 2, 3 y muy posible 4
	*/

	$foo = new mCntrolFileSave($_FILES["ImageRequest"],$_POST);

	global $wpdb;

	if($foo){
		
		//print("ID->".$_POST["IdProduct"]);
		
		echo "Subida Exitosa";

	}else{
		print("Problema al subir la imagen");
	}
}
?>
