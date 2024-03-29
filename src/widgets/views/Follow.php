<?php declare(strict_types=1);

use yii\helpers\Html;

$providers = [
    ['name' => 'RSS', 'class' => 'feed', 'url' => 'https://feeds.feedburner.com/elisdn'],
    ['name' => 'Twitter', 'class' => 'twitter', 'url' => 'https://twitter.com/elisdnru'],
    ['name' => 'GitHub', 'class' => 'github', 'url' => 'https://github.com/ElisDN'],
    ['name' => 'ВКонтакте', 'class' => 'vkontakte', 'url' => 'https://vk.com/elisdnru'],
];
?>

<div class="follow">
    <?php foreach ($providers as $provider): ?>
        <a rel="noopener" href="<?= Html::encode($provider['url']); ?>" title="<?= Html::encode($provider['name']); ?>"><span class="follow-<?= $provider['class']; ?>"></span></a>
    <?php endforeach; ?>
</div>

<div class="subscribe-form">
    <form method="post" action="#" data-action="//elisdn.justclick.ru/subscribe/process/?rid%5B0%5D=blog" target="_blank">
        <div class="row">
            <input type="text" name="lead_name" placeholder="Ваше имя" required />
        </div>
        <div class="row">
            <input type="email" name="lead_email" placeholder="Ваш Email" required />
        </div>
        <div class="row">
            <label><input type="checkbox" required /> согласен с <a target="_blank" href="/privacy">политикой</a></label>
        </div>
        <div class="row button">
            <button type="submit">Подписаться на новости</button>
        </div>
    </form>
</div>
<p class="what-there">Узнавайте о полезных статьях,<br />не пропускайте видеоуроки,<br />получайте бонусы.</p>

