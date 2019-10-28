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

        if ($post = Yii::$app->request->post('ContactForm')) {
            $form->attributes = $post;
            if ($form->validate()) {
                $contact = new Contact();
                $contact->attributes = $post;

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
