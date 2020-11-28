$(function(){

  var $btn = $('.nav-button');
  var $menu = $('.menu-area');

  // クリック時のアニメーションとモーダルメニュー表示
  $btn.on('click', function() {
    if($(this).hasClass('active')){
      $(this).removeClass('active');
      $('.menu-area').slideUp();
    } else {
      $(this).addClass('active');
      $('.menu-area').slideDown();
    }
    return false;
  });

});
