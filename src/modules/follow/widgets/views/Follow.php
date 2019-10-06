<div id="follow" class="follow"></div>

<script>
<?php ob_start(); ?>

(function() {
    var blocks = [
        {name: 'RSS', class: 'feed', url: 'https://feeds.feedburner.com/elisdn'},
        {name: 'Twitter', class: 'twitter', url: 'https://twitter.com/elisdnru'},
        {name: 'GitHub', class: 'github', url: 'https://github.com/ElisDN'},
        {name: 'ВКонтакте', class: 'vkontakte', url: 'https://vk.com/elisdnru'},
        {name: 'Facebook', class: 'facebook', url: 'https://www.facebook.com/elisdnru/'}
    ];
    var follow = document.querySelector('#follow');
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
})();

<?php Yii::app()->clientScript->registerScript(__FILE__ . __LINE__, ob_get_clean(), CClientScript::POS_END); ?>
</script>

<div class="subscribe-form">
    <form method="post" action="//elisdn.justclick.ru/subscribe/process/?rid%5B0%5D=blog" target="_blank">
        <div class="row">
            <input type="text" name="lead_name" placeholder="Ваше имя" required />
        </div>
        <div class="row">
            <input type="email" name="lead_email" placeholder="Ваш Email" required />
        </div>
        <div class="row button">
            <input type="submit" name="submit" value="Подписаться на статьи" />
        </div>
    </form>
</div>
<p class="what-there">Узнавайте о полезных статьях,<br />не пропускайте видеоуроки,<br />получайте бонусы.</p>

