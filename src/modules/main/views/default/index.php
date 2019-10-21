<?php
/** @var $this Controller */

use app\extensions\cachetagging\Tags;
use app\components\Controller;
use app\modules\user\models\Access;

$this->layout = '/layouts/index';

$this->title = 'Дмитрий Елисеев: Разработка сайтов и интернет-сервисов';

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Дмитрий Елисеев – разработчик сайтов, web-приложений, магазинов и порталов. Автор блога по Yii Framework, статей по программированию, интернет-разработке и профессиональному самосовершенствованию.',
]);

if (Yii::app()->user->checkAccess(Access::ROLE_CONTROL)) {
    if (Yii::app()->moduleManager->allowed('contact')) {
        $this->params['admin'] = array_merge($this->params['admin'] ?? [], Yii::app()->moduleManager->notifications('contact'));
        $this->params['admin'] = array_merge($this->params['admin'] ?? [], Yii::app()->moduleManager->notifications('comment'));
    }
}
?>

<div class="home-hello">
    <p>
        <picture>
            <source srcset="/images/photo-150-150.webp" type="image/webp">
            <source srcset="/images/photo-150-150.jpg" type="image/jpeg">
            <img src="/images/photo-150-150.jpg" alt="Дмитрий Елисеев">
        </picture>
        Приветствую посетителей моего официального сайта. Мне есть о чём вам рассказать, а вам предоставляется
        возможность ознакомиться с техническими и философскими размышлениями ещё одного живого программиста.
        Жизнь не стоит на месте, и время от времени в ней появляется что-то новое и неизведанное.
        То, что предстоит осмыслить силами личного либо коллективного разума. Возможно, вы найдёте это здесь.
        В любом случае не останавливайтесь. Ищите новые задачи и присоединяйтесь к диалогу.
    </p>
</div>

<?= \app\modules\block\widgets\BlockWidget::widget(['id' => 'banner_index_top']) ?>

<h2 class="index">Новое в <a href="<?php echo $this->createUrl('/blog/default/index'); ?>">Блоге</a>:</h2>
<?php if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new Tags('blog')])) : ?>
    <?= \app\modules\blog\widgets\LastPostsWidget::widget(['tpl' => 'home', 'limit' => 10]) ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<div class="clear"></div>
<p class="nomargin"><a href="<?php echo $this->createUrl('/blog/default/index', ['page' => 2]); ?>">Остальные записи &rarr;</a>
</p>
