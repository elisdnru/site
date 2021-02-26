(function () {
  var share = document.querySelector('#share');
  if (share) {
    var links = share.querySelectorAll('a');
    [].forEach.call(links, function (a) {
      a.addEventListener('click', function (event) {
        var a = event.target.parentNode
        var url = a.href
        window.open(url, a.title, 'width=640, height=480')
        event.preventDefault()
      })
    })
  }
})();
