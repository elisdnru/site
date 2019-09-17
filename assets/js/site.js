window.translit = function (str) {
  var txt = str.replace(/[^а-яa-z0-9\-_\s]/gi, '')
  txt = txt.replace(/ /gi, '-')

  var ru2en = {
    ru_str: 'АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюя',
    en_str: [
      'A', 'B', 'V', 'G', 'D', 'E', 'IO', 'J', 'Z', 'I', 'I', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F',
      'H', 'C', 'CH', 'SH', 'SH', '', 'I', '', 'E', 'YU', 'IA',
      'a', 'b', 'v', 'g', 'd', 'e', 'io', 'j', 'z', 'i', 'i', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f',
      'h', 'c', 'ch', 'sh', 'sh', '', 'i', '', 'e', 'yu', 'ia'],
    translit: function (org_str) {
      var tmp_str = []
      for (var i = 0, l = org_str.length; i < l; i++) {
        var s = org_str.charAt(i), n = this.ru_str.indexOf(s)
        if (n >= 0) { tmp_str[tmp_str.length] = this.en_str[n] } else { tmp_str[tmp_str.length] = s }
      }
      return tmp_str.join('')
    }
  }
  return ru2en.translit(txt)
};

window.transliterate = function (fromid, toid) {
  var _from = document.getElementById(fromid)
  var _to = document.getElementById(toid)
  if (_from && _to) {
    _to.value = translit(_from.value.toLowerCase())
  }
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
  var spans = document.querySelectorAll('span[data-href]');
  [].forEach.call(spans, function (span) {
    var a = document.createElement('a')
    a.href = span.dataset.href
    a.innerHTML = span.innerHTML
    span.parentNode.replaceChild(a, span);
  })
})();

(function () {
  var elements = document.querySelectorAll('.js_hide');
  [].forEach.call(elements, function (element) {
    element.style.display = 'none'
  })
})();

(function () {
  function getLink(elem, selector) {
    if (elem.matches(selector)) {
      return elem;
    }

    if (elem.parentNode && elem.parentNode.matches(selector)) {
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
    data.set('YII_CSRF_TOKEN', getCSRFToken());
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
    data.set('YII_CSRF_TOKEN', getCSRFToken());
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
    data.set('YII_CSRF_TOKEN', getCSRFToken());
    axios({
      method: 'post',
      url: link.href,
      data: data,
      config: { headers: {
          'Content-Type': 'multipart/form-data'
        }}
    })
      .then(function () {
        alert('Успешно')
      })
      .catch(function (error) {
        alert(error.response.data);
      });
  });
})();
