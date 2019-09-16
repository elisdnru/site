jQuery.fn.follow = function () {

  var blocks = [
    {
      name: 'RSS',
      class: 'feed',
      url: 'https://feeds.feedburner.com/elisdn'
    },
    {
      name: 'Twitter',
      class: 'twitter',
      url: 'https://twitter.com/elisdnru'
    },
    {
      name: 'GitHub',
      class: 'github',
      url: 'https://github.com/ElisDN'
    },
    {
      name: 'ВКонтакте',
      class: 'vkontakte',
      url: 'https://vk.com/elisdnru'
    },
    {
      name: 'Facebook',
      class: 'facebook',
      url: 'https://www.facebook.com/elisdnru/'
    },
  ]

  return this.each(function () {
    var links = []
    var curr
    var url
    for (var i = 0; i < blocks.length; i++) {
      curr = blocks[i]
      url = curr.url.split('&').join('&amp;')
      links.push('<a rel="nofollow" href="' + url + '" title="' + curr.name + '"><span class="follow-' + curr.class + '"></span></a>')
    }
    $(this).html(links.join('\r\n'))
  })
}

