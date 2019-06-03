<?php

if ( !defined('ABSPATH') ) {
	//traer cuando wordprress cargue.
	include_once $_SERVER['DOCUMENT_ROOT'].'/wordpress/wp-load.php';
	include_once  plugin_dir_path( dirname( __FILE__ ) ).'includes/settings.php';
}

global $wpdb;

$img = $_GET['imgfrn'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$fileData = base64_decode($img);
$fileName = 'public://' . uniqid() . 'myCanvas.png';
$carpeta_destino = URL_PB.'/productos/';
//imagepng($img,$carpeta_destino.$fileName);
file_put_contents('image_file', base64_decode($img));

$sql = ("INSERT INTO zalemto_editor_img (cmpidprdct, cmpidtipimg, cmpurlimg, cmpfechup) values ('".$_GET["post"]."','4','".$fileName."','".date("Y-m-d H:i:s")."')");
$wpdb->query($sql);
