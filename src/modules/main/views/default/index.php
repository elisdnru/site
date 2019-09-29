<?php
/* @var $this Controller */

use app\components\module\UrlRulesHelper;
use app\extensions\cachetagging\Tags;
use app\modules\main\components\Controller;
use app\modules\user\models\Access;

$this->pageTitle = 'Дмитрий Елисеев: Разработка сайтов и интернет-сервисов';
$this->description = 'Дмитрий Елисеев – разработчик сайтов, web-приложений, магазинов и порталов. Автор блога по Yii Framework, статей по программированию, интернет-разработке и профессиональному самосовершенствованию.';

if ($this->is(Access::ROLE_CONTROL)) {
    if ($this->moduleAllowed('contact')) {
        $this->admin = array_merge($this->admin, Yii::app()->moduleManager->notifications('contact'));
    }
    if ($this->moduleAllowed('comment')) {
        $this->admin = array_merge($this->admin, Yii::app()->moduleManager->notifications('comment'));
    }
    $this->info = 'Стартовая страница';
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

<?php $this->widget(\app\modules\block\widgets\BlockWidget::class, ['id' => 'banner_index_top']); ?>

<?php UrlRulesHelper::import('blog'); ?>

<div class="index">Новое в <a href="<?php echo $this->createUrl('/blog/default/index'); ?>">Блоге</a>:</div>
<?php if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new Tags('blog')])) : ?>
    <?php $this->widget(\app\modules\blog\widgets\LastPostsWidget::class, ['tpl' => 'home', 'limit' => 10]); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<div class="clear"></div>
<p class="nomargin"><span data-href="<?php echo $this->createUrl('/blog/default/index', ['page' => 2]); ?>">Остальные записи &rarr;</span>
</p>
