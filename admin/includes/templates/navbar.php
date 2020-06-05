<nav class="navbar navbar-expand-lg ">
  <div class="container">
  <a class="navbar-brand" href="dashboard.php">

    <img src="layout/images/logo-img.png" style="width: 65px; height: 65px;">
    <span>E<span class="logo-name">lectro</span></span>
    
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#app-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon">MENU</span>
  </button>
   
  <div class="collapse navbar-collapse" id="app-nav">
    <ul class="navbar-nav mr-auto">
      <li><a class="nav-link" href="categories.php"><?php echo lang('CATEGORIES'); ?></a></li>
      <li class="nav-item"><a class="nav-link" href="items.php"><?php echo lang('ITEMS'); ?></a></li>
      <li class="nav-item"><a class="nav-link" href="members.php"><?php echo lang('MEMBERS'); ?></a></li>
      <li class="nav-item"><a class="nav-link" href="comments.php"><?php echo lang('COMMENTS'); ?></a></li>
       

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Admin
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">

          <a class="dropdown-item" href="../index.php">Visit Shop</a>
          <a class="dropdown-item" href="members.php?do=Edit&userid=<?php echo $_SESSION['ID'] ?>">Edit Profile</a>
           
          <a class="dropdown-item" href="logout.php">LogOut</a>
        </div>
      </li>
       
    </ul>
     
  </div>
</div>
</nav>