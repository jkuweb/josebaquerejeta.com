$(document).ready(function($){

	$('#menu-handler').on('click', function () {
	  $(this).fadeOut(300, function() {
		$(this).toggleClass('icon-close').fadeIn(300);
	  });
		$('.navigation').toggleClass('displayed');
	});
	$('.sub-menu-parent').on('click', function () {
	  $(this).fadeOut(300, function() {
		$(this).fadeIn(300);
	  });
		$('.sub-menu').toggleClass('displayed');
	});
  
  });
