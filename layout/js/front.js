/*
==
==
*/
//Start Page

//FrontEnd//
     
 
////////////////////////////////////////////////////////////
$(function(){
	'use strict';
  //Switch Between Login and Signup
  $('.login-page h1 span').click(function(){
        
       $(this).addClass('selected').siblings().removeClass('selected');
       $('.login-page form').hide();
       $('.' + $(this).data('class')).fadeIn(100);
     //  $('.login-page .col-g').css('color','#C0C0C0');
      // $('.login-page .col-b').css('color','#C0C0C0');


  });
///////////////////////////////////////////////////////
	//Hide Placeholder when Form Focus
	$('[Placeholder]').focus(function(){
		$(this).attr('data-text' , $(this).attr('Placeholder'));
		$(this).attr('Placeholder' , ' ');

	}).blur(function(){
        $(this).attr('Placeholder' , $(this).attr('data-text'));
	});
    ///////////////////////////////////////////////////////////

    // Add Asterisk * on the Required Filed
    $('input').each(function (){
    	if($(this).attr('required') === 'required'){
    		$(this).after('<span class="asterisk"> * </span>');

    	}

     });
    
    ////////////////////////////////////////////////////////////
    //Confirmation Message on Button
    $('.confirm').click(function(){
    	return confirm('Are You Sure ?');

    });

    ///////////////////////////////////////////////////////////
    $('.live').keyup(function(){
     // $('.live-preview .caption h3').text($(this).val());
     //console.log
     $($(this).data('class')).text($(this).val());

    });

     
    ///////////////////////////////////////////////////////////
    
}); //End Page
