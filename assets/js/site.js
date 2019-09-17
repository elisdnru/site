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

jQuery(function ($) {

  $('.js_hide').hide()

  $(document).on('click', 'a.ajax_del', function () {
    var t = $(this)
    if (!confirm(t.attr('title') + '?')) return false

    $.ajax({
      type: 'POST',
      url: $(this).attr('href'),
      data: { 'YII_CSRF_TOKEN': getCSRFToken() },
      success: function (data) {
        $('#' + t.data('del')).hide(500)
      },
      error: function (XHR) {
        alert(XHR.responseText)
      }
    })

    return false
  })

  $(document).on('click', 'a.ajax_load', function () {
    var t = $(this)
    if (!confirm(t.attr('title') + '?')) return false

    $.ajax({
      type: 'POST',
      url: $(this).attr('href'),
      data: { 'YII_CSRF_TOKEN': getCSRFToken() },
      success: function (data) {
        $('#' + t.data('load')).html(data)
      },
      error: function (XHR) {
        alert(XHR.responseText)
      }
    })

    return false
  })

  $(document).on('click', 'a.ajax_post', function () {
    var t = $(this)
    if (!confirm(t.attr('title') + '?')) return false

    $.ajax({
      type: 'POST',
      url: $(this).attr('href'),
      data: { 'YII_CSRF_TOKEN': getCSRFToken() },
      success: function (data) {
        alert('Успешно')
      },
      error: function (XHR) {
        alert(XHR.responseText)
      }
    })

    return false
  })

  $('ul.collapsed li:has(li.active)').addClass('sup_active')

  $('ul.collapsed > li:has(ul)').prepend($('<div>').addClass('collapse').prepend($('<span>').html('+')))

  $('ul.collapsed > li .collapse').click(function () {
    $(this).parent().find('>ul').slideToggle(300)
    return false
  })
})
