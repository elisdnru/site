function jc_setfrmfld (a) {

  var rnd = Math.floor(Math.random() * 10000)
  document.write('<div id=jc_frm_' + rnd + '></div>')
  var s = document.getElementById('jc_frm_' + rnd)
  var a = s.parentNode
  var inp = a.getElementsByTagName('input')
  var td = inp.item(inp.length - 1).parentNode

}

function jc_chkscrfrm (a, phone, phone_req, city, city_req) {
  if (a.lead_name && (a.lead_name.value == '' || a.lead_name.value.indexOf(' ваше ') > -1)) {
    a.lead_name.focus()
    alert('Пожалуйста, введите ваше имя!')
    return false
  }
  if (!a.lead_email) {
    alert('Отсутствует обязательное поле E-mail(lead_email)!')
    return false
  }
  if (a.lead_email.value == '') {
    a.lead_email.focus()
    alert('Пожалуйста, введите ваш адрес E-mail!')
    return false
  } else {
    var b = /^[a-z0-9_\-\.\+]+@([a-z0-9]+[\-\.])*[a-z0-9]+\.[a-z]{2,6}$/i
    if (!b.test(a.lead_email.value)) {
      a.lead_email.focus()
      alert('Пожалуйста, введите КОРРЕКТНЫЙ адрес E-mail!')
      return false
    }
  }
  var oferta = document.getElementById('offerta_accept')
  if (oferta && !oferta.checked) {
    oferta.focus()
    alert('Вы должны принять условия оферты!')
    return false
  }
  if (phone && phone_req && a.lead_phone && (a.lead_phone.value == '' || a.lead_phone.value.indexOf(' ваш ') > -1)) {
    a.lead_phone.focus()
    alert('Пожалуйста, введите ваш номер телефона!')
    return false
  }
  if (city && city_req && a.lead_city && (a.lead_city.value == '' || a.lead_city.value.indexOf(' ваш ') > -1)) {
    a.lead_city.focus()
    alert('Пожалуйста, введите ваш город!')
    return false
  }
  return true
}
