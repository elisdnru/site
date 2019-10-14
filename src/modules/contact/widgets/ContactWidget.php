<?php

namespace app\modules\contact\widgets;

use app\modules\contact\models\Contact;
use app\modules\contact\forms\ContactForm;
use app\components\widgets\Widget;
use Yii;

class ContactWidget extends Widget
{
    public $tpl = 'default';
    public $scenario = '';

    public function run(): void
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
