<?php
/*
========================================================================
== Manage Members Page
== You Can Add | Edit | Deleter Member From Here
==
========================================================================
                                                                       */

   session_start();
   $pageTitle = "Members";
   if(isset($_SESSION['Username'])){
   		 
   	include 'init.php' ;

   	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;

   	
      
      // ##################Start Manage Page#################### //
      if($do == 'Manage'){ //Manage Page

        $query = '';
        if(isset($_GET['page']) && $_GET['page'] == 'pending'){
            $query = ' AND RegStatus = 0 ';
        }

        //Select All Usera Except Admin
        $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query ORDER BY UserID DESC");

        //Execute Statement
        $stmt->execute();

        //Assign to Variable
        $rows = $stmt->fetchAll();
        if(!empty($rows)){
          ?>
        <h1 class="text-center"> Manage Members </h1>
          <div class="container">
            <div class="table-responsive">
               <table class="main-table manage-members text-center table table-bordered">
                 <tr>
                   <td>#ID</td>
                   <td>Image</td>
                   <td>Username</td>
                   <td>Email</td>
                   <td>Full Name</td>
                   <td>Registered Date</td>
                   <td>Control</td>
                 </tr>
                 <?php

                 foreach ($rows as $row) {
                   
                   echo "<tr>";
                       echo "<td>" . $row['UserID'] . "</td>" ;
                       echo "<td>";
                       if(empty($row['avatar'])){
                        echo "<img src='uploads/avatars/marwa.jpg'>";
                       }else{
                       echo "<img src='uploads/avatars/" . $row['avatar'] . "' alt=''/>";
                     }
                       echo "</td>" ;
                       echo "<td>" . $row['Username'] . "</td>" ;
                       echo "<td>" . $row['Email'] . "</td>" ;
                       echo "<td>" . $row['FullName'] . "</td>" ;
                       echo "<td>" . $row['Date'] . "</td>";
                       echo "<td>
                                 <a href=' members.php?do=Edit&userid=". $row['UserID'] ." '
                                  class='btn btn-success btn-block'>
                                  <i class='fa fa-edit'></i>Edit</a>

                                 <a href=' members.php?do=Delete&userid=". $row['UserID'] ." '
                                  class='btn btn-danger confirm btn-block'>
                                  <i class='fa fa-close'></i>Delete</a>";

                      if($row['RegStatus'] == 0){
                        echo " <a href=' members.php?do=Activate&userid=". $row['UserID'] ." '
                                  class='btn btn-info activate btn-block'>
                                  <i class='fa fa-check'></i>Activate</a> " ;
                      }
                      

                        echo "</td>";

                   echo "</tr>";
                 }
                 ?>

                  </table>  
            </div>
            <a href='members.php?do=Add' class="btn btn-member">
              <i class="fa fa-plus"></i> 
              New Member </a>

      </div> <!-- End Div class = "container" || Manage -->
    <?php }else{
      echo '<div class="container">';
            echo '<div class="nice-message"> There Is No Members To Show </div>';
            echo "<a href='members.php?do=Add' class='btn btn-primary'>
              <i class='fa fa-plus'></i> 
              New Member </a>";
      echo '</div>';
    } ?>

     <!-- ########################################  -->
     <?php }elseif ($do == 'Add') { // Add New Member ?>
        
        <h1 class="text-center"> Add New Member </h1>
          <div class="add-member container">
        <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
              
              <!-- Start Username Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Username</label>
                <div class="col-sm-10 col-md-6">
                  <input type="text" name="username" class="form-control" 
                            autocomplete="off"  required="required" 
                            placeholder="Username To Login into Shop" />
                </div>
              </div>
              <!-- End Username Field -->

              <!-- Start Password Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10 col-md-6">
                
                <input type="password" name="password" class="password form-control" 
                       autocomplete="new-password" required="required"
                       placeholder="Password must be Hard && Complex"/>
                <i class="show-pass fa fa-eye fa-2x"></i>
                </div>
              </div>
              <!-- End Password Field -->

              <!-- Start Email Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10 col-md-6">
                  <input type="email" name="email"  
                         class="form-control" autocomplete="off" required="required"
                         placeholder="Email Must Be Valid" />
                </div>
              </div>
              <!-- End Email Field -->

              <!-- Start Fullname Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Full Name</label>
                <div class="col-sm-10 col-md-6">
                  <input type="text" name="full" 
                         class="form-control" required="required"
                         placeholder="Fullname Appear in Profile Page" />
                </div>
              </div>
              <!-- End Fullname Field -->

               <!-- Start Avatar Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">User Image</label>
                <div class="col-sm-10 col-md-6">
                  <input type="file" name="avatar" 
                         class="form-control"/>
                </div>
              </div>
              <!-- End Avatar  Field -->


              <!-- Start Submit Button -->
              <div class="form-group form-group-lg">
                
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="Submit" value="Add Member" class="btn btn-primary btn-member" />
                </div>
              </div>
              <!-- End Submit Button -->
                </form>
          </div> <!-- End Div Class=Countainer || Add Page -->
        

                                          <!-- ### -->

    <?php 
    }elseif($do == 'Insert'){
       //Insert New Member Page

      if ($_SERVER['REQUEST_METHOD'] == 'POST'){
      echo " <h1 class='text-center'> Update Member </h1> ";
      echo "<div class='container'>";
      //Upload Variable
      $avatarName = $_FILES['avatar']['name'];
      $avatarType = $_FILES['avatar']['type'];
      $avatarTmp  = $_FILES['avatar']['tmp_name'];
      $avatarSize = $_FILES['avatar']['size'];  
      //List Of Allowed Type Files To Upload
      $avatarAllowedExtension = array("jpeg" , "jpg" , "png" , "gif");
      //Get Avatar Extension

      

      $ex_name = explode('.', $avatarName);
      $end_name = end($ex_name);
      $avatarExtension = strtolower($end_name);
      

      //Get Variables From The Form
       
      $user  = $_POST['username'];
      $pass  = $_POST['password'];
      $email = $_POST['email'];
      $name  = $_POST['full'];

      $hashPass = sha1($_POST['password']); //hased Password
      

      //Validate The Form
      $formErrors = array();
      if(strlen($user) < 4){
        $formErrors[] = 'Username can not be less than <strong>4 character !</strong>'; 
        
      }

      if(strlen($user) > 20){
        $formErrors[] = 'Username can not be more than <strong>20 character  !</strong>';
        
      }


      if(empty($user)){
        $formErrors[] = 'Username can not be <strong>empty !</strong>'; 
        
        }

      if(empty($pass)){
        $formErrors[] = 'Password can not be <strong>empty !</strong>'; 
        
        }
      if(empty($name)){
        $formErrors[] = 'Name can not be <strong>empty !</strong>';
        
      }
      if(empty($email)){
        $formErrors[] = 'Email can not be <strong>empty !</strong>';

      }
      if(!empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)){
         $formErrors[] = 'This Extention Is Not<strong>Allowed !</strong>';
      }
      if(empty($avatarName)){
         $formErrors[] = 'Image Is <strong>Required !</strong>';
      }
      if($avatarSize > 4194304){
         $formErrors[] = 'Image Can Not Be <strong>4MB !</strong>';
      }//Loop Error Array And echo  it 
      foreach($formErrors as $error) {
         
        echo '<div class="alert alert-danger">' . $error  . '</div>' ;
         
      
      }

       
      
      if(empty($formErrors)){
         
        $avatar = rand(0 , 1000000) . '_' . $avatarName ;
        move_uploaded_file($avatarTmp , "uploads\avatars\\" . $avatar );
       
      //Check If User Exist in Database checkItem
       $check = checkItem( "Username" , "users" , $user);
       if($check == true){

        $theMsg = "<div class='alert alert-danger'>Sorry , This Username Exist</div>";
        redirectHome ($theMsg , 'back');
       }else{

      //Inser User Info in Databse 
      $stmt = $con->prepare("INSERT INTO 
                            users(Username , Password , Email , FullName , RegStatus , Date , avatar)
                            VALUES(:zuser , :zpass , :zmail , :zname , 1 , now() , :zavatar) ");
      $stmt->execute(array(

          'zuser'   => $user     ,
          'zpass'   => $hashPass ,
          'zmail'   => $email    ,
          'zname'   => $name     ,
          'zavatar' => $avatar

      ));
         

      //Echo Success Message 
      
      $theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . "Record Inserted </div>" ;
      redirectHome($theMsg , 'back' );
     
      }
      

      } //End Insert in Database
      
      

     }else{
      echo "<div class='container'>";
      $theMsg =  '<div class="alert alert-danger" > 
                    Sorry ! , You Cannot Browse This Page Directly
                    </div>';
      redirectHome($theMsg);
       echo "</div>";


     }
     echo "</div>"; // End Insert Page

     
    /////////////////////////////////////////////////////////////////////////////////////////
    }elseif($do == 'Edit'){ //Edit Page 
       // Check If Get Request UserID Is Numeric && Get The Integer Value Of it 
      $userid =  isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ; 
      //echo $userid ;
      //Select All Data From Database Depend on This ID
       $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ?  LIMIT 1");
       //Excute Query 
       $stmt->execute(array($userid));
       //Fetch Data
       $row = $stmt->fetch();
       //The Row Count 
       $count = $stmt->rowCount();
       //////////////////////////If There Is Such ID Show The Form ///////////////////////////
       if($count > 0){ ?>
       	   <!-- Exist ID Such That In The Database  -->
       	  <h1 class="text-center"> Edit Member Profile</h1>
      	  <div class="edit-member container">
      	  	<form class="form-horizontal" action="?do=Update" method="POST">
      	  		<input type="hidden" name="userid" value=" <?php echo $userid ; ?> " />
      	  		<!-- Start Username Field -->
      	  		<div class="form-group form-group-lg">
      	  			<label class="col-sm-2 control-label">Username</label>
      	  			<div class="col-sm-10 col-md-6">
      	  				<input type="text" name="username" class="form-control" 
      	  				       value="<?php echo $row['Username']; ?>"  
      	  				       autocomplete="off"  required="required" />
      	  			</div>
      	  		</div>
      	  		<!-- End Username Field -->

      	  		<!-- Start Password Field -->
      	  		<div class="form-group form-group-lg">
      	  			<label class="col-sm-2 control-label">Password</label>
      	  			<div class="col-sm-10 col-md-6">
      	  			<input type="hidden" name="oldpassword" value=" <?php echo $row['Password']; ?> " />
      	  			<input type="password" name="newpassword" class="form-control" 
      	  			       autocomplete="new-password" 
                       placeholder="Leave Blank If You do not want To Add New Password"/>
      	  			</div>
      	  		</div>
      	  		<!-- End Password Field -->

      	  		<!-- Start Email Field -->
      	  		<div class="form-group form-group-lg">
      	  			<label class="col-sm-2 control-label">Email</label>
      	  			<div class="col-sm-10 col-md-6">
      	  				<input type="email" name="email" value="<?php echo $row['Email']; ?>" 
      	  				       class="form-control" autocomplete="off" required="required" />
      	  			</div>
      	  		</div>
      	  		<!-- End Email Field -->

      	  		<!-- Start Fullname Field -->
      	  		<div class="form-group form-group-lg">
      	  			<label class="col-sm-2 control-label">Full Name</label>
      	  			<div class="col-sm-10 col-md-6">
      	  				<input type="text" name="full"  value="<?php echo $row['FullName']; ?>" 
      	  				       class="form-control" required="required"/>
      	  			</div>
      	  		</div>
      	  		<!-- End Fullname Field -->

      	  		<!-- Start Submit Button -->
      	  		<div class="form-group form-group-lg">
      	  			
      	  			<div class="col-sm-offset-2 col-sm-10">
      	  				<input type="Submit" value="Save" class="btn btn-primary" />
      	  			</div>
      	  		</div>
      	  		<!-- End Submit Button -->
                </form>
      	  </div> <!-- End Div Class=Countainer || Edit Page -->
      

      <?php 
      }else{    /////////////////// If There Is No Such ID Show Error Message //////////////////////
            echo "<div class='container'>";
            $theMsg =  "<div class='alert alert-danger'> Sorry ! , There Is No Such ID ..</div> " ;
            redirectHome($theMsg);
            echo "</div>";
      }
      /////////////////////////////////End Check Count//////////////////////////////////////////////

  } elseif ($do == 'Update') { //Update Page
  	 


  	 
  	 if ($_SERVER['REQUEST_METHOD'] == 'POST'){
      echo " <h1 class='text-center'> Update Member </h1> ";
      echo "<div class='container'>";

  	 	//Get Variables From The Form
  	 	$id    = $_POST['userid'];
  	 	$user  = $_POST['username'];
  	 	$email = $_POST['email'];
  	 	$name  = $_POST['full'];
  	 	

         
  	 	//Password Trick
  	 	$pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword'])  ;
  	 	
  	 	//Validate The Form
  	 	$formErrors = array();
  	 	if(strlen($user) < 4){
  	 		$formErrors[] = 'Username can not be less than <strong>4 character !</strong>'; 
        
  	 	}

      if(strlen($user) > 20){
        $formErrors[] = 'Username can not be more than <strong>20 character  !</strong>';
        
      }


  	 	if(empty($user)){
  	 		$formErrors[] = 'Username can not be <strong>empty !</strong>'; 
        
  	 		}
  	 	if(empty($name)){
  	 		$formErrors[] = 'Name can not be <strong>empty !</strong>';
        
  	 	}
  	 	if(empty($email)){
  	 		$formErrors[] = 'Email can not be <strong>empty !</strong>';

  	 	}//Loop Error Array And echo it 
  	 	foreach($formErrors as $error) {
         
  	 		echo '<div class="alert alert-danger">' . $error . '</div>'  ;
         
  	 	
  	 	}

  	 	 
      //Update The Database With This Information if There is No Error
      if(empty($formErrors)){
        $stmt2 = $con->prepare("SELECT * FROM users WHERE  Username = ? AND UserID != ?");
        $stmt2->execute(array($user , $id ));
        $count = $stmt2->rowCount();
        echo $count;
        if($count == 1){
          $theMsg = "<div class='alert alert-danger'> Sorry , This User Is Exist </div>";
          redirectHome($theMsg , 'back');
        }else{
          //echo "update";
        
        $stmt = $con->prepare("UPDATE users SET Username = ? , Email = ? , FullName = ? , Password = ?
                             WHERE UserID = ?");
        $stmt->execute(array($user , $email , $name , $pass , $id));

      //Echo Success Message 
        $theMsg  = "<div class='alert alert-success'>" . $stmt->rowCount() . "Record Updated </div>" ;

        redirectHome($theMsg , 'back');

      } //End Update in Database
      } 

  	 }else{
      echo "<div class='container'>";
  	 	$theMsg =  "<div class='alert alert-danger'>Sorry ! , You Cannot Browse This Page Directly</div>";
      redirectHome($theMsg , 'back');
      echo "</div>";
  	 }
     echo "</div>";

  //// ############################################################ ////
  }elseif($do == 'Delete'){//Delete Member Page
    
    // Check If Get Request UserID Is Numeric && Get The Integer Value Of it 
      $userid =  isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ; 
       

      //Select All Data From Database Depend on This ID
       $check = checkItem( 'userid' , 'users' , $userid);
       //echo $check;

       
    ////////////////////////// Database Statement  ///////////////////////////
       if($check > 0){ 
        $stmt = $con->prepare("DELETE FROM users WHERE UserID = :zuser");

        $stmt->bindParam(":zuser" , $userid);
        $stmt->execute();


       //Echo Success Message 
        echo "<div class='container'>";
        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . "Record Deleted </div>" ;
        redirectHome ($theMsg , 'back');
        echo "</div>";


       }else{
        echo "<div class='container'>";
        $theMsg = "<div class='alert alert-danger'>Sorry ! This ID Not Exist</div>";
        redirectHome ($theMsg);
        echo "</div>";
       }
       
     ///////////////////////////////// End Delete Member Page /////////////////////////

   }elseif($do == 'Activate'){ 
    // ########################## Start Activate Page ############################## //
      
        echo " <h1 class='text-center'> Activate Member </h1> ";
        echo "<div class='container'>";
        echo "Welcome From Activate Page";
        
      // Check If Get Request UserID Is Numeric && Get The Integer Value Of it 
      $userid =  isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ; 
       

      //Select All Data From Database Depend on This ID
       $check = checkItem( 'userid' , 'users' , $userid);
       
      ////////////////////////// Database Statement  ///////////////////////////
       if($check > 0){ 

        $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");
        $stmt->execute(array($userid));


       //Echo Success Message 
        echo "<div class='container'>";
        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . "Record Updated </div>" ;
        redirectHome ($theMsg);
        echo "</div>";


       }else{
        echo "<div class='container'>";
        $theMsg = "<div class='alert alert-danger'>Sorry ! This ID Not Exist</div>";
        redirectHome ($theMsg);
        echo "</div>";
       }//End Activate Page
       //  ############################ End Active Page ######################### //
   }




   	 include $tpl . 'footer.php' ; 
     }else{
     	
     	header('Location: index.php');
     	exit();
     }