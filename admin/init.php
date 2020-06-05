<?php
include 'connect.php';
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

   //include Navbar on All Pages except Pages that have noNavbar
   if(!isset($noNavbar)) {  include $tpl . 'navbar.php'; }
   


