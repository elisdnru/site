(function () {
  document.addEventListener('click', function (event) {
    if (!event.target.matches('.ajax_like')) {
      return;
    }

    event.preventDefault();

    var data = new FormData();
    data.set('_csrf', getCSRFToken());
    fetch(event.target.dataset.url, {
      method: 'POST',
      credentials: 'same-origin',
      body: data,
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
      .then(function (response) {
        if (!response.ok) {
          throw Error(response.statusText);
        }
        return response;
      })
      .then(function (response) {
        return response.text();
      })
      .then(function (data) {
        document.querySelector('#' + event.target.dataset.load).innerHTML = data
      })
      .catch(function (error) {
        console.log(error);
      });
  });

  function setParentComment (id) {
    var parentField = document.querySelector('#comment-parent-id')
    if (typeof parentField != 'undefined') {
      parentField.value = id
    }
  }

  function initComments () {
    var form = document.querySelector('#comment-form')

    var replySpans = document.querySelectorAll('.comment .reply');

    [].forEach.call(replySpans, function (span) {
      var a = document.createElement('a')
      a.classList.add('reply')
      a.dataset.id = span.dataset.id
      a.href = '#comment-form'
      a.innerText = span.innerText
      span.parentNode.replaceChild(a, span)
    })

    var replyLinks = document.querySelectorAll('.comment .reply');
    [].forEach.call(replyLinks, function (link) {
      link.addEventListener('click', function () {
        var comment = link.parentNode.parentNode

        form.parentElement.removeChild(form)
        form.style['margin-left'] = (parseInt(comment.style['margin-left']) + 20) + 'px'
        comment.after(form)

        var id = parseInt(this.dataset.id)

        form.querySelector('form').setAttribute('action', '#comment_' + id)

        setParentComment(id)

        return false
      })
    })

    var replyToAll = document.querySelector('.reply-comment');
    if (replyToAll) {
      replyToAll.addEventListener('click', function () {
        form.parentElement.removeChild(form)
        form.style['margin-left'] = 0
        this.after(form)
        setParentComment(0)
        return false
      })
    }
  }

  initComments()
})();
