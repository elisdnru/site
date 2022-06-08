<?php

declare(strict_types=1);

namespace app\modules\blog\controllers\admin;

use app\components\AdminController;
use app\modules\blog\forms\admin\PostForm;
use app\modules\blog\forms\admin\PostSearch;
use app\modules\blog\models\Group;
use app\modules\blog\models\Post;
use app\modules\blog\models\Tag;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\web\User;

final class PostController extends AdminController
{
    public function actionIndex(Request $request): string
    {
        $model = new PostSearch();
        $dataProvider = $model->search($request->queryParams);

        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate(Request $request, User $user): Response|string
    {
        $model = new PostForm();
        $model->date = date('Y-m-d H:i:s');

        if ($model->load((array)$request->post())) {
            $model->image = UploadedFile::getInstance($model, 'image');
            if ($model->validate()) {
                $post = new Post();
                $post->author_id = (int)$user->id;
                $this->savePost($post, $model);
                return $this->redirect(['view', 'id' => $post->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate(int $id, Request $request): Response|string
    {
        $post = $this->loadModel($id);

        $model = new PostForm($post);

        if ($model->load((array)$request->post())) {
            $model->image = UploadedFile::getInstance($model, 'image');
            if ($model->validate()) {
                $this->savePost($post, $model);
                return $this->redirect(['view', 'id' => $post->id]);
            }
        }

        return $this->render('update', [
            'post' => $post,
            'model' => $model,
        ]);
    }

    public function actionDelete(int $id, Request $request): ?Response
    {
        $model = $this->loadModel($id);
        $model->delete();

        if (!$request->getIsAjax()) {
            return $this->redirect(['index']);
        }
        return null;
    }

    public function actionView(int $id): Response
    {
        $model = $this->loadModel($id);

        return $this->redirect(['/blog/post/show', 'id' => $model->id, 'slug' => $model->slug]);
    }

    private function loadModel(int $id): Post
    {
        $model = Post::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $model;
    }

    private function savePost(Post $post, PostForm $model): void
    {
        $post->date = $model->date;
        $post->category_id = (int)$model->category_id;
        $post->slug = $model->slug;
        $post->title = $model->title;
        $post->meta_title = $model->meta_title;
        $post->meta_description = $model->meta_description;
        $post->styles = $model->styles;
        $post->short = $model->short;
        $post->text = $model->text;
        $post->image_alt = $model->image_alt;
        $post->image_show = (bool)$model->image_show;
        $post->public = (bool)$model->public;
        $post->promoted = (bool)$model->promoted;

        if ($model->image !== null) {
            $post->image = $model->image;
        }

        if ($model->del_image) {
            $post->del_image = true;
        }

        if ($model->new_group) {
            $group = new Group();
            $group->title = $model->new_group;
            $group->save();
            $post->group_id = $group->id;
        } else {
            $post->group_id = $model->group_id ? (int)$model->group_id : null;
        }

        $post->save();

        $post->assignTags(
            array_map(
                static function (string $title): Tag {
                    $tag = Tag::findOne(['title' => $title]);
                    if (!$tag) {
                        $tag = new Tag();
                        $tag->title = $title;
                        $tag->save();
                    }
                    return $tag;
                },
                $model->getTagsArray()
            )
        );
    }
}
