<?php
/*
      Categories
*/
      $do = ' ' ;
      if(isset($_GET['do'])){
      	$do = $_GET['do'];
      }
      else{
         $do = 'Manage';
      }
      //If The Page Is Main Page
      if($do == 'Manage'){
      	echo "Welcome This is The Manage Category Page";
      	echo '<a href="page.php?do=Add">Add New Category +</a>';

      }elseif($do == 'Add'){
      	echo "Welcome This is The Add Category Page";

      }elseif($do == 'Insert'){
      	echo "Welcome This is The Insert Category Page";
      	
      }else{
      	echo ' Error There is No Page With This Name';
      }