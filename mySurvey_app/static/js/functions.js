/*
	Javascript for MySurvey Project
	Boston University MET CS673
	Software Engineering
	Fall 2013
*/


$(document).ready(function(){


   
   
   //-------------------- Default Hompage with Login & Register Buttons --------------------//
   
   $('#login-logout').show();
   $('#login').hide();
   $('#register').hide();
   
   


   //-------------------- Show/Hide Login --------------------//
   $('#sign-in').click(function(){
   		
   		$('#login-logout').hide();
   		$('#login').show();
   		$('#register').hide();
   		
   });
   
   
   $('#sign-in-btn').click(function(){
   		
   		$('#login-logout').hide();
   		$('#login').show();
   		$('#register').hide();
   		
   });
   
   
   
   //-------------------- Show/Hide Registration --------------------// 
   $('#register-btn').click(function(){
   		
   		$('#login-logout').hide();
   		$('#login').hide();
   		$('#register').show();
   		
   });
   
   $('#register-link').click(function(){
   		
   		$('#login-logout').hide();
   		$('#login').hide();
   		$('#register').show();
   		
   });



   //-------------- Top Half Content Height = Window Size --------------//

   $(function(){
	   $('#top-half').css({'height': (($(window).height())-244)+'px'});
   
	   $(window).resize(function(){
		   $('#top-half').css({'height':(($(window).height())-244)+'px'});    
	   });
   
   });


});