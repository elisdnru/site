(function() {
  var follow = document.querySelector('#follow');

  if (follow) {
    var blocks = [
      {name: 'RSS', class: 'feed', url: 'https://feeds.feedburner.com/elisdn'},
      {name: 'Twitter', class: 'twitter', url: 'https://twitter.com/elisdnru'},
      {name: 'GitHub', class: 'github', url: 'https://github.com/ElisDN'},
      {name: 'ВКонтакте', class: 'vkontakte', url: 'https://vk.com/elisdnru'},
      {name: 'Facebook', class: 'facebook', url: 'https://www.facebook.com/elisdnru/'}
    ];

    blocks.forEach(function (block) {
      var a = document.createElement('a');
      a.rel = 'nofollow';
      a.href = block.url;
      a.title = block.name;
      var span = document.createElement('span');
      span.classList.add('follow-' + block.class);
      a.appendChild(span);
      follow.appendChild(a);
    });
  }
})();
