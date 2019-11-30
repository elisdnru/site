<?php

namespace app\modules\contact\widgets;

use app\modules\contact\models\Contact;
use app\modules\contact\forms\ContactForm;
use Yii;
use yii\base\Widget;

class ContactWidget extends Widget
{
    public $scenario = '';

    public function run(): string
    {
        $form = new ContactForm($this->scenario);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $contact = new Contact();
            $contact->attributes = $form->attributes;

            $contact->pagetitle = Yii::$app->view->title;

            if ($contact->save()) {
                Yii::$app->session->setFlash('success', 'Ваше сообщение принято');
                Yii::$app->controller->refresh();
            }
        }

        return $this->render('Contact', [
            'model' => $form,
        ]);
    }
}
