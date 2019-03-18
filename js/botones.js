$(window).scroll(function(){
  if($(this).scrollTop() > 300){ 
    $("#up").slideDown(300); 
  }else{ 
    $("#up").slideUp(300); 
  }
});

$("#up i").on('click', function (e) { 
  e.preventDefault();
  $("body,html").animate({ 
    scrollTop: 0 
  },700); 
  return false; 
});