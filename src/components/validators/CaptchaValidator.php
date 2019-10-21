<?php

namespace app\components\validators;

use CCaptchaAction;
use CException;
use CJSON;
use Yii;
use yii\validators\Validator;

class CaptchaValidator extends Validator
{
    public $caseSensitive = false;
    public $captchaAction = 'captcha';
    public $allowEmpty = false;

    public function validateAttribute($object, $attribute): void
    {
        $value = $object->$attribute;
        if ($this->allowEmpty && $this->isEmpty($value))
            return;
        $captcha = $this->getCaptchaAction();
        if (is_array($value) || !$captcha->validate($value, $this->caseSensitive)) {
            $message = $this->message !== null ? $this->message : Yii::t('yii', 'The verification code is incorrect.');
            $this->addError($object, $attribute, $message);
        }
    }

    protected function getCaptchaAction(): CCaptchaAction
    {
        if (($captcha = Yii::app()->getController()->createAction($this->captchaAction)) === null) {
            if (strpos($this->captchaAction, '/') !== false) // contains controller or module
            {
                if (($ca = Yii::app()->createController($this->captchaAction)) !== null) {
                    list($controller, $actionID) = $ca;
                    $captcha = $controller->createAction($actionID);
                }
            }
            if ($captcha === null)
                throw new CException(Yii::t('yii', 'CCaptchaValidator.action "{id}" is invalid. Unable to find such an action in the current controller.',
                    array('{id}' => $this->captchaAction)));
        }
        return $captcha;
    }

    public function clientValidateAttribute($model, $attribute, $view): string
    {
        $captcha = $this->getCaptchaAction();
        $message = $this->message !== null ? $this->message : Yii::t('yii', 'The verification code is incorrect.');
        $message = strtr($message, array(
            '{attribute}' => $model->getAttributeLabel($attribute),
        ));
        $code = $captcha->getVerifyCode(false);
        $hash = $captcha->generateValidationHash($this->caseSensitive ? $code : strtolower($code));
        $js = "
var hash = jQuery('body').data('{$this->captchaAction}.hash');
if (hash == null)
	hash = $hash;
else
	hash = hash[" . ($this->caseSensitive ? 0 : 1) . "];
for(var i=value.length-1, h=0; i >= 0; --i) h+=value." . ($this->caseSensitive ? '' : 'toLowerCase().') . "charCodeAt(i);
if(h != hash) {
	messages.push(" . CJSON::encode($message) . ");
}
";

        if ($this->allowEmpty) {
            $js = "
if(jQuery.trim(value)!='') {
	$js
}
";
        }

        return $js;
    }
}

