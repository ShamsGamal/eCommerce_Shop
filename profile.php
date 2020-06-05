<?php
   session_start();
   $pageTitle = 'Profile'; //describe page title
   include 'init.php' ;
   if(isset($_SESSION['user'])){
      $getUser = $con->prepare("SELECT * FROM users WHERE Username = ?");
      $getUser->execute(array($sessionUser));
      $info = $getUser->fetch();
      $userid = $info['UserID'];
      

   
   ?>
   <!--<h1 class="text-center">My Profile</h1>-->
    <h1 class="text-center">Your Profile</h1>
    <!--                                    #1#                    -->
   	<div class="information block">
   		<div class="container">
   			<div class="card card-primary">
   				<div class="card-header">Personal Information</div>
   				<div class="card-body">
                  <ul class="list-unstyled">
   					        <li>
                      <i class="fa fa-unlock-alt fa-fw"></i>
                      <span>Login Name</span> : <?php echo $info['Username'];  ?>
                    </li>  
                    <li>
                      <i class="fa fa-envelope-o fa-fw"></i>
                      <span>Email</span> : <?php echo $info['Email'];  ?>  
                    </li>
                    <li>
                      <i class="fa fa-user fa-fw"></i>
                      <span>Full Name</span> : <?php echo $info['FullName'];  ?>
                    </li>  
                    <li>
                      <i class="fa fa-calendar fa-fw"></i>
                      <span>Register Date</span> : <?php echo $info['Date'];  ?>
                    </li>  
                    <!--<li>
                      <i class="fa fa-tags fa-fw"></i>
                      <span>Fav Category</span> : 
                    </li> -->
                 </ul>
                 <a href="#" class="btn btn-default">Edit Information</a>




   					
   				</div>
   			</div>
   	    </div>
   </div>
   <!--                                    #2#                    -->
   <div id="my-ads" class="my-ads block">
   		<div class="container">
   			<div class="card card-primary">
   				<div class="card-header">My Items</div>
   				<div class="card-body">
   					<!-- Start Ads -->
                   
  <?php
     $myItems = getAllFrom("*","items","where Member_ID = $userid","", "Item_ID");
                       if(!empty($myItems)){
                        echo '<div class="row">';
                     foreach ($myItems as $item ) {
                          echo '<div class="col-lg-4 col-sm-6">';
                          echo '<div class="thumbnail item-box">' ;
                          if($item['Approve'] == 0){ 
                            echo '<span class="approve-status">Waiting , Approval</span>';

                          }


                          echo '<span class="price-tag"> $' . $item['Price'] . '</span>';

                          if(empty($item['image'])){
                  echo "<img src='admin/uploads/avatars/mouse-01.jpg' 
                             class='img-responsive img-thumbnail center-block img-circle'
                             style='width:250px; height:210px;'>";
                  }else{
                  echo "<img src='admin/uploads/avatars/" . $item['image'] . "'style='width:250px; height:210px;' class='img-responsive img-thumbnail center-block img-circle' alt=''/>";
                  }



                          echo '<div class="caption ">';
                          echo '<h3 class="pro-header">
                          <a href="items.php?itemid= '. $item['Item_ID'] .' ">' . $item['Name'] . '</a>
                                </h3>'; 
                          echo '<p class="lead pro-info">' . $item['Description'] . '</p>';
                          echo '<div class="date">' . $item['Add_Date'] . '</div>';
                          echo '</div>';
                          echo '</div>';
                          echo '</div>';
                              }
                              echo '</div>';
                            }else{
                              
                              echo 'There Is No Ads To Show , Create 
                                           <a href="newad.php">New Ad</a>';
                            }
                     ?>
                 


                  <!-- End Ads -->
   					
   				</div>
   			</div>
   	    </div>
   </div>
<!--                                    #3#                    -->
<div class="my-comments block">
   		<div class="container">
   			<div class="card card-primary">
   				<div class="card-header">My Latest Comment</div>
   				<div class="card-body">
   					<!-- Start Comments  -->
                  <?php
 $myComments = getAllFrom("comment" ,"comments" , "where user_id = $userid" , "" , "c_id");
            if(!empty($myComments)){
               foreach ($myComments as $comment) {
                  echo "<p>" . $comment['comment'] . "</p>";
               }

             }else{
               echo "There's No Comments To Show";
             }


                 ?>
                  <!-- End Comments -->
   					
   				</div>
   			</div>
   	    </div>
   </div>
<!--                                    ##                    -->

<?php
  }else{
      header('Location: login.php');
      exit();
  }
   include $tpl . 'footer.php' ; 
?>