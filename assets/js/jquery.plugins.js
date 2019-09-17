jQuery.fn.doConfirm = function () {
  return this.each(function () {
    $(this).click(function () {
      lbl = $(this).attr('title') ? $(this).attr('title') + '?' : 'Вы уверены?'
      return window.confirm(lbl)
    })
  })
}
