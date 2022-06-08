<?php

declare(strict_types=1);

namespace app\modules\portfolio\controllers\admin;

use app\components\AdminController;
use app\modules\portfolio\forms\admin\WorkForm;
use app\modules\portfolio\models\Work;
use yii\data\Pagination;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;
use yii\web\UploadedFile;

final class WorkController extends AdminController
{
    private const ITEMS_PER_PAGE = 50;

    public function actionIndex(Request $request): string
    {
        $category = (int)$request->get('category');

        $query = Work::find();

        if ($category) {
            $query->category($category);
        }

        $pages = new Pagination([
            'totalCount' => (clone $query)->count(),
            'pageSize' => self::ITEMS_PER_PAGE,
        ]);

        $works = $query
            ->limit($pages->getLimit())
            ->offset($pages->getOffset())
            ->orderBy(['sort' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'works' => $works,
            'category' => $category,
            'pages' => $pages,
        ]);
    }

    public function actionCreate(Request $request): Response|string
    {
        /** @var string|null $category */
        $category = $request->get('category');

        $model = new WorkForm();
        $model->public = 1;
        $model->image_show = 1;
        $model->category_id = $category ? (int)$category : null;
        $model->date = date('Y-m-d H:i:s');
        $model->sort = (int)Work::find()->max('sort') + 1;

        if ($model->load((array)$request->post())) {
            $model->image = UploadedFile::getInstance($model, 'image');
            if ($model->validate()) {
                $work = new Work();
                $this->saveWork($work, $model);
                return $this->redirect(['view', 'id' => $work->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate(int $id, Request $request): Response|string
    {
        $work = $this->loadModel($id);
        $model = new WorkForm($work);

        if ($model->load((array)$request->post())) {
            $model->image = UploadedFile::getInstance($model, 'image');
            if ($model->validate()) {
                $this->saveWork($work, $model);
                return $this->redirect(['view', 'id' => $work->id]);
            }
        }

        return $this->render('update', [
            'work' => $work,
            'model' => $model,
        ]);
    }

    public function actionToggle(int $id, string $attribute, Request $request): ?Response
    {
        $work = $this->loadModel($id);

        if ($attribute !== 'public') {
            throw new BadRequestHttpException('Missing attribute ' . $attribute);
        }

        $work->{$attribute} = $work->{$attribute} ? '0' : '1';
        $work->save();

        if (!$request->getIsAjax()) {
            return $this->redirect($request->getReferrer() ?: ['index']);
        }
        return null;
    }

    public function actionDelete(int $id, Request $request): ?Response
    {
        $work = $this->loadModel($id);
        $work->delete();

        if (!$request->getIsAjax()) {
            return $this->redirect(['index']);
        }
        return null;
    }

    public function actionView(int $id): Response
    {
        $work = $this->loadModel($id);

        return $this->redirect([
            '/portfolio/work/show',
            'category' => $work->category->getPath(),
            'id' => $work->id,
            'slug' => $work->slug,
        ]);
    }

    private function loadModel(int $id): Work
    {
        $model = Work::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $model;
    }

    private function saveWork(Work $work, WorkForm $model): void
    {
        $work->sort = (int)$model->sort;
        $work->date = $model->date;
        $work->category_id = (int)$model->category_id;
        $work->slug = $model->slug;
        $work->title = $model->title;
        $work->meta_title = $model->meta_title;
        $work->meta_description = $model->meta_description;
        $work->short = $model->short;
        $work->text = $model->text;
        $work->image_show = (bool)$model->image_show;
        $work->public = (bool)$model->public;

        if ($model->image !== null) {
            $work->image = $model->image;
        }

        if ($model->del_image) {
            $work->del_image = true;
        }

        $work->save();
    }
}
