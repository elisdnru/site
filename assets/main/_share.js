;(function () {
  const share = document.querySelector('#share')
  if (share) {
    const links = share.querySelectorAll('a')
    ;[].forEach.call(links, function (a) {
      a.addEventListener('click', function (event) {
        const a = event.target.parentNode
        window.open(a.href, a.title, 'width=640, height=480')
        event.preventDefault()
      })
    })
  }
})()
