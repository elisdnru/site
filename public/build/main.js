jQuery.fn.grayText = function () {
    return this.each(function () {
        if ($(this).attr('type') == 'password') {
            document.getElementById($(this).attr('id')).setAttribute('type', 'text');
            $(this).data('type', 'password');
        }
        if (!$(this).val()) $(this).val($(this).attr('title'));
        if ($(this).val() == $(this).attr('title')) $(this).css('color', '#fff');
        $(this).focus(function () {
            if ($(this).val() == $(this).attr('title')) {
                $(this).val('');
                $(this).css('color', '#fff');
                if ($(this).data('type') == 'password') {
                    document.getElementById($(this).attr('id')).setAttribute('type', 'password');
                    $(this).focus();
                }
            }
        });
        $(this).blur(function () {
            if ($(this).val() == '') {
                $(this).val($(this).attr('title'));
                $(this).css('color', '#fff');
                if ($(this).data('type') == 'password') {
                    document.getElementById($(this).attr('id')).setAttribute('type', 'text');
                }
            }
        })
    })
};
jQuery.fn.tdRuller = function () {
    return this.each(function () {
        $(this).find('td').hover(function () {
                $(this).parent().find('td').addClass('hover');
            },
            function () {
                $(this).parent().find('td').removeClass('hover');
            });
        $(this).find('td').click(function () {
            $(this).parent().parent().find('td').removeClass('select');
            $(this).parent().find('td').addClass('select');
        })
    })
};
jQuery.fn.doConfirm = function () {
    return this.each(function () {
        $(this).click(function () {
            lbl = $(this).attr('title') ? $(this).attr('title') + '?' : 'Вы уверены?';
            return window.confirm(lbl);
        })
    })
};
jQuery.fn.doConfirm2 = function () {
};
(function($) {
	$.fn.share = function (data) {
		data = $.extend({
			enc_url: '',
			enc_title: '',
			enc_desc: '',
			enc_image: '',
			tw_status: '',
			assets_url: ''
		}, data || {});
		var blocks = [
			{
				name: 'ВКонтакте',
				image: '/32/vkontakte.png',
				url: 'http://vkontakte.ru/share.php?url=' +  data.enc_url + '&;title=' + data.enc_title + '&description=' + data.enc_desc + '&image=' + data.enc_image,
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
		];
		return this.each(function () {
			var links = [];
			var curr;
			var url;
			for (var i = 0; i < blocks.length; i++) {
				curr = blocks[i];
				url = curr.url.split('&').join('&amp;');
				links.push('<a rel="nofollow" onclick="window.open(\'' + url + '\', \'' + curr.name + '\', \'width=' + curr.width + ', height=' + curr.height + '\'); return false;" href="' + url + '" title="' + curr.name + '"><span style="background-image:url(\'' + data.assets_url + curr.image + '\');"></span></a>');
			}
			$(this).html(links.join("\r\n"));
		});
	};
})(jQuery);

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

function jc_setfrmfld(a)
{
	var rnd = Math.floor(Math.random()*10000);
	document.write('<div id=jc_frm_'+rnd+'></div>');
	var s=document.getElementById('jc_frm_'+rnd);
	var a = s.parentNode;
	var inp = a.getElementsByTagName('input');
	var td = inp.item(inp.length-1).parentNode;
}
function jc_chkscrfrm(a, phone, phone_req, city, city_req)
{
	if(a.lead_name && (a.lead_name.value=='' || a.lead_name.value.indexOf(" ваше ")>-1))
	{
		a.lead_name.focus();
		alert('Пожалуйста, введите ваше имя!');
		return false;
	}
	if(!a.lead_email)
	{
		alert('Отсутствует обязательное поле E-mail(lead_email)!');
		return false;
	}
	if(a.lead_email.value=='')
	{
		a.lead_email.focus();
		alert('Пожалуйста, введите ваш адрес E-mail!');
		return false;
	}
	else
	{
		var b=/^[a-z0-9_\-\.\+]+@([a-z0-9]+[\-\.])*[a-z0-9]+\.[a-z]{2,6}$/i;
		if(!b.test(a.lead_email.value))
		{
			a.lead_email.focus();
			alert('Пожалуйста, введите КОРРЕКТНЫЙ адрес E-mail!');
			return false;
		}
	}
	var oferta = document.getElementById('offerta_accept');
	if(oferta && !oferta.checked)
	{
		oferta.focus();
		alert('Вы должны принять условия оферты!');
		return false;
	}
	if(phone && phone_req && a.lead_phone && (a.lead_phone.value=='' || a.lead_phone.value.indexOf(" ваш ") >- 1))
	{
		a.lead_phone.focus();
		alert('Пожалуйста, введите ваш номер телефона!');
		return false;
	}
	if (city && city_req && a.lead_city && (a.lead_city.value == '' || a.lead_city.value.indexOf(" ваш ") >- 1))
	{
		a.lead_city.focus();
		alert('Пожалуйста, введите ваш город!');
		return false;
	}
	return true;
}

function translit(str){
    var txt = str.replace(/[^а-яa-z0-9\-_\s]/gi, "");
    txt = txt.replace(/ /gi, "-");
    var ru2en = {
        ru_str : "АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюя",
        en_str : [
            'A','B','V','G','D','E','IO','J','Z','I','I','K','L','M','N','O','P','R','S','T','U','F',
            'H','C','CH','SH','SH','','I','','E','YU','IA',
            'a','b','v','g','d','e','io','j','z','i','i','k','l','m','n','o','p','r','s','t','u','f',
            'h','c','ch','sh','sh','','i','','e','yu','ia'],
        translit : function(org_str) {
            var tmp_str = [];
            for(var i = 0, l = org_str.length; i < l; i++) {
                var s = org_str.charAt(i), n = this.ru_str.indexOf(s);
                if(n >= 0) { tmp_str[tmp_str.length] = this.en_str[n]; }
                else { tmp_str[tmp_str.length] = s; }
            }
            return tmp_str.join("");
        }
    };
    return ru2en.translit(txt);
}
function transliterate(fromid, toid){
    var _from = document.getElementById(fromid);
    var _to = document.getElementById(toid);
    if (_from && _to){
        _to.value = translit(_from.value.toLowerCase());
    }
}
