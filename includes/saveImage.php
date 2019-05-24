<?php

include( $_SERVER['DOCUMENT_ROOT'] . '/wordpress/wp-load.php');

		global $wpdb;

		$img = $_GET['imgfrn'];
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$fileData = base64_decode($img);
		$fileName = 'public://' . uniqid() . 'myCanvas.png';
		$carpeta_destino = $_SERVER['DOCUMENT_ROOT'].'/wordpress/wp-content/plugins/edicion-de-productos/productos/';
		//imagepng($img,$carpeta_destino.$fileName);
		file_put_contents('image_file', base64_decode($img));

		$sql = ("INSERT INTO zalemto_editor_img (cmpidprdct, cmpidtipimg, cmpurlimg, cmpfechup) values ('".$_GET["post"]."','4','".$fileName."','".date("Y-m-d H:i:s")."')");
		$wpdb->query($sql);
