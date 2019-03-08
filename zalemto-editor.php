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


require plugin_dir_path( __FILE__ ) . 'includes/settings.php';


/**
 * Ejecución del plugin.
 *
 * Mantener todos los recursos del plugin via hooks
 *
 * @since    1.0
 */
function run_editor() {

	$plugin = new Settings();
	$plugin->run();

}

run_editor();
