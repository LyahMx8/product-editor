<?php

define('app_env', 'development');

ini_set('max_execution_time', 300);

// ***** Configurar el entorno ***
if(app_env == 'production'){
	define('api', 'apiProd.php');
	define('SERV', $_SERVER['DOCUMENT_ROOT']."/wp-content/plugins/zalemto-editor");
	define('URL', $_SERVER['HTTP_HOST']."/wp-content/plugins/zalemto-editor");
	define('URL_PB', "/wp-content/plugins/zalemto-editor");
}else{
	//Mostrar errores de php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	define('api', 'apiDevelop.php');
	define('SERV', $_SERVER['DOCUMENT_ROOT']."/wordpress/wp-content/plugins/zalemto-editor");
	define('URL', $_SERVER['HTTP_HOST']."/wordpress/wp-content/plugins/zalemto-editor");
	define('URL_PB', "/wordpress/wp-content/plugins/zalemto-editor");
}

include('functions.php');
//header('Content-type: application/json; charset=utf-8');