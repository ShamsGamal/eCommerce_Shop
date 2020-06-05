
<?php
   session_start();
   $pageTitle = 'Show Items'; //describe page title
   include 'init.php' ;

   //                                   ##                          //
   // Check If Get Request ItemID Is Numeric && Get The Integer Value Of it 
      $itemid =  isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ; 
      
      //Select All Data From Database Depend on This ID
       $stmt = $con->prepare("SELECT 
                                  items .* , categories.Name 
                               AS 
                                  category_name , users.Username 
                               FROM 
                                  items
                               INNER JOIN 
                                  categories 
                               ON 
                                  categories.ID = items.Cat_ID
                               INNER JOIN 
                                  users 
                               ON 
                                   users.UserID = items.Member_ID  
                              WHERE 
                                    Item_ID = ?
                              AND
                                    Approve = 1 ");
       //Excute Query 
       $stmt->execute(array($itemid));
       $count = $stmt->rowCount();
       if($count > 0){



       //Fetch Data
       $item = $stmt->fetch();

 //                                    ##                         //
    
?>
   <!--                                 ##                     -->
    <h1 class="text-center"><?php echo $item['Name'];  ?></h1>
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <?php
          if(empty($item['image'])){
          echo "<img src='admin/uploads/avatars/mouse-01.jpg' 
                     class='img-responsive img-thumbnail center-block img-circle'
                     style='width:250px; height:300px;'>";
           }else{
          echo "<img src='admin/uploads/avatars/" . $item['image'] . "'style='width:250px; height:300px;'class='img-responsive img-thumbnail center-block img-circle' alt=''/>";
          }
           ?>
        </div>
        <div class="col-md-9 item-info">
          <h2><?php echo $item['Name']; ?></h2>
           <p><?php echo $item['Description']; ?></p>
           <ul class="list-unstyled">
           <li>
            <i class="fa fa-calendar fa-fw"></i>
            <span>Added Date : </span><?php echo $item['Add_Date']; ?>
          </li>
           <li>
            <i class="fa fa-money fa-fw"></i>
            <span>Price : </span><?php echo $item['Price']; ?>
          </li>

           <li>

            <i class="fa fa-building fa-fw"></i>
            <span>Made IN : </span><?php echo $item['Country_Made']; ?>
          </li>

           <li>
            <i class="fa fa-tags fa-fw"></i>
            <span>Category Name : </span>
            <a href="categories.php?pageid=<?php echo $item['Cat_ID']; ?>">
              <?php echo $item['category_name']; ?>
                
              </a>
          </li>
           <li>
            <i class="fa fa-user fa-fw"></i>
            <span>Added By : </span><a href="#"><?php echo $item['Username']; ?></a>
          </li>

          <li>
            <i class="fa fa-tags fa-fw"></i>
            <span>Tags : </span>
            <?php 
               $allTags = explode("," , $item['tags']);
               foreach ($allTags as $tag) {
                  $tag = str_replace(' ', '', $tag);
                  $lowertag = strtolower($tag);
                  if(!empty($tag)){
                  echo "<a href='tags.php?name={$lowertag}'>" . $tag . '</a> ' ;
                }
               }
            ?>
          </li>

         </ul>
        </div>
      </div>
    </div>
                                  <!--End of row one-->
      <div class="container">
      <hr class="custom-hr">
      <?php if(isset($_SESSION['user'])){ ?>
       
       <div class="row">
        <div class="col-md-3"></div> <!-- this is will be fixed -->
          
        <!-- Start Add Comment -->
        <div class="col-md-9">
            <div class="add-comment">
          <h3>Add Your Comment</h3>
          <form action= "<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item['Item_ID']  ?>" method="POST">
            <textarea class="form-control" name="comment" required></textarea>
            <input class="btn btn-primary" type="submit" value="Add Comment">
          </form>
          <?php 
          if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //echo $_POST['comment'];
            $comment = filter_var($_POST['comment'] , FILTER_SANITIZE_STRING);
            $itemid  = $item['Item_ID'];
            $userid  = $_SESSION['uid'];
            

            if(!empty($comment)){
              $stmt = $con->prepare("INSERT INTO 
                                               comments(comment , status , comment_date , item_id , user_id)
                                     VALUES 
                                              (:zcomment , 0 , NOW() , :zitemid , :zuserid)


                                              ");
              $stmt->execute(array(
                   'zcomment' => $comment ,
                    'zitemid' => $itemid  ,
                    'zuserid' => $userid
                ));
              if($stmt){
                echo "<div class='alert alert-success'>Comment Is Added Successfully</div>";
              }

            }


          }




          ?>


          </div>
        </div>
         <!-- End Add Comment -->

      </div>
    </div>
                                   <!--End of row two -->
      <?php }else{
        echo '<a href="login.php">Login</a> or <a href="login.php">Register</a> to Add Comment';

      } ?>


       <div class="container">
       <hr class="custom-hr">
       <?php
          //Select All Comments Except Admin
        $stmt = $con->prepare("SELECT 
                                    comments .* , users.Username AS Member
                               FROM 
                                    comments
                               INNER JOIN 
                                       users 
                                ON 
                                       users.UserID = comments.user_id
                                WHERE
                                       item_id = ?
                                AND
                                        status = 1
                                ORDER BY 
                                       c_id DESC");

        //Execute Statement
        $stmt->execute(array($item['Item_ID']));
        //Assign to Variable
        $comments = $stmt->fetchAll();

        

  ?>
</div>


          

      
        <?php foreach ($comments as $comment) { ?>
          <div class="container">
          <div class="comment-box">
            <div class="row"> 
                  <div class="col-sm-2 text-center">
    
   <?php
             if(empty($comment['avatar'])){
                echo "<img src='admin/uploads/avatars/marwa.jpg' class='img-responsive img-thumbnail rounded-circle d-block m-auto'>";
              }else{
                echo "<img class='img-responsive img-thumbnail rounded-circle d-block m-auto' 
                          src='admin/uploads/avatars/" . $comment['avatar'] . "' alt=''/>";
              }
              ?>
                    <?php echo  $comment['Member'] ?>
                  </div> 
                  <div class="col-sm-10">
                    <p class="lead"><?php echo $comment['comment'] ?></p>
                   
                  </div> 
             </div> 
           </div>
           <hr class="custom-hr" />
         </div>

          
        <?php } ?>

        

     
    <!--                                    #1#                    -->
    
<!--                                    ##                    -->

<?php
     }else{

         echo 'There Is No Such ID or This Item Waiting Approve';
}
   
  
?>
<?php  include $tpl . 'footer.php' ;  ?>