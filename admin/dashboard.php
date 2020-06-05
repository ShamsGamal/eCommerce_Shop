<?php
   ob_start(); //Output Buffering Start 
   session_start();
   if(isset($_SESSION['Username'])){
   		
    $pageTitle = 'Dashboard'; //describe page title
   	include 'init.php' ;
    
    /* Start Dashboard */
    $numUsers = 4 ; //Number Of Latest User
    $latestUsers = getLatest("*" , "users" , "UserID" , $numUsers); //Latest User Array

    $numItems = 4; //Number Of Latest Items
    $latestItems = getLatest("*" , "items" , "Item_ID" , $numItems ); //Latest Item Array

    $numComments = 1; //Number Of Latest Comments

    ?>
    <div class="home-stats">
    <div class="container text-center">
      <h1>Dashboard</h1>
      <div class="row">
        <div class="col-lg-3 col-md-6">
          <div class="stat st-members">
          <i class="fa fa-users"></i> 
            <div class="info">
               Total Members 
               <span><a href="members.php"><?php echo countItems('UserID' , 'users') ?></a></span>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="stat st-pending"> 
            <i class="fa fa-user-plus"></i>
            <div class="info">
          Pending Members
          <span><a href="members.php?do=Manage&page=pending">
            <?php echo checkItem( "RegStatus" , "users" , 0) ; ?>
          </a></span>
          </div>

          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="stat st-items"> 
            <i class="fa fa-tag"></i>
            <div class="info">
          Total Items 
          <span><a href="items.php"><?php echo countItems('Item_ID' , 'items') ?></a></span>
        </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="stat st-comments"> 
            <i class="fa fa-comments"></i>
            <div class="info">
          Total Comments 
          <span><a href="comments.php"><?php echo countItems('c_id' , 'comments') ?></a></span>
        </div>
          </div>
        </div>

       </div>
    </div>
  </div>
    <!-- #################################################################################### -->
    <div class="latest">
    <div class="container">
       <!-- ################################ Start All Rows ################################ -->
            <!-- ############################ Start Row One[1]  ######################## -->
      <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
               <i class="fa fa-users"></i> 
                   <span class="latest-header">Latest <?php echo $numUsers ;  ?> Registered Users</span>
                   <span class="toggle-info pull-right">
                     <i class="fa fa-plus fa-lg"></i>
                   </span>
                
            </div>

            <div class="card-body"> 
              <ul class="list-unstyled latest-users">
                <?php
                if(!empty($latestUsers)){
                  foreach ($latestUsers as $user) {
                  echo "<li>" ;
                        echo  "<span class='username'>" . $user['Username'] . "</span>" ; 
                        echo  '<a href="members.php?do=Edit&userid=' . $user['UserID'] .'">';
                        echo  "<span class='btn btn-success pull-right'>";
                        echo  '<i class="fa fa-edit"></i> Edit';
                        if($user['RegStatus'] == 0){

                        echo " <a href=' members.php?do=Activate&userid=". $user['UserID'] ." '
                                  class='btn btn-info pull-right activate'>
                                  <i class='fa fa-check'></i>Activate</a> " ;
                      }
                        echo  "</span>";
                        echo   '</a>';
                        echo  "</li>";
                  }
                }else{
                  echo "There Is No Record To Show";
                }
                ?>
              </ul>
            </div>
          </div>
        </div>


        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
               <i class="fa fa-tag"></i> 
                <span class="latest-header">Latest <?php echo $numItems; ?> Items</span>
               <span class="toggle-info pull-right">
                     <i class="fa fa-plus fa-lg"></i>
                   </span>
            </div>
            <div class="card-body"> 
               <ul class="list-unstyled latest-users">
                <?php
                  if(!empty($latestItems)){
                  foreach ($latestItems as $item) {
                  echo "<li>" ;
                        echo   "<span class='username'>". $item['Name'] . "</span>" ; 
                        echo  '<a href="items.php?do=Edit&itemid=' . $item['Item_ID'] .'">';
                        echo  "<span class='btn btn-success pull-right'>";
                        echo  '<i class="fa fa-edit"></i> Edit';
                        if($item['Approve'] == 0){
                        echo " <a href=' items.php?do=Approve&itemid=". $item['Item_ID'] ." '
                                  class='btn btn-info pull-right activate'>
                                  <i class='fa fa-check'></i>Approve</a> " ;
                      }
                        echo  "</span>";
                        echo   '</a>';
                        echo  "</li>";
                  }
                }else{
                  echo "There Is No Item To Show";
                }
                ?>
              </ul>
            </div>
          </div>
        </div> 



      </div>
      <!-- ################################ End Row One[1] ############################## -->
      <!-- #####################  Start Row Tow[2] | Latest Comment ############## -->
      <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
               <i class="fa fa-comments-o"></i> 
                  <span class="latest-header"> Latest <?php echo $numComments; ?> Comment</span>
                   <span class="toggle-info pull-right">
                     <i class="fa fa-plus fa-lg"></i>
                   </span>
                
            </div>
            <div class="card-body"> 
            <?php
                                   //Select  Comments// 
                $stmt = $con->prepare("SELECT 
                                    comments .* , users.Username AS Member
                               FROM 
                                    comments
                               INNER JOIN 
                                       users 
                                ON 
                                       users.UserID = comments.user_id
                                ORDER BY c_id DESC
                                LIMIT 
                                        $numComments");
        $stmt->execute();
        $comments = $stmt->fetchAll();
        if(!empty($comments)){
        foreach ($comments as $comment) {
          echo '<div class="comment-box">';
          echo    
                 '<span class="member-n"> 
                  <a href=" members.php?do=Edit&userid= ' . $comment["user_id"] . '" >
                  ' . $comment["Member"] .
                  '</a></span>' ;
                 
          echo  '<p class="member-c">'    . $comment['comment'] .  '</p>' ;
          echo '</div>'; 
        }
      }else{
        echo "There Is No Comments To Show";
      }
              ?>
            </div>
          </div>
        </div>
      </div>
 
           <!-- #####################  End Row Tow[2] | Latest Comment ############## -->
      <!-- ################################ End All Rows ################################ -->

    </div>
  </div>
    <!-- #################################################################################### -->


   

    <?php
     /* End Dashboard */
   	
    
   	include $tpl . 'footer.php' ; 
     }else{
     	
     	header('Location: index.php');
     	exit();
     }

  ob_end_flush();
?>
