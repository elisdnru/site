<?php declare(strict_types=1);

use yii\web\View;

/**
 * @var View $this
 */
?>

<script>
<?php ob_start(); ?>
(function (m, e, t, r, i, k, a) {
    m[i] = m[i] || function () {(m[i].a = m[i].a || []).push(arguments)}
    m[i].l = 1 * new Date()
    k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
})(window, document, 'script', 'https://cdn.jsdelivr.net/npm/yandex-metrica-watch/tag.js', 'ym');
ym(18406216, 'init', {
    clickmap: false,
    trackLinks: true,
    accurateTrackBounce: false,
    webvisor: false
});
<?php $this->registerJs(ob_get_clean(), View::POS_END); ?>
</script>
<noscript>
    <div><img src="https://mc.yandex.ru/watch/18406216" style="position:absolute; left:-9999px;" alt=""></div>
</noscript>

<script>
<?php ob_start(); ?>
var _gaq = _gaq || []
_gaq.push(['_setAccount', 'UA-3647' + '7750-1'])
_gaq.push(['_trackPageview']);
(function () {
    var ga = document.createElement('script')
    ga.type = 'text/javascript'
    ga.async = true
    ga.src = ('https:' === document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'
    var s = document.getElementsByTagName('script')[0]
    s.parentNode.insertBefore(ga, s)
})();
<?php $this->registerJs(ob_get_clean(), View::POS_END); ?>
</script>

<script>
<?php ob_start(); ?>
(function () {
    var t = document.createElement("script");
    t.type = 'text/javascript';
    t.async = true;
    t.src = 'https://vk.com/js/api/openapi.js?168';
    t.onload = function () {
        VK.Retargeting.Init('VK-RTRG-515571-5cyiW');
        VK.Retargeting.Hit()
    };
    document.head.appendChild(t)
})();
<?php $this->registerJs(ob_get_clean(), View::POS_END); ?>
</script>
<noscript><img src="https://vk.com/rtrg?p=VK-RTRG-515571-5cyiW" style="position:fixed; left:-999px;" alt=""/></noscript>
