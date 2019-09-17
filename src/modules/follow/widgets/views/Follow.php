<p id="followMe" class="follow center"></p>

<script>
<?php ob_start(); ?>

(function() {
    var blocks = [
        {name: 'RSS', class: 'feed', url: 'https://feeds.feedburner.com/elisdn'},
        {name: 'Twitter', class: 'twitter', url: 'https://twitter.com/elisdnru'},
        {name: 'GitHub', class: 'github', url: 'https://github.com/ElisDN'},
        {name: 'ВКонтакте', class: 'vkontakte', url: 'https://vk.com/elisdnru'},
        {name: 'Facebook', class: 'facebook', url: 'https://www.facebook.com/elisdnru/'},
    ]
    var links = []
    for (var i = 0; i < blocks.length; i++) {
        links.push('<a rel="nofollow" href="' + blocks[i].url + '" title="' + blocks[i].name + '"><span class="follow-' + blocks[i].class + '"></span></a>')
    }
    document.getElementById('followMe').innerHTML = links.join('\r\n')
})();

<?php Yii::app()->clientScript->registerScript(__FILE__ . __LINE__, ob_get_clean(), CClientScript::POS_END); ?>
</script>

<div class="subscribe-form">
    <form method="post" action="//elisdn.justclick.ru/subscribe/process/?rid%5B0%5D=blog" target="_blank" onsubmit="return jc_chkscrfrm(this, false, false, false, false)">
        <div class="row">
            <input type="text" name="lead_name" placeholder="Ваше имя" />
        </div>
        <div class="row">
            <input type="email" name="lead_email" placeholder="Ваш Email" />
        </div>
        <div class="row button">
            <input type="submit" name="submit" value="Подписаться на статьи" />
        </div>
    </form>
</div>
<p class="what-there">Узнавайте о полезных статьях,<br />не пропускайте видеоуроки,<br />получайте бонусы.</p>

