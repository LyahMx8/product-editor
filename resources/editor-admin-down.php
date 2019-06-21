<?php 
if ( !defined('ABSPATH') ) {
	//traer cuando wordprress cargue.
	include_once $_SERVER['DOCUMENT_ROOT'].'/wp-load.php';
	include_once  plugin_dir_path( dirname( __FILE__ ) ).'includes/settings.php';
}

$fecha = date("Y-m-d H:i:s");
if($_SERVER["REQUEST_METHOD"]=="POST"){
	/* 
	* Ya definila consulta en functions ahora se puede almacenar las imagenes con este array para definir si es frontal o algo 
	* asi....

		@$array_imagen_tipo=array(0=>"Imagen Alpha Frontal",1=>"Imagen Alpha Trasera",2=>"Imagenes Frontales",3=>"Imagenes Traseras", 4=>"Imagen Editada Frontal" 5=>"Imagen Editada Trasera" 6=>"Iconos");
	
	*	Que dice Yimmy? asi seria mas facil saber si es imagen alpha se peude borrar al igual que las imagenes que se tienen
	*	los unicos estados que van a tener mayor cantidad de imagenes van a ser el 2, 3 y muy posible 4
	*/

	global $wpdb;

	if(!empty($_POST['down'])){
		
		$result = $wpdb->get_row("SELECT cmpidprdct,cmpidtipimg,cmpurlimg FROM zalemto_editor_img WHERE cmpidimg = ".$_POST['down'],ARRAY_A);

		$wpdb->query("DELETE FROM zalemto_editor_img WHERE cmpidimg = ".$_POST['down']); unlink(SERV."/".$result['cmpurlimg']);

		$_access_img=!array_key_exists("icon",$_POST) ? 2 : 6; echo Editor_Admin::show_preimages($result['cmpidprdct'],$_access_img);
	}
}
?>
