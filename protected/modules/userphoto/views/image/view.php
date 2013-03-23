<?php $this->reflash() ?>

<?php $user = $this->getUser(); ?>

<?php $this->redirect($user ? $user->url : '/') ; ?>
