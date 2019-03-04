<?php
/**
*	@wordpress-plugin
*	Plugin Name: 	Zalemto-Editor
*	Plugin URI: 	https://htcolombia.com
*	description: 	Plugin de edicion de productos para woocommerce
*	Version: 		1.0
*	Author: 		Zalemto Studios
*	Author URI: 	https://zalemto.com
*	License: 		GPL2
*	License URI:	http://www.gnu.org/licenses/gpl-2.0.txt
*/

if (!defined('WPINC')) die;
defined( 'ABSPATH' ) || exit;

global $wpdb;
require plugin_dir_path( __FILE__ ) . 'includes/settings.php';

function api_plugin_menu(){
	$icon = W_URL . 'assets/img/zalemto-logo.png';
	add_menu_page(
		'Editar productos', //Titulo de la pagina
		'Editar productos', //Titulo en el menu
		'edit_posts', //Rol de usuario
		'editor', //Sku en el menu
		'configurar_editor', //Funcion que llama
		$icon); //Icono
}
add_action('admin_menu','api_plugin_menu');


function configurar_editor(){
	include_once(SERV."/views/editor.php");
}

add_action( 'woocommerce_before_add_to_cart_button', 'bbloomer_custom_action', 5 );
function bbloomer_custom_action(){
	?>
	<a onClick="openEditor()">Editar Producto</a>
	<script>
		function openEditor(){
			alert('Hello World!')
		}
	</script>
	<?php
}

