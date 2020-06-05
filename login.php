<?php
   ob_start();
   session_start();
   $pageTitle = 'Login'; //describe page title
   if(isset($_SESSION['user'])){
   		header('Location: index.php'); //Redirect To Homepage
     }
   include 'init.php';
   #######################################################################################################
   //Check if user comming from http request 
   if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['login'])){




       $user = $_POST['username'];
       $pass = $_POST['password'];
       //echo $user . "<br />" . $pass ;
       
       $hashedPass = sha1($pass);


       //Check if User Exist in the database 
      $stmt = $con->prepare("SELECT 
                                 UserID , Username , Password 
                             FROM 
                                 users 
                            WHERE Username = ? 
                            AND Password = ? ");

       $stmt->execute(array($user , $hashedPass));
       $get = $stmt->fetch();
       $count = $stmt->rowCount();
      
       //If Count > 0 This mean that database Contain Record 
       if($count > 0){
       $_SESSION['user'] = $user ; //Register Session Name
       $_SESSION['uid']  = $get['UserID'] ; //Register User ID
       header('Location: index.php'); //Redirect To dashboard
       exit();
      // print_r($_SESSION);
       }
     }else {
      #code..
       $formErrors = array()           ;
       $username   = $_POST['username'];
       $password   = $_POST['password'];
       $password2   = $_POST['password2'];
       $email      = $_POST['email']   ;







                            // UserName //
       if(isset($username)){
          $filterUser = filter_var($username , FILTER_SANITIZE_STRING);
          if (strlen($filterUser) < 4){
            $formErrors[] = 'username must be greater than 4 character';
          }
        }
                          // End UserName //
                          // Password    //


        if(isset($password) && isset($password2)){
         // $filterUser = filter_var($_POST['username'] , FILTER_SANITIZE_STRING);
          if(empty($password)){
            $formErrors[] = "Sorry , Password Can not be Empty";
          }

           // $pass1 = sha1($password)  ;
          // $pass2 = sha1($password2) ;
          if(sha1($password) !== sha1($password2)){
            $formErrors[] = "Sorry ,Password Not Match" ;

          }

        }
                         // End Password //
                            // Email //
        if(isset($email)){
          $filterEmail = filter_var($email , FILTER_SANITIZE_EMAIL);
          if(filter_var($filterEmail , FILTER_VALIDATE_EMAIL) != true){
              $formErrors[] = "This Email Is Not Valide" ;


        }
                          // End Email //
          }
          #################### Start Add User to Database #######################
          //If There Is No Error Proceed The User Add
          if(empty($formErrors)){
      //Check If User Exist in Database checkItem
       $check = checkItem( "Username" , "users" , $username);
       if($check == true){

       // $theMsg = "<div class='alert alert-danger'>Sorry , This Username Exist</div>";
         $formErrors[] = "Sorry , This User Is Exist" ;

        
       }else{

      //Inser User Info in Databse 
      $stmt = $con->prepare("INSERT INTO 
                            users(Username , Password , Email ,  RegStatus , Date)
                            VALUES(:zuser , :zpass , :zmail , 0 , now()) ");
      $stmt->execute(array(

          'zuser' => $username       ,
          'zpass' => sha1($password) ,
          'zmail' => $email    
          

      ));
         

      //Echo Success Message 
      $successMsg = 'Congrate You Are Now Registered User';
      
       
       
     
      }
      

      } //End Insert in Database
      



             ##################       End Add User to Database     ####################
     }
   }

     #####################################################################################################
   ?>
   <!--                         Start Login Form                   -->
   <div class="container login-page">
   	<h1 class="text-center">
   		<span class="selected col-b" data-class="login">Login</span> | 
   		<span data-class="signup" class="col-g">Signup</span></h1>
   	 <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
   	 	<input class="form-control" 
   	 	       type="text" 
   	 	       name="username" 
   	 	       autocomplete="off" 
   	 	       placeholder="Username" />

   	 	<input class="form-control" 
   	 	       type="password" 
   	 	       name="password" 
   	 	       autocomplete="new-password" 
   	 	       placeholder="Password" />

   	 	<input class="btn btn-primary btn-block" 
   	 	       type="submit" 
             name="login"
   	 	       value="Login" />
   	 </form>
 <!--                         End Login  Form                    -->
 <!--                         Start Signup  Form                    -->
   	 <form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
   	 	<input  
             class="form-control" 
   	 	       type="text" 
   	 	       name="username" 
   	 	       autocomplete="off" 
   	 	       placeholder="Username" />
             

   	 	<input  
             class="form-control" 
   	 	       type="password" 
   	 	       name="password" 
   	 	       autocomplete="new-password" 
   	 	       placeholder="Password" />
              

   	 	<input class="form-control" 
   	 	       type="password" 
   	 	       name="password2" 
   	 	       autocomplete="new-password" 
   	 	       placeholder="Enter Password Again" />

   	 	<input class="form-control" 
   	 	       type="email" 
   	 	       name="email" 
   	 	       placeholder="Enter a Valid Email" />

   	 	<input class="btn btn-success btn-block" 
   	 	       type="submit"
             name="signup" 
   	 	       value="Signup" />
   	 </form>


<!--                         End signup  Form                    -->

<div class="the-errors text-center">
  <?php
      if (!empty($formErrors)) {
        foreach ($formErrors as $error) {
          echo $error . "<br />" ;
        }

      }


      if(isset($successMsg)){
        echo '<div class="msg success">' . $successMsg . '</div>';

      }


  ?>
       
  </div>
    

  </div>
<?php
   include $tpl . 'footer.php' ; 
   ob_end_flush();
   ?>