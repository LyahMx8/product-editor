<?php 
if ( !defined('ABSPATH') ) {
	//traer cuando wordprress cargue.
	include_once $_SERVER['DOCUMENT_ROOT'].'/wp-load.php';
	include_once  plugin_dir_path( dirname( __FILE__ ) ).'/includes/settings.php';
}

$fecha = date("Y-m-d H:i:s");

if($_SERVER["REQUEST_METHOD"]=="POST"){
	/* 
	* Ya definila consulta en functions ahora se puede almacenar las imagenes con este array para definir si es frontal o algo 
	* asi....

		@$array_imagen_tipo=array(0=>"Imagen Alpha Frontal",1=>"Imagen Alpha Trasera",2=>"Imagenes Frontales",3=>"Imagenes Traseras", 4=>"Imagen Editada Frontal",5=>"Imagen Editada Trasera",6=>"Imagenes de los Iconos");
	
	*	Que dice Yimmy? asi seria mas facil saber si es imagen alpha se peude borrar al igual que las imagenes que se tienen
	*	los unicos estados que van a tener mayor cantidad de imagenes van a ser el 2, 3 y muy posible 4
	*/
	if(array_key_exists("ImageRequest", $_FILES)){

		if($_POST['TiProduct']==2 || $_POST['TiProduct']==3 || $_POST['TiProduct']==6){
			// Con el Tiempo se deberá cambiar el metodo a subir varias imagenes

			for ($i=0;$i<count($_FILES["ImageRequest"]["name"]);$i++){ 
				$foo = new mCntrolMultiFileSave($_FILES["ImageRequest"],$_POST,$i);
			}

		}
		else{
			$foo = new mCntrolFileSave($_FILES["ImageRequest"],$_POST);
		}

		if(!$foo){ print("Problema Al Subir la Imagen Comunicate a Soporte"); }

	}else{ print("Se debe ingresar una imagen primero..."); }

	echo Editor_Admin::show_preimages($_POST['IdProduct'],$_POST['TiProduct']);

}
?>
