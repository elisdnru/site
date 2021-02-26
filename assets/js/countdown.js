(function ($) {
  const countdowns = document.querySelectorAll('.countdown');
  [].forEach.call(countdowns, function (countdown) {
    const title = countdown.dataset.title
    const date = new Date(countdown.dataset.date)
    $(countdown).eTimer({
      etType: 0,
      etDate: date.getDate().toString().padStart(2, '0') + '.' + (date.getMonth() + 1).toString().padStart(2, '0') + '.2019.' + date.getHours().toString().padStart(2, '0') + '.00',
      etTitleText: title,
      etTitleSize: 20,
      etShowSign: 1,
      etSep: ':',
      etFontFamily: 'Trebuchet MS',
      etTextColor: '#a3a3a3',
      etPaddingTB: 15,
      etPaddingLR: 15,
      etBackground: 'white',
      etBorderSize: 0,
      etBorderRadius: 2,
      etBorderColor: 'white',
      etShadow: ' 0px 0px 0px 0px #333333',
      etLastUnit: 4,
      etNumberFontFamily: 'Trebuchet MS',
      etNumberSize: 39,
      etNumberColor: '#484848',
      etNumberPaddingTB: 0,
      etNumberPaddingLR: 0,
      etNumberBackground: 'white',
      etNumberBorderSize: 0,
      etNumberBorderRadius: 10,
      etNumberBorderColor: 'white',
      etNumberShadow: 'inset 0px 0px 0px 0px rgba(0, 0, 0, 0.5)'
    })
  })
})(window.jQuery)
