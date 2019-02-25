<?php
/*
	Plugin Name: Zalemto-Editor
	Plugin URI: https://htcolombia.com
	description: Plugin de edicion de productos para woocommerce
	Version: 1.0
	Author: Zalemto Studios
	Author URI: https://zalemto.com
	License: GPL2
*/

defined( 'ABSPATH' ) || exit;

global $wpdb;

function api_plugin_menu(){
	add_menu_page(
		'Editor de productos', //Titulo de la pagina
		'Editor de productos', //Titulo en el menu
		'edit_posts', //Rol de usuario
		'editor', //Sku en el menu
		'configurar_editor', //Funcion que llama
		'dashicons-admin-customizer'); //Icono
}
add_action('admin_menu','api_plugin_menu');

function configurar_editor(){
	require_once('includes/settings.php');
	include_once(SERV."/views/editor.php");
}
