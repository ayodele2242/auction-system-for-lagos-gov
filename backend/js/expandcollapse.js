
$(function(){
  var animspeed = 950; // animation speed in milliseconds
  
  var $blockquote = $('.bigtext');
  var height = $blockquote.height();
  var mini = $('.bigtext p').eq(0).height() + $('.bigtext p').eq(1).height() + $('.bigtext p').eq(2).height() + $('.bigtext p').eq(2).height();
  
  $blockquote.attr('data-fullheight',height+'px');
  $blockquote.attr('data-miniheight',mini+'px');
  $blockquote.css('height',mini+'px');
  

  $('.expand').on('click', function(e){
    $text = $(this).prev();
    
    $text.animate({
      'height': $text.attr('data-fullheight')
    }, animspeed);
    $(this).next('.contract').removeClass('hide');
    $(this).addClass('hide');
  });
  
  $('.contract').on('click', function(e){
    $text = $(this).prev().prev();
    
    $text.animate({
      'height': $text.attr('data-miniheight')
    }, animspeed);
    $(this).prev('.expand').removeClass('hide');
    $(this).addClass('hide');
  });
});
