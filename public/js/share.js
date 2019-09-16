jQuery.fn.share = function (data) {

  data = jQuery.extend({
    enc_url: '',
    enc_title: '',
    enc_desc: '',
    enc_image: '',
    tw_status: '',
    assets_url: ''
  }, data || {})

  var blocks = [
    {
      name: 'ВКонтакте',
      image: '/32/vkontakte.png',
      url: 'http://vkontakte.ru/share.php?url=' + data.enc_url + '&;title=' + data.enc_title + '&description=' + data.enc_desc + '&image=' + data.enc_image,
      width: 626,
      height: 436
    },
    {
      name: 'Twitter',
      image: '/32/twitter.png',
      url: 'http://twitter.com/home/?status=' + data.tw_status,
      width: 640,
      height: 480
    },
    {
      name: 'Facebook',
      image: '/32/facebook.png',
      url: 'http://www.facebook.com/sharer.php?u=' + data.enc_url + '&t=' + data.enc_title,
      width: 626,
      height: 436
    },
    {
      name: 'Одноклассники',
      image: '/32/odnoklassniki.png',
      url: 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=' + data.enc_url,
      width: 626,
      height: 436
    },
    {
      name: 'Яндекс',
      image: '/32/yandex.png',
      url: 'http://wow.ya.ru/posts_share_link.xml?url=' + data.enc_url + '&title=' + data.enc_title + '&body=' + data.enc_desc,
      width: 626,
      height: 436
    },
    {
      name: 'Живой журнал',
      image: '/32/livejournal.png',
      url: 'http://www.livejournal.com/update.bml?event=' + data.enc_desc + '%3Cbr+%2F%3E' + data.enc_url + '&subject=' + data.enc_title + '&body=' + data.enc_desc,
      width: 626,
      height: 436
    }
  ]

  return this.each(function () {
    var links = []
    var curr
    var url
    for (var i = 0; i < blocks.length; i++) {
      curr = blocks[i]
      url = curr.url.split('&').join('&amp;')
      links.push('<a rel="nofollow" onclick="window.open(\'' + url + '\', \'' + curr.name + '\', \'width=' + curr.width + ', height=' + curr.height + '\'); return false;" href="' + url + '" title="' + curr.name + '"><span style="background-image:url(\'' + data.assets_url + curr.image + '\');"></span></a>')
    }
    jQuery(this).html(links.join('\r\n'))
  })
}
