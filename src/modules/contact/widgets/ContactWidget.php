<?php

namespace app\modules\contact\widgets;

use app\modules\contact\models\Contact;
use app\modules\contact\forms\ContactForm;
use Yii;
use yii\base\Widget;

class ContactWidget extends Widget
{
    public $tpl = 'default';
    public $scenario = '';

    public function run(): string
    {
        $form = new ContactForm($this->scenario);

        if (isset($_POST['ContactForm'])) {
            $form->attributes = $_POST['ContactForm'];
            if ($form->validate()) {
                $contact = new Contact();
                $contact->attributes = $_POST['ContactForm'];

                $contact->pagetitle = Yii::app()->controller->title;

                if ($contact->save()) {
                    Yii::app()->user->setFlash('success', 'Ваше сообщение принято');
                    Yii::app()->controller->refresh();
                }
            }
        }

        return $this->render('Contact/' . $this->tpl, [
            'model' => $form,
        ]);
    }
}
