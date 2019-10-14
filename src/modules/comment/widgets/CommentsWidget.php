<?php

namespace app\modules\comment\widgets;

use CException;
use CHttpCookie;
use app\modules\comment\models\Comment;
use app\modules\comment\forms\CommentForm;
use app\components\widgets\Widget;
use app\modules\user\models\User;
use Yii;

class CommentsWidget extends Widget
{
    public $material_id;
    public $authorId;
    public $type;
    public $url;
    public $user;
    public $tpl = 'comments';

    public function run(): void
    {
        if (!$this->user) {
            $this->user = User::model()->findByPk(Yii::app()->user->getId());
        }

        if (!$this->material_id) {
            throw new CException('Not setted a Material_ID');
        }

        if (!$this->type) {
            throw new CException('Not setted a TYPE of comments');
        }

        $form = new CommentForm();

        if (!$this->user) {
            $form->scenario = 'anonim';
            $form->attributes = $this->loadFormState();
        }

        if (isset($_POST['CommentForm'])) {
            $form->attributes = $_POST['CommentForm'];

            $this->saveFormState([
                'name' => $form->name,
                'email' => $form->email,
                'site' => $form->site,
            ]);

            if ($form->validate()) {
                $className = (new \ReflectionClass($this->type))->getNamespaceName() . '\Comment';

                $comment = new $className;
                $comment->attributes = $form->attributes;
                $comment->material_id = $this->material_id;
                $comment->public = 1;
                $comment->moder = 0;

                if ($this->user) {
                    $comment->user_id = $this->user->id;
                }

                if ($comment->save()) {
                    Yii::app()->user->setFlash('success', 'Ваш коментарий добавлен');
                    Yii::app()->controller->refresh();
                }
            }
        }

        $items = Comment::model()
            ->type($this->type)
            ->material($this->material_id)
            ->with('user')
            ->findAll(['order' => 't.id ASC']);

        $comments = [];

        foreach ($items as $item) {
            $comments[$item->parent_id][] = $item;
        }

        Yii::app()->clientScript->registerPackage('comments');

        $this->render('Comments/' . $this->tpl, [
            'comments' => $comments,
            'form' => $form,
            'user' => $this->user,
            'material_id' => $this->material_id,
            'type' => $this->type,
            'authorId' => $this->authorId,
        ]);
    }

    protected function saveFormState($attributes): void
    {
        $cookie = new CHttpCookie('comment_form', serialize($attributes));
        $cookie->expire = time() + 3600 * 24 * 180;
        Yii::app()->request->cookies['comment_form'] = $cookie;
    }

    protected function loadFormState(): array
    {
        $cookie = Yii::app()->request->cookies['comment_form'];
        if ($cookie !== null) {
            return unserialize($cookie->value);
        }
        return [];
    }
}
