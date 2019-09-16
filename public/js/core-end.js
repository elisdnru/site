(function ($) {
  $('.graytext').grayText()

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
})(jQuery)
