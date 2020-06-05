<?php
//Error Reportering
ini_set('display_errors', 'On');
error_reporting(E_ALL);



include 'admin/connect.php';
$sessionUser = '';
if(isset($_SESSION['user'])){
	$sessionUser = $_SESSION['user'] ;
}
//Routes
$tpl  = 'includes/templates/'; //Template Directory
$lang = 'includes/languages/' ; //Language Directory
$func = 'includes/functions/'; //Function Directory
$css = 'layout/css/' ; //CSS Directory
$js = 'layout/js/' ; //JS  Directory


//Include The Important File
   include $func . 'functions.php';
   include $lang . 'english.php';
   include $tpl . 'header.php' ;
    