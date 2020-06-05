<?php
   session_start();
   $noNavbar = '' ;
   $pageTitle = 'Login'; //describe page title
   if(isset($_SESSION['Username'])){
   		header('Location: dashboard.php'); //Redirect To dashboard
     }
   include 'init.php' ;
   

    //Check if user comming from http request 
   if($_SERVER['REQUEST_METHOD'] == 'POST'){
       $username = $_POST['user'];
       $password = $_POST['pass'];
       $hashedPass = sha1($password);


       //Check if User Exist in the database 
       $stmt = $con->prepare("SELECT UserID ,Username , Password FROM users WHERE Username = ? AND Password = ? AND GroupID = 1 LIMIT 1");

       $stmt->execute(array($username , $hashedPass));
       $row = $stmt->fetch();
       $count = $stmt->rowCount();
      // echo $count ;
       //If Count > 0 This mean that database Contain Record 
       if($count > 0){
       $_SESSION['Username'] = $username ; //Register Session Name
       $_SESSION['ID']       = $row['UserID']; //Register Session ID
       	header('Location: dashboard.php'); //Redirect To dashboard
       	exit();
       // print_r($row);
       }
   }
?>

 
 <div class="login-admin">
 <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
 	<h2 class="text-center">Admin Login</h2>
 <input class="form-control" type="text" name="user" placeholder="Username" autocomplete ="off" />
 <input class="form-control"  type="password" name="pass" placeholder="Pssword" autocomplete="new-password" />
 <input class="btn btn-primary btn-block" type="submit" value="Login" />
 </form>
 </div>


<?php
   include $tpl . 'footer.php' ; 
?>