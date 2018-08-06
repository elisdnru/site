<?php
$this->pageTitle = 'Авторизация';
$this->breadcrumbs = [
    'Вход на сайт'
];
?>

    <h1>Вход в аккаунт</h1>

<?php $this->beginWidget('DPortlet', ['title' => 'Войти, используя логин и пароль']); ?>

    <div class="form">
        <?php $form = $this->beginWidget('CActiveForm', [
            'id' => 'login-form',
            'enableClientValidation' => true,
            'clientOptions' => [
                'validateOnSubmit' => true,
            ],
        ]); ?>

        <div class="row">
            <?php echo $form->labelEx($model, 'username'); ?><br/>
            <?php echo $form->textField($model, 'username', ['size' => 30]); ?><br/>
            <?php echo $form->error($model, 'username'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'password'); ?><br/>
            <?php echo $form->passwordField($model, 'password', ['size' => 30]); ?><br/>
            <?php echo $form->error($model, 'password'); ?>
        </div>
        <div class="row rememberMe">
            <?php echo $form->checkBox($model, 'rememberMe'); ?>
            <?php echo $form->label($model, 'rememberMe'); ?>
            <?php echo $form->error($model, 'rememberMe'); ?>
        </div>

        <div class="row buttons">
            <?php echo CHtml::submitButton('Вход в учётную запись'); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div><!-- form -->

<?php $this->endWidget(); ?>

<?php $this->beginWidget('DPortlet', ['title' => 'Регистрация и восстановление']); ?>
    <p style="margin:0;"><a href="<?php echo $this->createUrl('/user/default/registration'); ?>">Регистрация</a> |
        <a href="<?php echo $this->createUrl('/user/default/remind'); ?>">Забыли пароль?</a></p>
<?php $this->endWidget(); ?>

<?php $this->beginWidget('DPortlet', ['title' => 'Вход через аккаунт в соцсети']); ?>
<?php $this->widget('ulogin.widgets.UloginWidget', [
    'params' => ['redirect' => Yii::app()->createAbsoluteUrl('/ulogin/default/login', ['return' => ltrim(Yii::app()->getRequest()->getOriginalRequestUri(), '/')])]
]); ?>

<?php $this->endWidget(); ?>