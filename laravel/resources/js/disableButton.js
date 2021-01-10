$(function(){

  // submitボタンを1度クリックすると無効化（二重submit対策）
  $('form').submit(function() {
    $("button[type='submit']").prop("disabled", true);
  });

});
