<?php 
if ( !defined('ABSPATH') ) {
    //If wordpress isn't loaded load it up.
    $path = $_SERVER['DOCUMENT_ROOT']."/wordpress";
    include_once $path . '/wp-load.php';
    include_once $path."/wp-content/plugins/edicion-de-productos/includes/settings.php";
}
if($_SERVER["REQUEST_METHOD"]=="POST"){ 
	//$foo = new mCntrolFileSave(); print_r($_FILES);
	print_r($_FILES);
	print("<br>");
	?>

<?php } ?>
