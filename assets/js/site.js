function translit (str) {

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
}

function transliterate (fromid, toid) {
  var _from = document.getElementById(fromid)
  var _to = document.getElementById(toid)
  if (_from && _to) {
    _to.value = translit(_from.value.toLowerCase())
  }
}

jQuery(function ($) {
  $('.tdruller').tdRuller()
  $('.confirm').doConfirm()

  $('.js_hide').hide()

  $('span[data-href]').each(function () {
    var span = $(this)
    span.replaceWith($('<a/>').attr('href', span.data('href')).html(span.html()))
  })

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
