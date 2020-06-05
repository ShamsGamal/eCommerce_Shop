/*
==
==
*/
//Start Page

//Dshboard//
     ///////////////////////////////////////////////////////////
$('.toggle-info').click(function(){
      $(this).toggleClass('selected').parent().next('.card-body').fadeToggle(100);
      if($(this).hasClass('selected')){
        $(this).html('<i class="fa fa-minus fa-lg"></i>');
        }else{
          $(this).html('<i class="fa fa-plus fa-lg"></i>');
        }
});

    ////////////////////////////////////////////////////////////
$(function(){
	'use strict';
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
    //Convert Password Field into Text Field on Hover
    var passField = $('.password'); //variable

    $(".show-pass").hover(function(){ //start function
    	passField.attr('type' , 'text');
    } , function(){
        passField.attr('type' , 'password');
 
    });
    ////////////////////////////////////////////////////////////
    //Confirmation Message on Button
    $('.confirm').click(function(){
    	return confirm('Are You Sure ?');

    });

    ///////////////////////////////////////////////////////////
    //Category View Option
    $('.cat h3').click(function(){
        $(this).next('.full-view').fadeToggle(300);

    });
   ///////////////////////////////////////////////////////////
   //Exchanging Class Active
   $('.option span').click(function(){
    $(this).addClass('active').siblings('span').removeClass('active');
    if($(this).data('view') === 'full'){
        $('.cat .full-view').fadeIn(200);
      }else{
        $('.cat .full-view').fadeOut(200);
      }
   });
  ///////////////////////////////////////////////////////////
  //Show Delete Button On Child Cats
  $('.child-link').hover(function(){
     $(this).find('.show-delete').fadeIn(400);

  } , function(){
      $(this).find('.show-delete').fadeOut(400);
  });
  ///////////////////////////////////////////////////////////
}); //End Page
