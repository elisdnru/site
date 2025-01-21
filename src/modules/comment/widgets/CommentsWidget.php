<?php

declare(strict_types=1);

namespace app\modules\comment\widgets;

use app\assets\CommentsAsset;
use app\modules\comment\forms\CommentForm;
use app\modules\comment\models\Comment;
use app\modules\user\models\User;
use BadMethodCallException;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Widget;
use yii\helpers\Json;
use yii\mail\MailerInterface;
use yii\web\Cookie;
use yii\web\Request;
use yii\web\Response;
use yii\web\Session;
use yii\web\User as WebUser;

final class CommentsWidget extends Widget
{
    public int $material_id = 0;
    public ?int $authorId = null;
    /**
     * @psalm-var class-string
     */
    public ?string $type = null;

    private WebUser $webUser;
    private MailerInterface $mailer;
    private Session $session;

    public function __construct(WebUser $webUser, MailerInterface $mailer, Session $session, array $config = [])
    {
        parent::__construct($config);
        $this->webUser = $webUser;
        $this->mailer = $mailer;
        $this->session = $session;
    }

    public function run(): string
    {
        if (!$this->material_id) {
            throw new InvalidArgumentException('Empty material_id.');
        }

        if (empty($this->type)) {
            throw new InvalidArgumentException('Empty type of comments.');
        }

        $request = Yii::$app->request;

        if (!$request instanceof Request) {
            throw new BadMethodCallException('Unable to use non-web request.');
        }

        $response = Yii::$app->response;

        if (!$response instanceof Response) {
            throw new BadMethodCallException('Unable to use non-web response.');
        }

        $form = new CommentForm();

        $user = User::findOne($this->webUser->id);

        if ($user === null) {
            $form->scenario = CommentForm::SCENARIO_ANONIM;
            $form->attributes = $this->loadFormState($request);
        }

        if ($form->load((array)Yii::$app->request->post()) && $form->validate()) {
            $this->saveFormState([
                'name' => $form->name,
                'email' => $form->email,
                'site' => $form->site,
            ], $response);

            $comment = new Comment();
            $comment->type = $this->type;
            $comment->material_id = $this->material_id;
            $comment->public = 1;
            $comment->moder = 0;
            $comment->parent_id = $form->parent_id ? (int)$form->parent_id : null;

            $comment->text = $form->text;

            if ($user !== null) {
                $comment->user_id = $user->id;
                $comment->email = $user->email;
                $comment->name = trim($user->firstname . ' ' . $user->lastname);
                $comment->site = $user->site;
            } else {
                $comment->name = $form->name;
                $comment->email = (string)$form->email;
                $comment->site = $form->site;
            }

            $comment->save();
            $comment->sendNotifications($this->mailer);

            $this->session->setFlash('success', 'Ваш комментарий добавлен');
            Yii::$app->controller->redirect($comment->getUrl());
            Yii::$app->end();

            return '';
        }

        $items = Comment::find()
            ->where([])
            ->type($this->type)
            ->material($this->material_id)
            ->orderBy(['id' => SORT_ASC])
            ->all();

        $comments = [];

        foreach ($items as $item) {
            $comments[(int)$item->parent_id][] = $item;
        }

        CommentsAsset::register($this->view);

        return $this->render('Comments/comments', [
            'comments' => $comments,
            'form' => $form,
            'user' => $user,
            'material_id' => $this->material_id,
            'type' => $this->type,
            'authorId' => $this->authorId,
            'session' => $this->session,
        ]);
    }

    private function saveFormState(array $attributes, Response $response): void
    {
        try {
            $data = Json::encode($attributes);
        } catch (InvalidArgumentException) {
            $data = null;
        }

        /** @var Cookie $cookie */
        $cookie = Yii::createObject([
            'class' => Cookie::class,
            'name' => 'comment_form_data',
            'value' => $data,
            'expire' => time() + 3600 * 24 * 180,
        ]);

        $response->cookies->add($cookie);
    }

    private function loadFormState(Request $request): array
    {
        $value = (string)$request->cookies->getValue('comment_form_data');
        try {
            return (array)Json::decode($value);
        } catch (InvalidArgumentException) {
            return [];
        }
    }
}
