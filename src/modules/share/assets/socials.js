(function () {
    function async_load()
    {
        // Twitter widget code
        var twitterWidgets = document.createElement('script');
        twitterWidgets.type = 'text/javascript';
        twitterWidgets.async = true;
        twitterWidgets.src = 'http://platform.twitter.com/widgets.js';
        // Facebook Like code
        var facebook = document.createElement('script');
        facebook.type = 'text/javascript';
        facebook.async = true;
        facebook.src = 'http://connect.facebook.net/ru_RU/all.js';
        // Google +1 code
        var po = document.createElement('script');
        po.type = 'text/javascript';
        po.async = true;
        po.src = 'https://apis.google.com/js/plusone.js';
        // Vkontakte Like code
        var vkontakte = document.createElement('script');
        vkontakte.type = 'text/javascript';
        vkontakte.async = true;
        vkontakte.src = 'http://userapi.com/js/api/openapi.js';
        // Creating scripts on page
        var x = document.getElementsByTagName('script')[0];
        x.parentNode.insertBefore(twitterWidgets, x);
        x.parentNode.insertBefore(po, x);
        x.parentNode.insertBefore(facebook, x);
        x.parentNode.insertBefore(vkontakte, x);
        //twitterWidgets.onload = _ga.trackTwitter;
    }

    if (window.attachEvent) {
        window.attachEvent('onload', async_load);
    } else {
        window.addEventListener('load', async_load, false);
    }
})();

window.fbAsyncInit = function () {
    FB.init({
        appId: getFBApiId(), status: true, cookie: true,
        xfbml: true
    });
    //_ga.trackFacebook();
};
window.vkAsyncInit = function () {
    VK.init({apiId: getVKApiId(), onlyWidgets: true});
    VK.Widgets.Like('vk_like', {type: 'button'});
    //_ga.trackVkontakte();
};
/*
_ga.trackVkontakte = function(opt_pageUrl, opt_trackerName, opt_targetUrl) {
    var trackerName = _ga.buildTrackerName_(opt_trackerName);
    try {
        if (VK && VK.Observer && VK.Observer.subscribe) {
            VK.Observer.subscribe('widgets.like.liked', function() {
                _gaq.push([trackerName + '_trackSocial', 'vkontakte', 'like', opt_targetUrl, opt_pageUrl]);
            });
                VK.Observer.subscribe('widgets.like.unliked', function() {
                _gaq.push([trackerName + '_trackSocial', 'vkontakte', 'unlike', opt_targetUrl, opt_pageUrl]);
            });
        }
    } catch (e) {}
};
*/
