function getCSRFToken(){ return '<?php echo Yii::app()->request->csrfToken; ?>'; }
function getVKApiId(){ return '<?php echo Yii::app()->config->get('SOCIALS.VK_APIID'); ?>'; }
function getFBApiId(){ return ''; }