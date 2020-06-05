<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title><?php getTitle() ?></title>
  <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css" />
  <link rel="stylesheet" href="<?php echo $css; ?>font-awesome.min.css" />
  <link rel="stylesheet" href="<?php echo $css; ?>front.css" />
  <script>

    if ( window.history.replaceState ) {

        window.history.replaceState( null, null, window.location.href );

    }

</script>
</head>
<body>
  <div class="upper-bar">
    <div class="container">
      <?php
        if(isset($_SESSION['user'])){ 

         /*if(empty($_SESSION['avatar'])){
         echo "<img class='img-responsive img-thumbnail center-block img-circle'
                    src='admin/uploads/avatars/mona.jpg' 
                    style='width:50px; height:50px; border-radius:50%;'>
               ";
          }else{
              echo "<img src='admin/uploads/avatars/" . $_SESSION['avatar'] . "'style='width:50px; height:50px;' alt=''/>";
          }*/
            
            /*echo 'welcome' . $sessionUser . ' ' ;*/
            echo '<div class="upper-nav">';
            echo '<a href="profile.php">My Profile</a>' ;
            echo ' - <a href="newad.php">New Item</a>' ;
            echo ' - <a href="profile.php#my-ads">My Items</a>' ;
            echo ' - <a href="logout.php">Logout</a>' ;
            echo '</div>';
             

            $userStatus = checkUserStatus($sessionUser);
            if($userStatus == 1){//user not activated
                echo 'Your Membership Need To Activated By Admin';
            }



           }else{
      ?>
    <div class="reg-log-form">
     <a  href="login.php">
       <span class="pull-right">Signup / Login</span>
     </a>
   </div>
     <?php } ?>
  </div>
  </div>

<nav class="navbar navbar-expand-lg  ">

   
  <div class= "container">
  <a class="navbar-brand" href="index.php">
    <img src="layout/images/logo-img.png" style="width: 65px; height: 65px;">
    <span>E<span class="logo-name">lectro</span></span>
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#app-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
</div>

   
  
  <div class="container"> 
  <div class="collapse navbar-collapse " id="app-nav">

    <ul class="navbar-nav mr-auto ">

       <?php
$allCats = getAllFrom("*", "categories" ,"where parent = 0" ,"", "ID" , "ASC");
             
            foreach ($allCats as $cat) {
                     echo '<li>
                               <a class="nav-link" 
                               href=" categories.php?pageid='  .  $cat['ID'] 
                                 . ' ">' . 
                                                                        $cat['Name'] .
                               '</a>
                          </li>';
            }


       ?>

      </ul>

     </div>
   </div>


 </nav>
 