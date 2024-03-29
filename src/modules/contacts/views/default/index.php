<?php declare(strict_types=1);

use app\modules\user\models\Access;
use app\widgets\inline\MailTo;
use yii\web\View;

/**
 * @var View $this
 * @var array $series
 * @var array $items
 */
$this->context->layout = 'index';

$this->title = 'Контактные данные';

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Обратная связь, реквизиты и контактная информация',
]);

$this->params['breadcrumbs'] = [
    'Контактные данные',
];

if (Yii::$app->user->can(Access::CONTROL)) {
    if (Yii::$app->moduleAdminAccess->isGranted('page')) {
        $this->params['admin'][] = ['label' => 'Страницы', 'url' => ['/page/admin/page/index']];
    }
    if (Yii::$app->moduleAdminAccess->isGranted('blog')) {
        $this->params['admin'][] = ['label' => 'Записи', 'url' => ['/blog/admin/post/index']];
    }
}
?>

<section>
    <h1>Елисеев Дмитрий Николаевич</h1>

    <div class="text">
        <p>ИНН: 570600870325</p>
        <ul>
            <li><a href="https://www.fl.ru/users/elisdn/">Профиль на FL.ru</a></li>
            <li><a href="https://www.weblancer.net/users/ElisDN/">Профиль на weblancer.net</a></li>
        </ul>
        <ul>
            <li><a href="https://github.com/ElisDN">Профиль на GitHub</a></li>
        </ul>
        <ul>
            <li><a href="https://vk.com/elisdn">Я в VK</a></li>
            <li><a href="https://www.facebook.com/eliseev.dn">Я в FB</a> *</li>
            <li><a href="https://twitter.com/elisdnru">Я в Twitter</a></li>
            <li><a href="https://t.me/elisdn">Я в Telegram</a></li>
        </ul>
        <ul>
            <li><a href="https://vk.com/elisdnru">Паблик сайта в VK</a></li>
            <li><a href="https://www.facebook.com/elisdnru/">Паблик сайта в FB</a> *</li>
            <li><a href="https://t.me/elisdnru">Канал сайта в Telegram</a></li>
        </ul>
        <ul>
            <li><a href="https://vk.com/elisdn_live">Блог обо всём в VK</a></li>
            <li><a href="https://www.facebook.com/eliseev.dn">Блог обо всём в FB</a> *</li>
            <li><a href="https://www.instagram.com/elisdn_live/">Блог обо всём в Instagram</a> *</li>
        </ul>
        <p>Email: <span><?= MailTo::widget(['email' => 'mail@elisdn.ru']); ?></span></p>
        <p>* Компания Meta признана в России экстремистской организацией</p>
    </div>
</section>
