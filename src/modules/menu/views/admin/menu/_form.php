<?php
/** @var $this View */

use app\modules\menu\models\Menu;
use app\modules\page\models\Page;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/** @var $model Menu */
/** @var $form CActiveForm */
?>

<div class="form">

    <form action="?" method="post">

        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>

        <p class="note">Поля, помеченные звёздочкой <span class="required">*</span> обязательны для заполнения.</p>

        <?= Html::errorSummary($model, ['class' => 'errorSummary']) ?>

        <div class="row buttons">
            <?= Html::submitButton('Сохранить') ?>
        </div>

        <fieldset>
            <div class="row<?= $model->hasErrors('title') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'title') ?><br />
                <?= Html::activeTextInput($model, 'title', ['size' => 60, 'maxlength' => 255]) ?><br />
                <?= Html::error($model, 'title', ['class' => 'errorMessage']) ?>
            </div>

            <div class="row<?= $model->hasErrors('parent_id') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'parent_id') ?><br />
                <?= Html::activeDropDownList($model, 'parent_id', [0 => ''] + ($model->parent_id ? array_diff_key(Menu::find()->getTabList(), Menu::find()->getAssocList($model->id)) : Menu::find()->getTabList())) ?><br />
                <?= Html::error($model, 'parent_id', ['class' => 'errorMessage']) ?>
            </div>

            <div class="row<?= $model->hasErrors('sort') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'sort') ?><br />
                <?= Html::activeTextInput($model, 'sort', ['size' => 60, 'maxlength' => 255]) ?><br />
                <?= Html::error($model, 'sort', ['class' => 'errorMessage']) ?>
            </div>

            <div class="row<?= $model->hasErrors('visible') ? ' error' : '' ?>">
                <?= Html::activeCheckbox($model, 'visible') ?><br />
                <?= Html::error($model, 'visible', ['class' => 'errorMessage']) ?>
            </div>
        </fieldset>

        <fieldset>
            <div class="row<?= $model->hasErrors('link') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'link') ?><br />
                <?= Html::activeTextInput($model, 'link', ['size' => 60, 'maxlength' => 255, 'class' => 'm_urlfield']) ?><br />
                <?= Html::error($model, 'link', ['class' => 'errorMessage']) ?>
            </div>
            <hr />
            <div class="row">
                <label>Ссылка на страницу</label><br />
                <?= Html::dropDownList('sss', '/' . $model->link, Page::model()->getUrlList(), ['prompt' => '', 'class' => 'm_selector']) ?>
                <br />
            </div>
        </fieldset>

        <fieldset>
            <div class="row<?= $model->hasErrors('alias') ? ' error' : '' ?>">
                <?= Html::activeLabel($model, 'alias') ?><br />
                <?= Html::activeTextInput($model, 'alias', ['size' => 60, 'maxlength' => 255]) ?><br />
                <?= Html::error($model, 'alias', ['class' => 'errorMessage']) ?>
            </div>
        </fieldset>

        <div class="row buttons">
            <?= Html::submitButton('Сохранить') ?>
        </div>

    </form>

    <script>
    <?php ob_start() ?>

    (function(){
      var url_field = document.querySelector('.m_urlfield');
      if (!url_field.value) {
        url_field.value = '#';
      }
      var selector = document.querySelector('.m_selector');
      selector.addEventListener('change', function (e) {
        var val = e.target.value;
        if (val === '') {
          url_field.value = '#';
        } else {
          url_field.value = e.target.value;
        }
        selector.value = '';
        e.target.value = val;
      })
    })();

    <?php $this->registerJs(ob_get_clean(), View::POS_END); ?>
    </script>

</div><!-- form -->
