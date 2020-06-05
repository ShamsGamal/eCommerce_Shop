<?php
   session_start();
   $pageTitle = 'Create New Item'; //describe page title
   include 'init.php' ;

   if(isset($_SESSION['user'])){
    //print_r($_SESSION);
    #code..

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
       $formErrors = array();
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

       $name       =  filter_var($_POST['name'] ,        FILTER_SANITIZE_STRING);
       $desc       =  filter_var($_POST['description'] , FILTER_SANITIZE_STRING);
       $price      =  filter_var($_POST['price'] ,       FILTER_SANITIZE_NUMBER_INT);
       $country    =  filter_var($_POST['country'] ,     FILTER_SANITIZE_STRING);
       $status     =  filter_var($_POST['status'] ,      FILTER_SANITIZE_NUMBER_INT);
       $category   =  filter_var($_POST['category'] ,    FILTER_SANITIZE_NUMBER_INT);
       $tags       =  filter_var($_POST['tags'] ,        FILTER_SANITIZE_STRING);

      


        //echo $name . "<br />" . $price ;
       if(strlen($name) < 4){
           $formErrors[] = 'Item Title Must Be Greater Than 4 Char';
       }

       if(strlen($desc) < 10){
           $formErrors[] = 'Item Description Must Be Greater Than 10 Char';
       }

       if(strlen($country) < 2){
           $formErrors[] = 'Item Country Must Be Greater Than 2 Char';
       }

       if(empty($price)){
           $formErrors[] = 'Item Price Must Be Not Empty';
       }

       if(empty($status)){
           $formErrors[] = 'Item Status Must Be Not Empty';
       }

       if(empty($category )){
           $formErrors[] = 'Item Category Must Be Not Empty';
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
       //////////////////////////////////////////////////////////////////////////////
       if(empty($formErrors)){
        $avatar = rand(0 , 1000000) . '_' . $avatarName ;
        move_uploaded_file($avatarTmp , "admin\uploads\avatars\\" . $avatar );
        

        //Inser User Info in Databse 
        $stmt = $con->prepare("INSERT INTO 
                                 items(Name ,  Description , Price , Country_Made , Status , Add_Date , Cat_ID , Member_ID , tags , image)
                              VALUES(:zname , :zdesc , :zprice , :zcountry , :zstatus , now() , :zcat , :zmember , :ztags , :zimage) ");
        $stmt->execute(array(

          'zname'      => $name     ,
          'zdesc'      => $desc     ,
          'zprice'     => $price    ,
          'zcountry'   => $country  ,
          'zstatus'    => $status   ,
          'zcat'       => $category      ,
          'zmember'    => $_SESSION['uid'] ,
          'ztags'      => $tags ,
          'zimage'     => $avatar


        ));
         

      //Echo Success Message 
      
     // $theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . "Record Inserted </div>" ;
     // redirectHome($theMsg , 'back');
        if($stmt){
          $successMsg = 'Item Is Added Successfully';
        }
     
        
      } //End Insert in Database
      

     ////////////////////////////////////////////////////////////////////////////////
    }
       

   
   ?>
    
    <h1 class="text-center"><?php echo $pageTitle;  ?></h1>
    <!--                                    #Start1#                    -->
   	<div class="create-ad block">
   		<div class="container">
   			<div class="card card-primary">
   				<div class="card-header"><?php echo $pageTitle;  ?></div>
   				<div class="card-body">
                <!-- Start Of Row -->
                <div class="row">
                <div class="col-md-8">

                                  <!-- Start Form -->
                <form class="form-horizontal main-form" 
                      action="<?php echo $_SERVER['PHP_SELF'] ?>" 
                      method="POST" enctype="multipart/form-data">
              
              <!-- Start Name Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10 col-md-9">
                  <input type="text" 
                         name="name" 
                         class="form-control live" 
                         placeholder="Name Of The Item"
                         data-class=".live-title"
                         required />
                </div>
              </div>
              <!-- End Name Field -->

              <!-- Start Description Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Description</label>
                <div class="col-sm-10 col-md-9">
                  <input type="text" 
                         name="description" 
                         class="form-control live" 
                         required="required"
                         placeholder="Description Of The Item"
                         data-class=".live-desc" />
                </div>
              </div>
              <!-- End Description Field -->

              <!-- Start Price Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Price</label>
                <div class="col-sm-10 col-md-9">
                  <input type="text" 
                         name="price" 
                         class="form-control live" 
                         required="required" 
                         placeholder="Price Of The Item"
                         data-class=".live-price" />
                </div>
              </div>
              <!-- End Price Field -->

              <!-- Start Country_Made  Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Country</label>
                <div class="col-sm-10 col-md-9">
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
                <div class="col-sm-10 col-md-9">
                  <select class="form-control custom-select" name="status" required="required" >
                    <option value="">...</option>
                    <option value="1">New</option>
                    <option value="2">Like New</option>
                    <option value="3">Used</option>
                    <option value="4">Very Old</option>
                  </select>
                </div>
              </div>
              <!-- End Status Field -->

               

              <!-- Start Category  Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Category</label>
                <div class="col-sm-10 col-md-9">
                  <select class="form-control custom-select" name="category" required="required" >
                    <option value="">...</option>
                    <?php 
                        $cats  = getAllFrom( '*', 'categories','','' , 'ID');
                        foreach ($cats as $cat) {
                          
                          echo "<option value=' " . $cat['ID'] . " '>" . $cat['Name'] . "</option>";
                        }
                        ?>
                  </select>
                </div>
              </div>
              <!-- End Category Field -->

              <!-- Start Tags Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Tags</label>
                <div class="col-sm-10 col-md-9">
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
                <div class="col-sm-10 col-md-9">
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
                <!-- End Form -->
                </div>







                        
                        <div class="col-md-4">
                          <!-- -->
                             <div class="thumbnail item-box live-preview">
                             <span class="price-tag">
                              $<span class="live-price"></span>
                             </span>
                             <img class="img-responsive" src="index.jpg" alt="" />
                             <div class="caption">
                             <h3 class="live-title">Product Name</h3>
                             <p class="live-desc">Description</p>
                             </div>
                             </div>






                          <!-- -->
                          </div>
                          </div>
                          <!-- End Of Row -->

                          <!-- Start Looping Throw Errors -->
                          <?php
                          if(!empty($formErrors)){
                            foreach ($formErrors as $error) {
                              echo "<div class='alert alert-danger'>" . $error . "</div>";
                            }

                          }
                          if(isset($successMsg)){
                                echo '<div class="alert alert-success">' . $successMsg . '</div>';

                                        }


                       
                          ?>
                          <!-- End Looping Throw Errors -->
   				</div>
   			</div>
   	    </div>
   </div>
   <!--                                   #End1#                  -->
    
 

<?php
  }else{
      header('Location: login.php');
      exit();
  }
   include $tpl . 'footer.php' ; 
?>