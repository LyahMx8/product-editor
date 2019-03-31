<?php 
if ( !defined('ABSPATH') ) {
	//traer cuando wordprress cargue.
	$path = $_SERVER['DOCUMENT_ROOT'].'/wordpress';
	include_once $path.'/wp-load.php';
	include_once  plugin_dir_path( dirname( __FILE__ ) ).'includes/settings.php';
}

$fecha = date("Y-m-d H:i:s");
if($_SERVER["REQUEST_METHOD"]=="POST"){
	/* 
	* Ya definila consulta en functions ahora se puede almacenar las imagenes con este array para definir si es frontal o algo 
	* asi....
	*/
	$array_imagen_tipo=array(0=>"Imagen Alpha Frontal",1=>"Imagen Alpha Trasera",2=>"Imagenes Frontales",3=>"Imagenes Traseras", 4=>"Imagen Editada");
	/*
	*	Que dice Yimmy? asi seria mas facil saber si es imagen alpha se peude borrar al igual que las imagenes que se tienen
	*	los unicos estados que van a tener mayor cantidad de imagenes van a ser el 2, 3 y muy posible 4
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
