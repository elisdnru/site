jQuery.fn.tdRuller = function () {
  return this.each(function () {
    $(this).find('td').hover(function () {
        $(this).parent().find('td').addClass('hover')
      },
      function () {
        $(this).parent().find('td').removeClass('hover')
      })
    $(this).find('td').click(function () {
      $(this).parent().parent().find('td').removeClass('select')
      $(this).parent().find('td').addClass('select')
    })
  })
}

jQuery.fn.doConfirm = function () {
  return this.each(function () {
    $(this).click(function () {
      lbl = $(this).attr('title') ? $(this).attr('title') + '?' : 'Вы уверены?'
      return window.confirm(lbl)
    })
  })
}
