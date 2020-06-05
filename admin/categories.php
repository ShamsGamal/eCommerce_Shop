<?php
/*
========================================================================
== Category Page
== You Can Add | Insert | Edit | Update | Delete | Category From Here
==
========================================================================
                                                                       */
   ob_start();
   session_start();
   $pageTitle = "Categories";
   if(isset($_SESSION['Username'])){

   		include 'init.php' ;


   	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;

   	if($do == 'Manage'){ //Start Manage Page
      
      $sort = 'ASC' ;//default value
      $sort_array = array( 'ASC' , 'DESC');

      if(isset($_GET['sort']) && in_array($_GET['sort'] , $sort_array)){
        $sort = $_GET['sort'] ;
        }

      $stmt2 = $con->prepare("SELECT * FROM categories WHERE parent = 0 ORDER BY Ordering $sort");
      $stmt2->execute();
      $cats = $stmt2->fetchAll();   ?> <!-- //cats refere to categories -->
      <h1 class="text-center">Manage Categories</h1>
      <div class="container categories ">
        <div class="card ">
          <div class="card-header">
            <i class="fa fa-edit"></i>
            Manage Categories
            <div class="option pull-right">
              <i class="fa fa-sort"></i> Ordering : [
              <a class="<?php if($sort == 'ASC') {echo 'active'; } ?>" href="?sort=ASC">Asc</a> |
              <a class="<?php if($sort == 'DESC'){echo 'active'; } ?>" href="?sort=DESC">Desc</a> ]
               <i class="fa fa-eye"></i> View : [
              <span class="active" data-view="full">Full</span> |
              <span data-view="classic">Classic</span> ]
              
            </div>
          </div>
          <div class="card-body">
            
            <?php
            foreach ($cats as $cat) {
              # code...
            echo "<div class='cat'>";
              echo "<div class='hidden-buttons'>";
                   echo "<a href='categories.php?do=Edit&catid=" . $cat['ID'] . " ' class='btn btn-xs btn-primary'>
                         <i class='fa fa-edit'></i>
                         Edit
                         </a>";
                   echo "<a href='categories.php?do=Delete&catid=" . $cat['ID'] . " ' class=' confirm
                        btn btn-xs btn-danger'>
                         <i class='fa fa-close'></i>
                         Delete
                         </a>"; 
              echo "</div>";
              echo "<h3>"             .  $cat['Name']           . "</h3>";
              echo "<div class='full-view'>";
                  echo "<p>";
                    
                  if($cat['Description'] == ''){ echo " This Category Has No Description " ;
                  }else{ echo $cat['Description'] ; }
                            
                  echo "</p>";
                 if($cat['Visibility']    == 1){ echo "<span class='visibility'>
                 <i class='fa fa-eye'></i>
                 Hidden
                 </span>" ; }
                 if($cat['Allow_Comment'] == 1){ echo "<span class='commenting'>
                 <i class='fa fa-close'></i>
                 Comment Disable
                 </span>" ; }
                 if($cat['Allow_Ads']     == 1){ echo "<span class='advertises'>
                 <i class='fa fa-close'></i>
                 Ads Disable
                 </span>" ; }
              echo "</div>";
              //Get Child Category
              $childCats = getAllFrom("*", "categories" ,"where parent = {$cat['ID']}" ,"", "ID" , "ASC");
              if(!empty($childCats)){
              echo '<h4 class="child-head">Sub Category</h4>';
              echo '<ul class="list-unstyled child-cats">';
              foreach ($childCats as $c) {
          echo "<li class='child-link'>
                 <a href='categories.php?do=Edit&catid=" . $c['ID'] . " '>" . $c['Name'] . "</a>
                 <a href='categories.php?do=Delete&catid=" . $c['ID'] . " 'class='show-delete confirm'>Delete</a>
                         
                         
                         
                </li>";
            }
              echo '</ul>';

            }
            //End Get Child Category
              echo "</div>";
              
              
            echo "<hr>";

            }


            ?>

             </div>
        </div>

         
         <a class="add-category btn btn-primary" href="categories.php?do=Add">
            <i class="fa fa-plus"></i>
               Add New Category
         </a>

      </div>

     <?php
   	}elseif($do == 'Add'){ //Start Add Page ?>

      <!-- ############################ Add Page ############################## -->
      <h1 class="text-center"> Add New Category </h1>
          <div class="add-category container">
            <form class="form-horizontal" action="?do=Insert" method="POST">
              
              <!-- Start Name Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10 col-md-6">
                  <input type="text" name="name" class="form-control" 
                            autocomplete="off"  required="required" 
                            placeholder="Name Of The Category" />
                </div>
              </div>
              <!-- End Name Field -->

              <!-- Start Description Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Description</label>
                <div class="col-sm-10 col-md-6">
                
                <input type="text" name="description" class="form-control" 
                       placeholder="Descripe The Category" />
                       
                
                </div>
              </div>
              <!-- End Description Field -->

              <!-- Start Ordering Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Ordering</label>
                <div class="col-sm-10 col-md-6">
                  <input type="text" name="ordering"  
                         class="form-control" placeholder="Number To Arrange The Categories" />
                </div>
              </div>
              <!-- End Ordering Field -->
              <!-- Start Category Type -->
            <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Category Type</label>
                <div class="col-sm-10 col-md-6">
                  <select name="parent" class="custom-select">
                    <option value="0">none</option>
                    <?php 

$allCats = getAllFrom("*" , "categories" , "WHERE parent = 0 " ,"", "ID", "ASC" );
foreach ($allCats as $cat) {

   echo "<option value= '" . $cat['ID'] . "'>". $cat['Name'] . "</option>" ;
}

                    ?>
                    
                  </select>
                </div>
              </div>
           <!-- End Category Type -->
              <!-- Start Visibility Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Visible</label>
                <div class="col-sm-10 col-md-6">

                   <div class="select-radio">
                     <input id="vis-yes" type="radio" name="visibility" value="0" checked />
                     <label for="vis-yes">Yes</label>
                   </div>

                   <div class="select-radio">
                     <input id="vis-no" type="radio" name="visibility" value="1"  />
                     <label for="vis-no">No</label>
                   </div>

                </div>

              </div>
              <!-- End Visibility Field -->
              <!-- Start Comment Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Allow Comment</label>
                <div class="col-sm-10 col-md-6">
                   <div class="select-radio">
                     <input id="com-yes" type="radio" name="commenting" value="0" checked />
                     <label for="com-yes">Yes</label>
                   </div>

                   <div class="select-radio">
                     <input id="com-no" type="radio" name="commenting" value="1"  />
                     <label for="com-no">No</label>
                   </div>

                </div>
              </div>
              <!-- End Comment Field -->
              
              <!-- Start Ads Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Allow Ads</label>
                <div class="col-sm-10 col-md-6">
                   <div class="select-radio">
                     <input id="ads-yes" type="radio" name="ads" value="0" checked />
                     <label for="ads-yes">Yes</label>
                   </div>

                   <div class="select-radio">
                     <input id="ads-no" type="radio" name="ads" value="1"  />
                     <label for="ads-no">No</label>
                   </div>

                </div>
              </div>
              <!-- End Ads Field -->
              

              <!-- Start Submit Button -->
              <div class="form-group form-group-lg">
                
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="Submit" value="Add Category" class="btn btn-primary" />
                </div>
              </div>
              <!-- End Submit Button -->
                </form>
          </div> <!-- End Div Class=Countainer || Add Page -->
        

   <!-- ##################################################################### -->
  <?php

   	}elseif($do == 'Insert'){
     // ############################ Start Insert Page ############################## //

      if ($_SERVER['REQUEST_METHOD'] == 'POST'){
      echo " <h1 class='text-center'> Update Category </h1> ";
      echo "<div class='container'>";

      //Get Variables From The Form parent
       
      $name     = $_POST['name'];
      $desc     = $_POST['description'];
      $parent     = $_POST['parent'];
      $order    = $_POST['ordering'];
      $visible  = $_POST['visibility'];
      $comment  = $_POST['commenting'];
      $ads      = $_POST['ads'];


      //Validate The Form
      //Check If Category Exist in Database

       $check = checkItem( "Name" , "categories" , $name);

       if($check == 1){

        $theMsg = "<div class='alert alert-danger'>Sorry , This Category Exist</div>";
        redirectHome ($theMsg , 'back');
       }else{

      //Inser Category Info in Databse 
      $stmt = $con->prepare("INSERT INTO 
                    categories(Name , Description , parent , Ordering , Visibility , Allow_Comment ,Allow_Ads)
                            VALUES(:zname , :zdesc , :zparent , :zorder , :zvisible , :zcomment , :zads ) ");
      $stmt->execute(array(

          'zname'    => $name      ,
          'zdesc'    => $desc      ,
          'zparent'  => $parent    ,
          'zorder'   => $order     ,
          'zvisible' => $visible   ,
          'zcomment' => $comment   ,
          'zads'     => $ads       

      ));
         

      //Echo Success Message 
      
      $theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . "Record Inserted </div>" ;
      redirectHome($theMsg , 'back' );
     
      }
      

       //End Insert in Database
      
     }else{
      echo "<div class='container'>";
      $theMsg =  '<div class="alert alert-danger" > 
                    Sorry ! , You Cannot Browse This Page Directly
                    </div>';
      redirectHome($theMsg , 'back' );
       echo "</div>";


     }
     echo "</div>"; // End Insert Page

    // ############################ End Insert Page ##############################  //



    }elseif($do == 'Edit'){

      //############################## Start Edit Page ################################## //

      // Check If Get Request catid Is Numeric && Get The Integer Value Of it catid => category id 
      $catid =  isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ; 
      
      //Select All Data From Database Depend on This ID
       $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ? ");
       //Excute Query 
       $stmt->execute(array($catid));
       //Fetch Data
       $cat = $stmt->fetch(); // cat => category
       //The Row Count 
       $count = $stmt->rowCount();
       //////////////////////////If There Is Such ID Show The Form ///////////////////////////
       if($count > 0){ ?>
           <!-- Exist ID Such That In The Database  -->
            <!--           Start Form      -->
            <h1 class="text-center"> Edit Category </h1>
            <div class="edit-category container">
            <form class="form-horizontal" action="?do=Update" method="POST">
              <input type="hidden" name="catid" value=" <?php echo $catid ; ?> " />
              
              <!-- Start Name Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10 col-md-6">
                  <input type="text" name="name" class="form-control"  required="required" 
                         placeholder="Name Of The Category" value="<?php echo $cat['Name']; ?>" />
                </div>
              </div>
              <!-- End Name Field -->

              <!-- Start Description Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Description</label>
                <div class="col-sm-10 col-md-6">
                
                <input type="text" name="description" class="form-control" 
                       placeholder="Descripe The Category" value="<?php echo $cat['Description']; ?>"/>
                
                </div>
              </div>
              <!-- End Description Field -->


              <!-- Start Ordering Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Ordering</label>
                <div class="col-sm-10 col-md-6">
                  <input type="text" name="ordering"  
                         class="form-control" placeholder="Number To Arrange The Categories" 
                         value="<?php echo $cat['Ordering']; ?>" />
                </div>
              </div>
              <!-- End Ordering Field -->
              <!-- Start Category Type -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Parent</label>
                <div class="col-sm-10 col-md-6">
                  <select name="parent" class="custom-select">
                    <option value="0">none</option>
                    <?php 

$allCats = getAllFrom("*" , "categories" , "WHERE parent = 0 " ,"", "ID", "ASC" );
foreach ($allCats as $c) {

   echo "<option value= '" . $c['ID'] . "'"; 
   if($cat['parent'] == $c['ID']){
        echo 'selected';
   }
   echo ">". $c['Name'] . "</option>" ;
}

                    ?>
                    
                  </select>
                </div>
              </div>
           <!-- End Category Type -->


              <!-- Start Visibility Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Visible</label>
                <div class="col-sm-10 col-md-6">
                   <div class="select-radio">
                     <input id="vis-yes" type="radio" name="visibility" 
                            value="0" <?php if($cat['Visibility'] == 0){ echo "checked"; } ?> />
                     <label for="vis-yes">Yes</label>
                   </div>

                   <div class="select-radio">
                     <input id="vis-no" type="radio" name="visibility" 
                            value="1" <?php if($cat['Visibility'] == 1){ echo "checked"; } ?>  />
                     <label for="vis-no">No</label>
                   </div>

                </div>
              </div>
              <!-- End Visibility Field -->
              <!-- Start Comment Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Allow Comment</label>
                <div class="col-sm-10 col-md-6">
                   <div class="select-radio">
                     <input id="com-yes" type="radio" name="commenting" 
                     value="0" <?php if($cat['Allow_Comment'] == 0){ echo "checked"; } ?> />
                     <label for="com-yes">Yes</label>
                   </div>

                   <div class="select-radio">
                     <input id="com-no" type="radio" name="commenting" 
                     value="1" <?php if($cat['Allow_Comment'] == 1){ echo "checked"; } ?>  />
                     <label for="com-no">No</label>
                   </div>

                </div>
              </div>
              <!-- End Comment Field -->
              
              <!-- Start Ads Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Allow Ads</label>
                <div class="col-sm-10 col-md-6">
                   <div class="select-radio">
                     <input id="ads-yes" type="radio" name="ads" 
                            value="0" <?php if($cat['Allow_Ads'] == 0){ echo "checked"; } ?>  />
                     <label for="ads-yes">Yes</label>
                   </div>

                   <div class="select-radio">
                     <input id="ads-no" type="radio" name="ads" 
                     value="1" <?php if($cat['Allow_Ads'] == 1){ echo "checked"; } ?>  />
                     <label for="ads-no">No</label>
                   </div>

                </div>
              </div>
              <!-- End Ads Field -->
              

              <!-- Start Submit Button -->
              <div class="form-group form-group-lg">
                
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="Submit" value="Update Category" class="btn btn-primary" />
                </div>
              </div>
              <!-- End Submit Button -->
                </form>
          </div> <!-- End Div Class=Countainer || Add Page -->
            <!--           End Form        -->

      <?php 
      }else{    /////////////////// If There Is No Such ID Show Error Message //////////////////////
            echo "<div class='container'>";
            $theMsg =  "<div class='alert alert-danger'> Sorry ! , There Is No Such ID ..</div> " ;
            redirectHome($theMsg);
            echo "</div>";
      }

      // ###############################    End Edit Page    ################################ //

   	}elseif ($do == 'Update') {

      // ############################   Start Update Page      ################################ //
      if ($_SERVER['REQUEST_METHOD'] == 'POST'){

      echo " <h1 class='text-center'> Update Category </h1> ";
      echo "<div class='container'>";

      //Get Variables From The Form
      $id       = $_POST['catid'];
      $name     = $_POST['name'];
      $desc     = $_POST['description'];
      $order    = $_POST['ordering'];
      $parent    = $_POST['parent'];
      $visible  = $_POST['visibility'];
      $comment  = $_POST['commenting'];
      $ads      = $_POST['ads'];
      
       //Update The Database With This Information Category  if There is No Error
      
        $stmt = $con->prepare("UPDATE 
                                     categories 
                              SET    Name          = ? , 
                                     Description   = ? , 
                                     Ordering      = ? ,
                                     parent        = ? , 
                                     Visibility    = ? ,
                                     Allow_Comment = ? ,
                                     Allow_Ads     = ?
                              WHERE 
                                     ID            = ?");
        $stmt->execute(array($name , $desc , $order , $parent , $visible , $comment , $ads , $id ));

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



     // ############################### End Update Page    ################################# //


   	}elseif($do == 'Delete'){
    // ################################# Start Delete Page   ################################# //
     echo ' <h1 class="text-center"> Delete Category </h1> ' ;



      // Check If Get Request CatID Is Numeric && Get The Integer Value Of it CatID => Category ID
      $catid =  isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ; 
       

      //Select All Data From Database Depend on This ID
       $check = checkItem( 'ID' , 'categories' , $catid);
       

       
       ////////////////////////// Database Statement  ///////////////////////////
       if($check > 0){ 
        $stmt = $con->prepare("DELETE FROM categories WHERE ID = :zid");

        $stmt->bindParam(":zid" , $catid);
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

    // ################################  End Delete Page     ################################# //

   	} 


   

   	include $tpl . 'footer.php' ; 

   }else{
     	
     	header('Location: index.php');
     	exit();
    }

    ob_end_flush();




















