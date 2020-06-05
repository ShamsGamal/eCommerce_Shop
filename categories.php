<?php include 'init.php' ; ?>


<div class="container">
 <h1 class="text-center">Show Category Items</h1>
       <div class="row">
         <?php
//$category =  isset($_GET['pageid']) && is_numeric($_GET['pageid']) ? intval($_GET['pageid']) : 0 ; 
  if(isset($_GET['pageid']) && is_numeric($_GET['pageid'])){
  $category = intval($_GET['pageid']) ;
  $allItems = getAllFrom('*' , 'items' , "WHERE Cat_ID = {$category}" ,'AND Approve = 1', 'Item_ID');

           foreach ($allItems as $item ) {
    	   echo '<div class="col-lg-4 col-sm-6">';
    	   echo '<div class="thumbnail item-box">' ;
    	         echo '<span class="price-tag">$' . $item['Price'] . '</span>';
    	         
               if(empty($item['image'])){
                  echo "<img src='admin/uploads/avatars/mouse-01.jpg'
                             class='img-responsive img-thumbnail center-block img-circle hvr-grow' style='width:250px; height:210px;'>";
                  }else{
                  echo "<img src='admin/uploads/avatars/" . $item['image'] . "'style='width:250px;  height:210px;' 
                         class='img-responsive img-thumbnail center-block img-circle hvr-grow'
                         alt=''/>";
                  }
    	         echo '<div class="caption">';
    	               echo '<h3>
                          <a href="items.php?itemid= '. $item['Item_ID'] .' ">' . $item['Name'] . '</a>
                          </h3>'; 
    	               echo '<p>' . $item['Description'] . '</p>';
                     echo '<div class="date">' . $item['Add_Date'] . '</div>';
    	         echo '</div>';
    	   echo '</div>';
    	   echo '</div>';
           }
         }else {
          echo ' You Must Add Page ID ';
         }

         ?>
       </div>
</div>




<?php include $tpl . 'footer.php' ; ?>
 