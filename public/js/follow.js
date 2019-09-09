(function($) {
	$.fn.follow = function (data) {

		data = $.extend({
			assets_url: ''
		}, data || {});

		var blocks = [
			{
				name: 'RSS',
				image: '/32/feed.png',
				url: 'https://feeds.feedburner.com/elisdn'
			},
			{
				name: 'Twitter',
				image: '/32/twitter.png',
				url: 'https://twitter.com/elisdnru'
			},
			{
				name: 'GitHub',
				image: '/32/github.png',
				url: 'https://github.com/ElisDN'
			},
			{
				name: 'ВКонтакте',
				image: '/32/vkontakte.png',
				url: 'https://vk.com/elisdnru'
			},
			{
				name: 'Facebook',
				image: '/32/facebook.png',
				url: 'https://www.facebook.com/elisdnru/'
			},
		];

		return this.each(function () {
			var links = [];
			var curr;
			var url;
			for (var i = 0; i < blocks.length; i++) {
				curr = blocks[i];
				url = curr.url.split('&').join('&amp;');
				links.push('<a rel="nofollow" href="' + url + '" title="' + curr.name + '"><span style="background-image:url(\'' + data.assets_url + curr.image + '\');"></span></a>');
			}
			$(this).html(links.join("\r\n"));
		});
	};
})(jQuery);
