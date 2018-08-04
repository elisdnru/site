(function($) {
	$.fn.follow = function (data) {

		data = $.extend({
			rss: '',
			twitter: '',
			livejournal: '',
			github: '',
			assets_url: ''
		}, data || {});

		var blocks = [
			{
				name: 'RSS',
				image: '/32/feed.png',
				url: data.rss
			},
			{
				name: 'Twitter',
				image: '/32/twitter.png',
				url: 'http://twitter.com/' + data.twitter
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
				name: 'Google+',
				image: '/32/googleplus.png',
				url: 'https://plus.google.com/116153200022401064957'
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
