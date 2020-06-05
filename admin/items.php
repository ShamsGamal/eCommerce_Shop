<?php
/*
========================================================================
== Items Page
== You Can Add | Insert | Edit | Update | Delete | Approve Item  From Here
==
========================================================================
                                                                       */
   ob_start();
   session_start();
   $pageTitle = "Items";
   if(isset($_SESSION['Username'])){
   		 
   	include 'init.php' ;

   	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;

   	if($do == 'Manage'){
      // ############################## Start Manage Page ################################## //
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
                               ORDER BY Item_ID DESC");
        //Execute Statement
        $stmt->execute();
        //Assign to Variable
        $items = $stmt->fetchAll();
        if(!empty($items)){
        ?>
        <h1 class="text-center"> Manage Items </h1>
          <div class="container">
            <div class="table-responsive">
               <table class="main-table text-center table table-bordered">
                 <tr>
                   <td>#ID</td>
                   <td>Name</td>
                   <td>Description</td>
                   <td>Price</td>
                   <td>Date</td>
                   <td>Category</td>
                   <td>Username</td>
                   <td>Control</td>
                 </tr>
                 <?php

                 foreach ($items as $item) {
                   
                   echo "<tr>";
                       echo "<td>" . $item['Item_ID'] . "</td>" ;
                       echo "<td>" . $item['Name'] . "</td>" ;
                       echo "<td>" . $item['Description'] . "</td>" ;
                       echo "<td>" . $item['Price'] . "</td>" ;
                       echo "<td>" . $item['Add_Date'] . "</td>";
                       echo "<td>" . $item['category_name'] . "</td>";
                       echo "<td>" . $item['Username'] . "</td>";
                       echo "<td>
                                 <a href=' items.php?do=Edit&itemid=". $item['Item_ID'] ." '
                                  class='btn btn-success btn-block'>
                                  <i class='fa fa-edit'></i>Edit</a>

                                 <a href=' items.php?do=Delete&itemid=". $item['Item_ID'] ." '
                                  class='btn btn-danger confirm btn-block'>
                                  <i class='fa fa-close'></i>Delete</a>";

                                  if($item['Approve'] == 0){
                                  echo " <a href=' items.php?do=Approve&itemid=". $item['Item_ID'] ." '
                                  class='btn btn-info activate btn-block'>
                                  Approve</a> " ;
                      }
                       echo "</td>";

                   echo "</tr>";
                 }
                 ?>

                  </table>  
            </div>
            <a href='items.php?do=Add' class="btn btn-primary ">
              <i class="fa fa-plus"></i> 
              New Item </a>

      </div> <!-- End Div class = "container" || Manage -->
      <?php }else{
      echo '<div class="container">';
            echo '<div class="nice-message"> There Is No Items To Show </div>';
            echo '<a href="items.php?do=Add" class="btn btn-primary ">
              <i class="fa fa-plus"></i> 
              New Item </a>';
      echo '</div>';
    } ?>

  <!--// ############################## End Manage Page ################################## //-->
  <?php
  }elseif ($do == 'Add'){ //Add Page ?>
      
      <!-- ############################ Add Page ############################## -->
      <h1 class="text-center"> Add New Item </h1>
          <div class="add-item container">
            <form class="form-horizontal" 
                  action="?do=Insert" method="POST" enctype="multipart/form-data">
              
              <!-- Start Name Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10 col-md-6">
                  <input type="text" 
                         name="name" 
                         class="form-control" 
                         required="required" 
                         placeholder="Name Of The Item" />
                </div>
              </div>
              <!-- End Name Field -->

              <!-- Start Description Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Description</label>
                <div class="col-sm-10 col-md-6">
                  <input type="text" 
                         name="description" 
                         class="form-control" 
                         required="required"
                         placeholder="Description Of The Item" />
                </div>
              </div>
              <!-- End Description Field -->

              <!-- Start Price Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Price</label>
                <div class="col-sm-10 col-md-6">
                  <input type="text" 
                         name="price" 
                         class="form-control" 
                         required="required" 
                         placeholder="Price Of The Item" />
                </div>
              </div>
              <!-- End Price Field -->

              <!-- Start Country_Made  Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Country</label>
                <div class="col-sm-10 col-md-6">
                  <input type="text" 
                         name="country" 
                         class="form-control"
                         required="required" 
                         placeholder="Country Of Made" />
                </div>
              </div>
              <!-- End Country_Made Field -->

              <!-- Start Status  Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Status</label>
                <div class="col-sm-10 col-md-6">
                  <select class="form-control custom-select" name="status">
                    <option value="0">...</option>
                    <option value="1">New</option>
                    <option value="2">Like New</option>
                    <option value="3">Used</option>
                    <option value="4">Very Old</option>
                  </select>
                </div>
              </div>
              <!-- End Status Field -->

              <!-- Start Member  Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Member</label>
                <div class="col-sm-10 col-md-6">
                  <select class="form-control custom-select" name="member">
                    <option value="0">...</option>
                    <?php 
  $allMembers = getAllFrom("*", "users" , "" , "" , "UserID");
                      foreach ( $allMembers as $user) {
                          
                          echo "<option value=' " . $user['UserID'] . " '>" . $user['Username'] . "</option>";
                        }
                        ?>
                  </select>
                </div>
              </div>
              <!-- End Member Field -->

              <!-- Start Category  Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Category</label>
                <div class="col-sm-10 col-md-6">
                  <select class="form-control custom-select" name="category">
                    <option value="0">...</option>
                    <?php 
    $allCats = getAllFrom("*", "categories" , "where parent = 0" , "" , "ID");
                        
                        foreach ($allCats as $cat) {
                          
                          echo "<option value=' " . $cat['ID'] . " '>" . $cat['Name'] . "</option>";
              $childCats = getAllFrom("*", "categories" , "where parent = {$cat['ID']}" , "" , "ID");
              foreach ($childCats as $child) {
                 echo "<option value=' " . $child['ID'] . " '>--- " . $child['Name'] . "</option>";
              }
                        }
                        ?>
                  </select>
                </div>
              </div>
              <!-- End Category Field -->

              <!-- Start Tags Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Tags</label>
                <div class="col-sm-10 col-md-6">
                  <input type="text" 
                         name="tags" 
                         class="form-control"
                        placeholder="Separate Tags With Comma (,)" />
                </div>
              </div>
              <!-- End Tags Field -->
              <!-- Start Avatar Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Item Image</label>
                <div class="col-sm-10 col-md-6">
                  <input type="file" 
                         name="image" 
                         class="form-control" 
                         required="required" />
                         
                </div>
              </div>
              <!-- End Avatar Field -->

              <!-- Start Submit Button -->
              <div class="form-group form-group-lg">
                
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="Submit" 
                         value="Add Item" 
                         class="btn btn-primary btn-sm" />
                </div>
              </div>
              <!-- End Submit Button -->
                </form>
          </div> <!-- End Div Class=Countainer || Add Page -->
        

   <!-- ############################# End Add Page ##################################### -->
  <?php
  }elseif($do == 'Insert'){
    // ################################# Start Insert Page ######################### //
     if ($_SERVER['REQUEST_METHOD'] == 'POST'){
      echo " <h1 class='text-center'> Insert Item </h1> ";
      echo "<div class='container'>";
      //Upload Variable
      $avatarName = $_FILES['image']['name'];
      $avatarType = $_FILES['image']['type'];
      $avatarTmp  = $_FILES['image']['tmp_name'];
      $avatarSize = $_FILES['image']['size'];  
      //List Of Allowed Type Files To Upload
      $avatarAllowedExtension = array("jpeg" , "jpg" , "png" , "gif");
      //Get Avatar Extension

      

      $ex_name = explode('.', $avatarName);
      $end_name = end($ex_name);
      $avatarExtension = strtolower($end_name);

      //Get Variables From The Form 
      $name     = $_POST['name'];
      $desc     = $_POST['description'];
      $price    = $_POST['price'];
      $country  = $_POST['country'];
      $status   = $_POST['status'];
      $member   = $_POST['member'];
      $cat      = $_POST['category'];
      $tags      = $_POST['tags'];
      

      //Validate The Form
      $formErrors = array();

      if(empty($name)){
        $formErrors[] = 'Name can not be <strong>Empty !</strong>'; 
        }

      if(empty($desc)){
        $formErrors[] = 'Description can not be <strong>Empty !</strong>'; 
        }

      if(empty($price)){
        $formErrors[] = 'Price can not be <strong>Empty !</strong>'; 
        }

       if(empty($country)){
        $formErrors[] = 'Country Of Made can not be <strong>Empty !</strong>'; 
        }

        if($status == 0){
        $formErrors[] = 'You Should Choose <strong> Status  ! </strong>'; 
        }

        if($member == 0){
        $formErrors[] = 'You Should Choose <strong> Member  ! </strong>'; 
        }

        if($cat == 0){
        $formErrors[] = 'You Should Choose <strong> Category  ! </strong>'; 
        }
        if(!empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)){
         $formErrors[] = 'This Extention Is Not<strong>Allowed !</strong>';
       }
       if(empty($avatarName)){
         $formErrors[] = 'Image Is <strong>Required !</strong>';
       }
       if($avatarSize > 4194304){
         $formErrors[] = 'Image Can Not Be <strong>4MB !</strong>';
      }


      //Loop Error Array And echo  it 
      foreach($formErrors as $error) {
         
        echo '<div class="alert alert-danger">' . $error  . '</div>' ;
         
      
      }

      if(empty($formErrors)){
        $avatar = rand(0 , 1000000) . '_' . $avatarName ;
        move_uploaded_file($avatarTmp , "uploads\avatars\\" . $avatar );
        //Inser User Info in Databse 
        $stmt = $con->prepare("INSERT INTO 
                                 items(Name ,  Description , Price , Country_Made , Status , Add_Date , Cat_ID , Member_ID , tags , image)
              VALUES(:zname , :zdesc , :zprice , :zcountry , :zstatus , now() , :zcat , :zmember , :ztags , :zimage ) ");
        $stmt->execute(array(

          'zname'      => $name     ,
          'zdesc'      => $desc     ,
          'zprice'     => $price    ,
          'zcountry'   => $country  ,
          'zstatus'    => $status   ,
          'zcat'       => $cat      ,
          'zmember'    => $member   ,
          'ztags'      => $tags     ,
          'zimage'     => $avatar  

        ));
         

      //Echo Success Message 
      
      $theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . "Record Inserted </div>" ;
      redirectHome($theMsg , 'back');
     
      
      } //End Insert in Database*/
      
      }else{
      echo "<div class='container'>";
      $theMsg =  '<div class="alert alert-danger" > 
                    Sorry ! , You Cannot Browse This Page Directly
                    </div>';
      redirectHome($theMsg);
       echo "</div>";


     }
     echo "</div>"; // End Insert Page

    // ################################# End Insert Page ######################### //

   	}elseif($do == 'Edit'){
    // ############################### Start Edit Page ############################ //

      // Check If Get Request ItemID Is Numeric && Get The Integer Value Of it 
      $itemid =  isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ; 
      
      //Select All Data From Database Depend on This ID
       $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ?");
       //Excute Query 
       $stmt->execute(array($itemid));
       //Fetch Data
       $item = $stmt->fetch();
       //The Row Count 
       $count = $stmt->rowCount();
       //////////////////////////If There Is Such ID Show The Form ///////////////////////////
       if($count > 0){ ?>
                                     <!-- -->
        <h1 class="text-center"> Edit Item </h1>
          <div class="edit-item container">
            <form class="form-horizontal" action="?do=Update" method="POST">
              <input type="hidden" name="itemid" value=" <?php echo $itemid ; ?> " />
              
              <!-- Start Name Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10 col-md-6">
                  <input type="text" 
                         name="name" 
                         class="form-control" 
                         required="required" 
                         placeholder="Name Of The Item"
                         value="<?php echo $item['Name'] ; ?>" />
                </div>
              </div>
              <!-- End Name Field -->

              <!-- Start Description Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Description</label>
                <div class="col-sm-10 col-md-6">
                  <input type="text" 
                         name="description" 
                         class="form-control" 
                         required="required"
                         placeholder="Description Of The Item"
                         value="<?php echo $item['Description'] ; ?>" />
                </div>
              </div>
              <!-- End Description Field -->

              <!-- Start Price Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Price</label>
                <div class="col-sm-10 col-md-6">
                  <input type="text" 
                         name="price" 
                         class="form-control" 
                         required="required" 
                         placeholder="Price Of The Item"
                         value="<?php echo $item['Price'] ; ?>" />
                </div>
              </div>
              <!-- End Price Field -->

              <!-- Start Country_Made  Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Country</label>
                <div class="col-sm-10 col-md-6">
                  <input type="text" 
                         name="country" 
                         class="form-control"
                         required="required" 
                         placeholder="Country Of Made"
                         value="<?php echo $item['Country_Made'] ; ?>" />
                </div>
              </div>
              <!-- End Country_Made Field -->

              <!-- Start Status  Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Status</label>
                <div class="col-sm-10 col-md-6">
                  <select class="form-control custom-select" name="status">
                    
                    <option value="1" <?php if($item['Status'] == 1 ) {echo 'selected';} ?>>New      </option>
                    <option value="2" <?php if($item['Status'] == 2 ) {echo 'selected';} ?>>Like New </option>
                    <option value="3" <?php if($item['Status'] == 3 ) {echo 'selected';} ?>>Used     </option>
                    <option value="4" <?php if($item['Status'] == 4 ) {echo 'selected';} ?>>Very Old </option>
                  </select>
                </div>
              </div>
              <!-- End Status Field -->

              <!-- Start Member  Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Member</label>
                <div class="col-sm-10 col-md-6">
                  <select class="form-control custom-select" name="member">
                    
                    <?php 
                        $stmt = $con->prepare("SELECT * FROM users");
                        $stmt->execute();
                        $users = $stmt->fetchAll();
                        foreach ($users as $user) {
                          
                          echo "<option value=' " . $user['UserID'] . " ' "; 
                          if($item['Member_ID'] == $user['UserID'] ) {echo 'selected';}
                          echo ">" . $user['Username'] . "</option>";
                        }
                        ?>
                  </select>
                </div>
              </div>
              <!-- End Member Field -->

              <!-- Start Category  Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Category</label>
                <div class="col-sm-10 col-md-6">
                  <select class="form-control custom-select" name="category">
                    
                    <?php 
                        $stmt2 = $con->prepare("SELECT * FROM categories");
                        $stmt2->execute();
                        $cats = $stmt2->fetchAll();
                        foreach ($cats as $cat) {
                          
                         // echo "<option value=' " . $cat['ID'] . " '>" . $cat['Name'] . "</option>";
                          echo "<option value=' " . $cat['ID'] . " ' "; 
                          if($item['Cat_ID'] == $cat['ID'] ) {echo 'selected';}
                          echo ">" . $cat['Name'] . "</option>";
                        }
                        ?>
                  </select>
                </div>
              </div>
              <!-- End Category Field -->
              <!-- Start Tags Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Tags</label>
                <div class="col-sm-10 col-md-6">
                  <input type="text" 
                         name="tags" 
                         class="form-control"
                        placeholder="Separate Tags With Comma (,)" 
                        value="<?php echo $item['tags'] ; ?>" />
                </div>
              </div>
              <!-- End Tags Field -->

              <!-- Start Submit Button -->
              <div class="form-group form-group-lg">
                
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="Submit" 
                         value="Edit Item" 
                         class="btn btn-primary btn-sm" />
                </div>
              </div>
              <!-- End Submit Button -->
                </form>
                <!-- ##############################  Start Show Comment ######################### -->
                <?php

                //Select  Comments That Belong To This Item 
                $stmt = $con->prepare("SELECT 
                                    comments .* , users.Username AS Member
                               FROM 
                                    comments
                               INNER JOIN 
                                       users 
                                ON 
                                       users.UserID = comments.user_id
                                WHERE 
                                       item_id = ?");

        //Execute Statement
        $stmt->execute(array($itemid));

        //Assign to Variable
        $rows = $stmt->fetchAll();
        if(!empty($rows)){
         ?>

        <h1 class="text-center"> Manage [ <?php echo $item['Name'] ; ?> ] Comments </h1>
          
            <div class="table-responsive">
               <table class="main-table text-center table table-bordered">
                 <tr>
                   
                   <td>Comment</td>
                   
                   <td>User Name</td>
                   <td>Added Date</td>
                   <td>Control</td>
                 </tr>
                 <?php

                 foreach ($rows as $row) {
                   
                   echo "<tr>";
                       
                       echo "<td>" . $row['comment'] . "</td>" ;
                       
                       echo "<td>" . $row['Member'] . "</td>" ;
                       echo "<td>" . $row['comment_date'] . "</td>";
                      echo "<td>
                                 <a href=' comments.php?do=Edit&comid=". $row['c_id'] ." '
                                  class='btn btn-success'>
                                  <i class='fa fa-edit'></i>Edit</a>

                                 <a href=' comments.php?do=Delete&comid=". $row['c_id'] ." '
                                  class='btn btn-danger confirm'>
                                  <i class='fa fa-close'></i>Delete</a>";

                      if($row['status'] == 0){
                        echo " <a href=' comments.php?do=Approve&comid=". $row['c_id'] ." '
                                  class='btn btn-info activate'>
                                  <i class='fa fa-check'></i>Approve</a> " ;
                      }
                      

                        echo "</td>";

                   echo "</tr>";
                 }
                 ?>

                  </table>  
            </div>
          <?php } ?>
             
          <!-- ########################### End Show Comment ############################# -->
          </div> <!-- End Div Class=Countainer || Add Page -->

                                        <!-- -->
         <?php 
      }else{    /////////////////// If There Is No Such ID Show Error Message //////////////////////
            echo "<div class='container'>";
            $theMsg =  "<div class='alert alert-danger'> Sorry ! , There Is No Such ID ..</div> " ;
            redirectHome($theMsg);
            echo "</div>";
      }

   // ############################### End Edit Page ############################ // 

   	}elseif ($do == 'Update') {

   // ########################### Start Update Page ########################### //
      if ($_SERVER['REQUEST_METHOD'] == 'POST'){
      echo " <h1 class='text-center'> Update Item </h1> ";
      echo "<div class='container'>";

      //Get Variables From The Form
      $id      = $_POST['itemid']       ;
      $name    = $_POST['name']         ;
      $desc    = $_POST['description']  ;
      $price   = $_POST['price']        ;
      $country = $_POST['country']      ;
      $status  = $_POST['status']       ;
      $member  = $_POST['member']       ;
      $cat     = $_POST['category']     ;
      $tags     = $_POST['tags']        ;

      //Validate The Form
      $formErrors = array();

      if(empty($name)){
        $formErrors[] = 'Name can not be <strong>Empty !</strong>'; 
        }

      if(empty($desc)){
        $formErrors[] = 'Description can not be <strong>Empty !</strong>'; 
        }

      if(empty($price)){
        $formErrors[] = 'Price can not be <strong>Empty !</strong>'; 
        }

       if(empty($country)){
        $formErrors[] = 'Country Of Made can not be <strong>Empty !</strong>'; 
        }

        if($status == 0){
        $formErrors[] = 'You Should Choose <strong> Status  ! </strong>'; 
        }

        if($member == 0){
        $formErrors[] = 'You Should Choose <strong> Member  ! </strong>'; 
        }

        if($cat == 0){
        $formErrors[] = 'You Should Choose <strong> Category  ! </strong>'; 
        }


      //Loop Error Array And echo  it 
      foreach($formErrors as $error) {
         
        echo '<div class="alert alert-danger">' . $error  . '</div>' ;
         
      
      }

      if(empty($formErrors)){
        //Inser User Info in Databse 
        $stmt = $con->prepare("UPDATE 
                                    items 
                              SET 
                                    Name = ? , Description = ? , Price = ? , Country_Made = ? ,
                                    Status = ? , Member_ID = ? , Cat_ID = ? , tags = ?
                              WHERE 
                                    Item_ID = ?");

        $stmt->execute(array($name , $desc  , $price , $country , $status , $member , $cat , $tags , $id));

      //Echo Success Message 
      
      $theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . "Record Updated </div>" ;
      redirectHome($theMsg , 'back');
     
      
      }//End Update in Database
      
      }else{
      echo "<div class='container'>";
      $theMsg =  '<div class="alert alert-danger" > 
                    Sorry ! , You Cannot Browse This Page Directly
                    </div>';
      redirectHome($theMsg);
       echo "</div>";
     } //End Update in Database
      
    // ############################ End Update Page ############################## //

   	}elseif($do == 'Delete'){
   // ############################ Start Delete Page ########################## //

      // Check If Get Request Item ID Is Numeric && Get The Integer Value Of it 
      $itemid =  isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ; 
       

      //Select All Data From Database Depend on This ID
       $check = checkItem( 'Item_ID' , 'items' , $itemid);
      ////////////////////////// Database Statement  ///////////////////////////
       if($check > 0){ 
        $stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :zid");

        $stmt->bindParam(":zid" , $itemid);
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
      
     // ############################ Start Delete Page ########################## //

    }elseif($do == 'Approve'){ 
      // ########################### Start Approve Page ######################## //
      echo " <h1 class='text-center'> Approve Item </h1> ";
        echo "<div class='container'>";
      // Check If Get Request UserID Is Numeric && Get The Integer Value Of it 
      $itemid =  isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ; 
      //Select All Data From Database Depend on This ID
       $check = checkItem( 'Item_ID' , 'items' , $itemid);
       ////////////////////////// Database Statement  ///////////////////////////
       if($check > 0){ 

        $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");
        $stmt->execute(array($itemid));


       //Echo Success Message 
        echo "<div class='container'>";
        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . "Record Updated </div>" ;
        redirectHome ($theMsg , 'back');
        echo "</div>";


       }else{
        echo "<div class='container'>";
        $theMsg = "<div class='alert alert-danger'>Sorry ! This ID Not Exist</div>";
        redirectHome ($theMsg);
        echo "</div>";
       }//End Approve Page
        

      // ########################### End Approve Page ########################## //

   	}
   include $tpl . 'footer.php' ; 

   }else{
     	
     	header('Location: index.php');
     	exit();
    }

    ob_end_flush();
?>



















