<?php

namespace app\modules\comment\widgets;

use app\assets\CommentsAsset;
use app\modules\comment\models\Comment;
use app\modules\comment\forms\CommentForm;
use app\modules\user\models\User;
use ReflectionClass;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Widget;
use yii\helpers\Json;
use yii\web\Cookie;

class CommentsWidget extends Widget
{
    public $material_id;
    public $authorId;
    public $type;
    public $url;
    public $user;
    public $tpl = 'comments';

    public function run(): string
    {
        if (!$this->user) {
            $this->user = User::findOne(Yii::$app->user->getId());
        }

        if (!$this->material_id) {
            throw new InvalidArgumentException('Empty material_id.');
        }

        if (!$this->type) {
            throw new InvalidArgumentException('Empty type of comments.');
        }

        $form = new CommentForm();

        if (!$this->user) {
            $form->scenario = 'anonim';
            $form->attributes = $this->loadFormState();
        }

        if ($form->load(Yii::$app->request->post())) {
            $this->saveFormState([
                'name' => $form->name,
                'email' => $form->email,
                'site' => $form->site,
            ]);

            if ($form->validate()) {
                $className = (new ReflectionClass($this->type))->getNamespaceName() . '\Comment';

                /** @var Comment $comment */
                $comment = new $className;
                $comment->attributes = $form->attributes;
                $comment->material_id = $this->material_id;
                $comment->public = 1;
                $comment->moder = 0;

                if ($this->user) {
                    $comment->user_id = $this->user->id;
                }

                if ($comment->save()) {
                    Yii::$app->session->setFlash('success', 'Ваш коментарий добавлен');
                    Yii::$app->controller->redirect($comment->getUrl());
                    Yii::$app->end();
                    return '';
                }
            }
        }

        $items = Comment::find()
            ->where(null)
            ->type($this->type)
            ->material($this->material_id)
            ->orderBy(['id' => SORT_ASC])
            ->all();

        $comments = [];

        foreach ($items as $item) {
            $comments[$item->parent_id ?? 0][] = $item;
        }

        CommentsAsset::register($this->view);

        return $this->render('Comments/' . $this->tpl, [
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
        /** @var Cookie $cookie */
        $cookie = Yii::createObject([
            'class' => Cookie::class,
            'name' => 'comment_form_data',
            'value' => Json::encode($attributes),
            'expire' => time() + 3600 * 24 * 180,
        ]);

        Yii::$app->response->cookies->add($cookie);
    }

    protected function loadFormState(): array
    {
        $cookie = Yii::$app->request->cookies['comment_form_data'];
        if (!empty($cookie)) {
            try {
                return Json::decode($cookie->value);
            } catch (InvalidArgumentException $e) {
                return [];
            }
        }
        return [];
    }
}
