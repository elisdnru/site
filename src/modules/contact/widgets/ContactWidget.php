<?php

namespace app\modules\contact\widgets;

use app\components\module\DUrlRulesHelper;
use app\modules\contact\models\Contact;
use app\modules\contact\models\ContactForm;
use app\modules\main\components\widgets\DWidget;
use Yii;

DUrlRulesHelper::import('contact');

class ContactWidget extends DWidget
{
    public $tpl = 'default';
    public $scenario = '';

    public function run()
    {
        $form = new ContactForm($this->scenario);

        if (isset($_POST['ContactForm'])) {
            $form->attributes = $_POST['ContactForm'];
            if ($form->validate()) {
                $contact = new Contact();
                $contact->attributes = $_POST['ContactForm'];

                $contact->pagetitle = Yii::app()->controller->pageTitle;

                if ($contact->save()) {
                    Yii::app()->user->setFlash('contactForm', 'Ваше сообщение принято');
                    Yii::app()->controller->refresh();
                }
            }
        }

        $this->render('Contact/' . $this->tpl, [
            'model' => $form,
        ]);
    }
}
