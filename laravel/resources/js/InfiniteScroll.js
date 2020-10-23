// 無限スクロール（inview.js）
$(function(){
  $(document).on('inview', 'a[infinity-scroll]', function (e, isInView) {
    if (isInView) {
      e.preventDefault()
      const $target = $(e.currentTarget)
      const url = $target.attr('href')
      if (url) {
        $.get(url, function (data, status) {
          $target.before(data.html)
          if (data.next) {
            $target.attr('href', data.next)
          } else {
            $target.remove();
          }
        });
      }
    }
  });
});
