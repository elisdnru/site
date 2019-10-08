(function() {
  var widget = document.querySelector('#uLogin');
  if (widget) {
    var active = false;
    window.addEventListener('scroll', function() {
      if (active || window.pageYOffset + window.innerHeight < widget.offsetTop - 200) {
        return;
      }
      var s = document.createElement('script');
      s.src = '//ulogin.ru/js/ulogin.js';
      s.async = true;
      document.querySelector('body').appendChild(s);
      active = true;
    });
  }
})();
