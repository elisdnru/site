(function () {
  var share = document.querySelector('#share');
  if (share) {
    var providers = JSON.parse(share.dataset.providers);
    providers.forEach(function (provider) {
      var a = document.createElement('a')
      a.rel = 'nofollow'
      a.href = provider.url
      a.title = provider.name
      a.addEventListener('click', function (event) {
        var a = event.target.parentNode
        var url = a.href
        window.open(url, a.title, 'width=640, height=480')
        event.preventDefault()
      })

      var span = document.createElement('span')
      span.classList.add('share-' + provider.class)
      a.appendChild(span)

      share.appendChild(a)
    })
  }
})();
