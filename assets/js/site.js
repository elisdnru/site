window.getCSRFToken = function (){
  return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
};

(function(){
  var portlet = document.querySelector('.sidebar .portlet-fixed');
  var marker = document.querySelector('.bottom-marker');
  var wrapper = document.querySelector('#wrapper');
  if (portlet && marker) {
    window.addEventListener('scroll', function() {
      var offset = marker.offsetTop;
      var scrollYpos = window.pageYOffset;
      var width = wrapper.offsetWidth;
      if (scrollYpos > offset && width >= 780) {
        portlet.style.width = '258px';
        portlet.style.top = '10px';
        portlet.style.position = 'fixed';
      } else {
        portlet.style.width = '258px';
        portlet.style.top = 'auto';
        portlet.style.position = 'relative';
      }
    });
  }
})();

(function () {
  var images = document.querySelectorAll('img[data-src]');

  var config = {
    rootMargin: '50px 0px',
    threshold: 0.01
  };

  var loadImage = function (image) {
    if (image.src !== image.dataset.src) {
      image.src = image.dataset.src;
    }
    var sources = image.parentNode.querySelectorAll('source');
    [].forEach.call(sources, function (source) {
      source.srcset = source.dataset.srcset;
    });
  }

  var onChange = function (changes, observer) {
    changes.forEach(function (change) {
      if (change.intersectionRatio > 0) {
        loadImage(change.target);
        observer.unobserve(change.target);
      }
    });
  }

  if (window.IntersectionObserver) {
    var observer = new IntersectionObserver(onChange, config);
    [].forEach.call(images, function (image) { observer.observe(image); });
  } else {
    console.log('%cIntersection Observers not supported');
    [].forEach.call(images, function (image) { loadImage(image); });
  }
})();

(function () {
  function getLink(elem, selector) {
    if (elem.matches(selector)) {
      return elem;
    }

    if (elem.parentNode && elem.parentNode.matches && elem.parentNode.matches(selector)) {
      return elem.parentNode;
    }

    return null;
  }

  document.addEventListener('click', function (event) {
    var link = getLink(event.target, '.ajax_del');
    if (!link) {
      return;
    }

    var label = link.getAttribute('title') ? link.getAttribute('title') : 'Вы уверены?'
    if (!confirm(label)) {
      event.preventDefault();
      return;
    }

    event.preventDefault();

    var data = new FormData();
    data.set('_csrf', getCSRFToken());
    axios({
      method: 'post',
      url: link.href,
      data: data,
      config: { headers: {
          'Content-Type': 'multipart/form-data'
        }}
    })
      .then(function () {
        document.querySelector('#' + link.dataset.del).style.display = 'none'
      })
      .catch(function (error) {
        alert(error.response.data);
      });
  });

  document.addEventListener('click', function (event) {
    var link = getLink(event.target, '.ajax_load');
    if (!link) {
      return;
    }

    var label = link.getAttribute('title') ? link.getAttribute('title') : 'Вы уверены?'
    if (!confirm(label)) {
      event.preventDefault();
      return;
    }

    event.preventDefault();

    var data = new FormData();
    data.set('_csrf', getCSRFToken());
    axios({
      method: 'post',
      url: link.href,
      data: data,
      config: { headers: {
          'Content-Type': 'multipart/form-data'
        }}
    })
      .then(function (response) {
        document.querySelector('#' + link.dataset.del).innerHTML = response.data
      })
      .catch(function (error) {
        alert(error.response.data);
      });
  });

  document.addEventListener('click', function (event) {
    var link = getLink(event.target, '.ajax_post');
    if (!link) {
      return;
    }

    var label = link.getAttribute('title') ? link.getAttribute('title') : 'Вы уверены?'
    if (!confirm(label)) {
      event.preventDefault();
      return;
    }

    event.preventDefault();

    var data = new FormData();
    data.set('_csrf', getCSRFToken());
    axios({
      method: 'post',
      url: link.href,
      data: data,
      config: { headers: {
          'Content-Type': 'multipart/form-data'
        }}
    })
      .then(function () {})
      .catch(function (error) {
        alert(error.response.data);
      });
  });
})();
