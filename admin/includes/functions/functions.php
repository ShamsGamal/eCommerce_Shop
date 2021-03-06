<?php
#####################################################
/*
** Get Title Function V1.0
** Title Function that Echo The Page Title In case 
** The Page Has The Variable $pageTitle And Echo Default Title For Other Pages
*/
#####################################################
function getAllFrom($field , $table , $where = Null , $and = Null , $orderfield , $ordering = 'DESC' ){
	global $con;
	
	$getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");
	$getAll->execute();
	$all = $getAll->fetchAll();
	return $all;
}
######################################################
function getTitle(){
	global $pageTitle ;
	if(isset($pageTitle)){
		echo $pageTitle ;
	}else{
		echo "Default";
	}
}

#####################################################
//Function Redirect //
/*
** Redirect Function V1.0
** Home Redirct Function [This Function Accept Parameter]
** $errorMSG = echo the error message
** $seconds  = seconds before Redircting
*/
/*function redirectHome ($errorMsg , $seconds = 3){
	echo "<div class='alert alert-danger'> $errorMsg </div>";
	echo "<div class='alert alert-info'> You Will Be Redirected to HomePage after $seconds Seconds </div>";
	header("refresh:$seconds;url=index.php");
	exit();
}*/
######################################################
/*
** Redirect Function V2.0
** TheMsg Redirct Function [This Function Accept Parameter]
** $theMsg = echo the  message [ error , success , warning ]
** $url = The Link You want to Redirct To
** $seconds  = seconds before Redircting
*/
function redirectHome ($theMsg , $url =  null , $seconds = 3){
	if( $url === null ){
		$url  = 'index.php';
		$link = 'Home Page';
	}else{


		if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){
			$url = $_SERVER['HTTP_REFERER'];
			$link = 'Previous Page';

        }else{
        	$url = 'index.php';
        	$link = 'Home Page';
        }


		
	}
	echo $theMsg ;
	echo "<div class='alert alert-info'> You Will Be Redirected to $link after $seconds Seconds </div>";
	header("refresh:$seconds;url=$url");
	exit();
}
#######################################################
/*
** Check Item Function V1.0
** Function To Check Items In Database [ Function Accept Parameter ]
** $select = The Item To Select [ Example : user , item , category  , .. ]
** $from   = The Table To select from [ Example : users , items , categories , ..]
** $value  = The value of select [ shams , box , .. ]
*/
function checkItem( $select , $from , $value){
	global $con ;
	$statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
	$statement->execute(array($value));
	$count = $statement->rowCount();
	return $count ;

}

#######################################################
/*
** Count Number of Items Function v1.0
** Function To Count Number Of Items Rows
** $item = The Item To Count
** $table = The Table To Choose From 
*/
function countItems($item , $table){
	  global $con ;
      $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");
      $stmt2->execute();
      return $stmt2->fetchColumn() ;
}
#######################################################
/*
** Get Latest Record Function v1.0
** Function To Get Latest Items From Database [ Users , Item , Comments , ..]
** $select = Field To Select
** $table  = Table To Choose From
** $order  = The Desc Ordering
** $limit  = Number Of Records To Get
*/
function getLatest($select , $table , $order , $limit){
	global $con;
	$getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
	$getStmt->execute();
	$rows = $getStmt->fetchAll();
	return $rows;
}




#######################################################





















