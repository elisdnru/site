;(function () {
  const auths = document.querySelectorAll('.auth')
  ;[].forEach.call(auths, function (auth) {
    const items = auth.querySelectorAll('span')
    ;[].forEach.call(items, function (item) {
      item.addEventListener('click', function (event) {
        window.open(item.dataset.href, item.title, 'width=640, height=480')
        event.preventDefault()
      })
    })
  })
})()
