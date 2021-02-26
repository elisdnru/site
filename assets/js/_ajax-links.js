import getCSRFToken from './csrf'
;(function () {
  function getLink(elem, selector) {
    if (elem.matches(selector)) {
      return elem
    }

    if (
      elem.parentNode &&
      elem.parentNode.matches &&
      elem.parentNode.matches(selector)
    ) {
      return elem.parentNode
    }

    return null
  }

  document.addEventListener('click', function (event) {
    const link = getLink(event.target, '.ajax-del')
    if (!link) {
      return
    }

    const label = link.getAttribute('title')
      ? link.getAttribute('title')
      : 'Вы уверены?'
    if (!confirm(label)) {
      event.preventDefault()
      return
    }

    event.preventDefault()

    const data = new FormData()
    data.set('_csrf', getCSRFToken())
    fetch(link.href, {
      method: 'POST',
      credentials: 'same-origin',
      body: data,
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
      },
    })
      .then(function (response) {
        if (!response.ok) {
          throw Error(response.statusText)
        }
        return response
      })
      .then(function () {
        document.querySelector('#' + link.dataset.del).style.display = 'none'
      })
      .catch(function (error) {
        alert(error.message)
      })
  })

  document.addEventListener('click', function (event) {
    const link = getLink(event.target, '.ajax-load')
    if (!link) {
      return
    }

    const label = link.getAttribute('title')
      ? link.getAttribute('title')
      : 'Вы уверены?'
    if (!confirm(label)) {
      event.preventDefault()
      return
    }

    event.preventDefault()

    const data = new FormData()
    data.set('_csrf', getCSRFToken())
    fetch(link.href, {
      method: 'POST',
      credentials: 'same-origin',
      body: data,
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
      },
    })
      .then(function (response) {
        if (!response.ok) {
          throw Error(response.statusText)
        }
        return response
      })
      .then(function (response) {
        return response.text()
      })
      .then(function (data) {
        document.querySelector('#' + link.dataset.del).innerHTML = data
      })
      .catch(function (error) {
        alert(error.message)
      })
  })

  document.addEventListener('click', function (event) {
    const link = getLink(event.target, '.ajax-post')
    if (!link) {
      return
    }

    const label = link.getAttribute('title')
      ? link.getAttribute('title')
      : 'Вы уверены?'
    if (!confirm(label)) {
      event.preventDefault()
      return
    }

    event.preventDefault()

    const data = new FormData()
    data.set('_csrf', getCSRFToken())
    fetch(link.href, {
      method: 'POST',
      credentials: 'same-origin',
      body: data,
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
      },
    })
      .then(function (response) {
        if (!response.ok) {
          throw Error(response.statusText)
        }
        return response
      })
      .catch(function (error) {
        alert(error.message)
      })
  })
})()
