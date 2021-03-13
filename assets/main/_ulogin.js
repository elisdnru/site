;(function () {
  const widget = document.querySelector('#uLogin')
  if (!widget) {
    return
  }

  const config = {
    rootMargin: '50px 0px',
    threshold: 0.01,
  }

  const loadWidget = function () {
    const s = document.createElement('script')
    s.src = 'https://ulogin.ru/js/ulogin.js'
    s.async = true
    document.querySelector('body').appendChild(s)
  }

  const onChange = function (changes, observer) {
    changes.forEach(function (change) {
      if (change.intersectionRatio > 0) {
        loadWidget()
        observer.unobserve(change.target)
      }
    })
  }

  if (window.IntersectionObserver) {
    const observer = new IntersectionObserver(onChange, config)
    observer.observe(widget)
  } else {
    console.log('%cIntersection Observers not supported')
    loadWidget()
  }
})()
