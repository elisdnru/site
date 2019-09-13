<?php

use app\components\module\DUrlRulesHelper;

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
