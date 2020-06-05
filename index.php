<?php
   ob_start(); 
   session_start();
   $pageTitle = 'Homepage'; //describe page title
   include 'init.php' ;
   ?>



<div class="container">
     <div  class="img-header text-center">
     <img class="img-fluid"src="layout/images/home-img.jpg" alt="Image-Header-PC" />
     </div>
      <h1 class="text-center">Recently Items</h1>
       <div class="row">
          
         <?php
         $allItems = getAllFrom('*' , 'items' , 'where Approve=1','', 'Item_ID');
           foreach ($allItems as $item ) {
    	   echo '<div class="col-lg-4 col-sm-6">';
    	   echo '<div class="thumbnail item-box">' ;
    	         echo '<span class="price-tag">$' . $item['Price'] . '</span>';

               
               if(empty($item['image'])){
                  echo "<img src='admin/uploads/avatars/mouse-01.jpg' 
                             class='img-responsive img-thumbnail center-block img-circle hvr-grow'
                             style='width:250px; height:210px;'>";
                  }else{
                  echo "<img src='admin/uploads/avatars/" . $item['image'] . "'style='width:250px; height:210px;' class='img-responsive img-thumbnail center-block img-circle hvr-grow' alt=''/>";
                  }

    	           
                           

    	         echo '<div class="caption">';
    	               echo '<h3>
                          <a href="items.php?itemid= '. $item['Item_ID'] .' ">' . $item['Name'] . '</a>
                          </h3>'; 
    	               echo '<p class="lead">' . $item['Description'] . '</p>';
                     echo '<div class="date">' . $item['Add_Date'] . '</div>';
    	         echo '</div>';
    	   echo '</div>';
    	   echo '</div>';
           }
         ?>

        
     </div>
     <hr/>
                                        <!--Start Paragraph-->
    <div class="paragraph-homepage">
      <h3>Electro Egypt – Online Shopping Website</h3>
      <p>Online shopping sites are now part of our everyday lives, because everyone enjoys the possibility of being able to buy whatever they need, whether it’s clothing or electronics, without having to move an inch. It’s even better when you can buy everything you’re looking for, all from the same store. This is what Jumia Egypt offers and that’s what makes it one of the best online shopping websites in Egypt.</p>
      <h3>Enjoy Endless Deals & Discounts</h3>
      <p>Electro is an easy platform to use when you’re online shopping for any type of products you’re looking for. Even if you’re just browsing, we assure you that you will find something you like in our catalog. Our clothing store provides you with over one million products and variations to choose from! You can shop for anything you need from women fashion to baby clothes and get the latest fashion. Jumia Egypt is one of the biggest online shopping sites because we always try to expand our catalog to provide any possible products or gadgets our customer could be searching to buy online!</p>
      <h3>Discover the Online Shopping World</h3>
      <p>Jumia Egypt offers deals and discounts and never ceases to form campaigns all year around, all for the satisfaction and joy of our customers. Our newsletter subscribers and Facebook fans get to know all of our offers before anyone else such as Mobile & Tech Week, Ramadan, Jumia Anniversary, and Black Friday. Also, You can buy tickets for concerts and important events online @ Jumia. We have a dedicated team who will answer your questions instantly on social media and customer service is available through the week to help solve any issues and answer all inquiries, simply reach us as 19586. Moreover, you can join Jumia’s partnership team to open your shop on Jumia Egypt and sell your products to our customers. Jumia Egypt promises to provide you with the best service and 100% genuine products. We deliver your order at your doorstep as fast as possible, offer you safe and secure payments and also provide free returns, which you can read more about in our refund and return policy. Stay tuned and get the best prices in Egypt on all your favorite products!</p>

    </div>





                                        <!--End Paragraph-->
</div>


<?php
   include $tpl . 'footer.php' ; 
   ob_end_flush();
?>