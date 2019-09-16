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
