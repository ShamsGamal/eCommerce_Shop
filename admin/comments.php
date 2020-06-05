<?php
/*
========================================================================
== Manage Comment Page
== You Can Edit | Delete | Approve Comment From Here
==
========================================================================
                                                                       */

   session_start();
   $pageTitle = "Comments";
   if(isset($_SESSION['Username'])){
   		 
   	include 'init.php' ;

   	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;

   	
      
      // ##################Start Manage Page#################### //
      if($do == 'Manage'){ //Manage Page

        //Select All Comments Except Admin
        $stmt = $con->prepare("SELECT 
                                    comments .* , items.Name AS Item_Name  , users.Username AS Member
                               FROM 
                                    comments
                               INNER JOIN 
                                     items
                               ON     
                                      items.Item_ID = comments.item_id
                               INNER JOIN 
                                       users 
                                ON 
                                       users.UserID = comments.user_id
                                ORDER BY 
                                       c_id DESC");

        //Execute Statement
        $stmt->execute();

        //Assign to Variable
        $comments = $stmt->fetchAll();

        ?>
        <h1 class="text-center"> Manage Comments </h1>
          <div class="container">
            <div class="table-responsive">
               <table class="main-table text-center table table-bordered">
                 <tr>
                   <td>#ID</td>
                   <td>Comment</td>
                   <td>Item Name</td>
                   <td>User Name</td>
                   <td>Added Date</td>
                   <td>Control</td>
                 </tr>
                 <?php

                 foreach ($comments as $comment) {
                   
                   echo "<tr>";
                       echo "<td>" . $comment['c_id'] . "</td>" ;
                       echo "<td>" . $comment['comment'] . "</td>" ;
                       echo "<td>" . $comment['Item_Name'] . "</td>" ;
                       echo "<td>" . $comment['Member'] . "</td>" ;
                       echo "<td>" . $comment['comment_date'] . "</td>";
                      echo "<td>
                                 <a href=' comments.php?do=Edit&comid=". $comment['c_id'] ." '
                                  class='btn btn-success btn-block'>
                                  <i class='fa fa-edit'></i>Edit</a>

                                 <a href=' comments.php?do=Delete&comid=". $comment['c_id'] ." '
                                  class='btn btn-danger confirm btn-block'>
                                  <i class='fa fa-close'></i>Delete</a>";

                      if($comment['status'] == 0){
                        echo " <a href=' comments.php?do=Approve&comid=". $comment['c_id'] ." '
                                  class='btn btn-info activate btn-block'>
                                  <i class='fa fa-check'></i>Approve</a> " ;
                      }
                      

                        echo "</td>";

                   echo "</tr>";
                 }
                 ?>

                  </table>  
            </div>
             
      </div> <!-- End Div class = "container" || Manage -->

    <?php 
    /////////////////////////////////////////////////////////////////////////////////////////
    }elseif($do == 'Edit'){ //Edit Page 
       // Check If Get Request comid Is Numeric && Get The Integer Value Of it // comid => comment id
      $comid =  isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ; 
      //Select All Data From Database Depend on This ID
       $stmt = $con->prepare("SELECT * FROM comments WHERE c_id = ? ");
       //Excute Query 
       $stmt->execute(array($comid));
       //Fetch Data
       $row = $stmt->fetch();
       //The Row Count 
       $count = $stmt->rowCount();
       //////////////////////////If There Is Such ID Show The Form ///////////////////////////
       if($count > 0){ ?>
       	   <!-- Exist ID Such That In The Database  -->
       	  <h1 class="text-center"> Edit Comment </h1>
      	  <div class="edit-comment container">
      	  	<form class="form-horizontal" action="?do=Update" method="POST">
      	  		<input type="hidden" name="comid" value=" <?php echo $comid ; ?> " />
      	  		<!-- Start Comment Field -->
      	  		<div class="form-group form-group-lg">
      	  			<label class="col-sm-2 control-label">Comment</label>
      	  			<div class="col-sm-10 col-md-6">
      	  				 <textarea class="form-control" name="comment"> 
                             <?php echo $row['comment']; ?> 
                    </textarea>
      	  			</div>
      	  		</div>
      	  		<!-- End Comment Field -->
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
      echo " <h1 class='text-center'> Update Comment </h1> ";
      echo "<div class='container'>";

  	 	//Get Variables From The Form
  	 	$comid    = $_POST['comid'];
  	 	$comment  = $_POST['comment'];
  	 	

      //Update The Database With This New Comment if There is No Error
       $stmt = $con->prepare("UPDATE  comments SET comment = ?  WHERE c_id = ?");
        $stmt->execute(array($comment , $comid));

      //Echo Success Message 
        $theMsg  = "<div class='alert alert-success'>" . $stmt->rowCount() . "Record Updated </div>" ;

        redirectHome($theMsg , 'back');

       //End Update in Database
    }else{
      echo "<div class='container'>";
  	 	$theMsg =  "<div class='alert alert-danger'>Sorry ! , You Cannot Browse This Page Directly</div>";
      redirectHome($theMsg , 'back');
      echo "</div>";
  	 }
     echo "</div>";

  //// ############################################################ ////
  }elseif($do == 'Delete'){//Delete Comment Page
    
    // Check If Get Request comid Is Numeric && Get The Integer Value Of it // comid => comment id
      $comid =  isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ; 
       

      //Select All Data From Database Depend on This ID
       $check = checkItem( 'c_id' , 'comments' , $comid);
      

       
    ////////////////////////// Database Statement  ///////////////////////////
       if($check > 0){ 
        $stmt = $con->prepare("DELETE FROM comments WHERE c_id = :zid");

        $stmt->bindParam(":zid" , $comid);
        $stmt->execute();


       //Echo Success Message 
        echo "<div class='container'>";
        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . "Comment Deleted </div>" ;
        redirectHome ($theMsg , 'back');
        echo "</div>";


       }else{
        echo "<div class='container'>";
        $theMsg = "<div class='alert alert-danger'>Sorry ! This ID Not Exist</div>";
        redirectHome ($theMsg);
        echo "</div>";
       }
       
     ///////////////////////////////// End Delete Comment Page /////////////////////////

   }elseif($do == 'Approve'){ 
    // ########################## Start Approve Page ############################## //
      
        echo " <h1 class='text-center'> Approve Comment </h1> ";
        echo "<div class='container'>";
        
        
      // Check If Get Request UserID Is Numeric && Get The Integer Value Of it 
      $comid =  isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ; 
       

      //Select All Data From Database Depend on This ID
       $check = checkItem( 'c_id' , 'comments' , $comid);
       
      ////////////////////////// Database Statement  ///////////////////////////
       if($check > 0){ 

        $stmt = $con->prepare("UPDATE comments SET status = 1 WHERE c_id = ?");
        $stmt->execute(array($comid));


       //Echo Success Message 
        echo "<div class='container'>";
        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . "Comment Approved </div>" ;
        redirectHome ($theMsg , 'back');
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