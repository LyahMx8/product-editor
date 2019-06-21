<?php

if ( !defined('ABSPATH') ) {
	//traer cuando wordprress cargue.
	include_once $_SERVER['DOCUMENT_ROOT'].'/wp-load.php';
	include_once  plugin_dir_path( dirname( __FILE__ ) ).'includes/settings.php';
}

global $wpdb;

$img = $_POST['imgfrn'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$fileData = base64_decode($img);
define('UPLOAD_DIR', SERV.'/personalizados/');
$fileName = UPLOAD_DIR.uniqid('created',false) . '.png';
file_put_contents($fileName, $fileData);

//WC()->cart->add_to_cart( $_POST['post'] );

$sql = ("INSERT INTO zalemto_editor_img (cmpidprdct, cmpidtipimg, cmpurlimg, cmpfechup) values ('".$_POST["post"]."','4','/personalizados/".uniqid('created',false).".png','".date("Y-m-d H:i:s")."')");
$wpdb->query($sql);

WC()->cart->add_to_cart( $_POST['post'], 1 );
//do_action( 'woocommerce_ajax_added_to_cart', $_POST['post'] );
