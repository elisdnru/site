<?php if (Yii::app()->user->isGuest) : ?>
    <div id="uLogin" data-ulogin="display=<?php echo $display ?>;fields=<?php echo $fields ?>;providers=<?php echo $providers ?>;hidden=<?php echo $hidden ?>;redirect_uri=<?php echo urlencode($redirect) ?>"></div>

    <script>
    <?php ob_start() ?>

    (function() {
      var active = false;
      var widget = document.querySelector('#uLogin');
      window.addEventListener('scroll', function() {
        if (active || window.pageYOffset + window.innerHeight < widget.offsetTop - 200) {
          return;
        }
        var s = document.createElement('script');
        s.src = '//ulogin.ru/js/ulogin.js';
        s.async = true;
        document.querySelector('html').appendChild(s);
        active = true;
      });
    })();

    <?php Yii::app()->clientScript->registerScript(__FILE__ . __LINE__, ob_get_clean(), CClientScript::POS_END); ?>
    </script>

<?php else : ?>
    <?php
    $anchor = 'Выйти (' . Yii::app()->user->getName() . ')';
    echo CHtml::link(CHtml::encode($anchor), [$logout_url]);
    ?>
<?php endif ?>
