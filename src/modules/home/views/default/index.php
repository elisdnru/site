<?php

use app\modules\block\widgets\BlockWidget;
use app\modules\blog\widgets\LastPostsWidget;
use app\modules\user\models\Access;
use yii\caching\TagDependency;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 */

$this->context->layout = 'index';

$this->title = 'Дмитрий Елисеев: Разработка сайтов и интернет-сервисов';

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Дмитрий Елисеев – разработчик сайтов, web-приложений, магазинов и порталов. Автор блога по Yii Framework, статей по программированию, интернет-разработке и профессиональному самосовершенствованию.',
]);

if (Yii::$app->user->can(Access::CONTROL)) {
    if (Yii::$app->moduleAdminAccess->isGranted('comment')) {
        foreach (Yii::$app->moduleAdminNotifications->notifications('comment') as $notification) {
            $this->params['admin'][] = $notification;
        }
    }
}
?>

<div class="home-hello">
    <p>
        <picture>
            <source srcset="/images/photo-150-150.webp" type="image/webp">
            <source srcset="/images/photo-150-150.jpg" type="image/jpeg">
            <img src="/images/photo-150-150.jpg" alt="Дмитрий Елисеев" width="150" height="150">
        </picture>
        Приветствую посетителей моего официального сайта. Мне есть о чём вам рассказать, а вам предоставляется
        возможность ознакомиться с техническими и философскими размышлениями ещё одного живого программиста.
        Жизнь не стоит на месте, и время от времени в ней появляется что-то новое и неизведанное.
        То, что предстоит осмыслить силами личного либо коллективного разума. Возможно, вы найдёте это здесь.
        В любом случае не останавливайтесь. Ищите новые задачи и присоединяйтесь к диалогу.
    </p>
</div>

<?php if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new TagDependency(['tags' => 'block'])])) : ?>
    <?= BlockWidget::widget(['id' => 'banner_index_top']) ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<h2 class="index">Новое в <a href="<?= Url::to(['/blog/default/index']) ?>">Блоге</a>:</h2>
<?php if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new TagDependency(['tags' => 'blog'])])) : ?>
    <?= LastPostsWidget::widget(['tpl' => 'home', 'limit' => 10]) ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<div class="clear"></div>
<p class="nomargin"><a href="<?= Url::to(['/blog/default/index', 'page' => 2]) ?>">Остальные записи &rarr;</a></p>
