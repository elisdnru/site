<?php

Yii::import('application.modules.contact.models.*');
DUrlRulesHelper::import('contact');

class ContactWidget extends DWidget
{
    public $tpl = 'default';
    public $scenario = '';

	public function run()
	{
        $form = new ContactForm($this->scenario);

        if(isset($_POST['ContactForm']))
        {
            $form->attributes = $_POST['ContactForm'];
            if($form->validate())
            {
                $contact = new Contact();
                $contact->attributes = $_POST['ContactForm'];

                $contact->pagetitle = Yii::app()->controller->pageTitle;

                if ($contact->save()){

                    $contact->sendEmail();

                    Yii::app()->user->setFlash('contactForm','Ваше сообщение принято');
                    Yii::app()->controller->refresh();
                }
            }
        }

		$this->render('Contact/'.$this->tpl ,array(
            'model'=>$form,
        ));
	}

}