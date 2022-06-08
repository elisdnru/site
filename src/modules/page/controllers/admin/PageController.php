<?php

declare(strict_types=1);

namespace app\modules\page\controllers\admin;

use app\components\AdminController;
use app\components\category\TreeActiveDataProvider;
use app\components\DataProvider;
use app\modules\page\forms\admin\PageForm;
use app\modules\page\models\Page;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

final class PageController extends AdminController
{
    public function actionIndex(): string
    {
        $dataProvider = new DataProvider(new TreeActiveDataProvider([
            'childrenRelation' => 'children',
            'query' => Page::find(),
            'sort' => [
                'defaultOrder' => ['title' => SORT_ASC],
            ],
            'pagination' => false,
        ]));

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate(Request $request): Response|string
    {
        /** @var string|null $parent */
        $parent = $request->get('parent');

        $model = new PageForm();
        $model->parent_id = $parent ? (int)$parent : null;

        if ($model->load((array)$request->post()) && $model->validate()) {
            $page = new Page();
            $this->fillPage($page, $model);
            if ($page->save()) {
                return $this->redirect(['update', 'id' => $page->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate(int $id, Request $request): Response|string
    {
        $page = $this->loadModel($id);
        $model = new PageForm($page);

        if ($model->load((array)$request->post()) && $model->validate()) {
            $this->fillPage($page, $model);
            if ($page->save()) {
                return $this->redirect(['update', 'id' => $page->id]);
            }
        }

        return $this->render('update', [
            'page' => $page,
            'model' => $model,
        ]);
    }

    public function actionDelete(int $id, Request $request): ?Response
    {
        $page = $this->loadModel($id);
        $page->delete();

        if (!$request->getIsAjax()) {
            return $this->redirect(['index']);
        }
        return null;
    }

    public function actionView(int $id): Response
    {
        $page = $this->loadModel($id);

        return $this->redirect(['/page/page/show', 'path' => $page->getPath()]);
    }

    private function loadModel(int $id): Page
    {
        $model = Page::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException();
        }
        return $model;
    }

    private function fillPage(Page $page, PageForm $model): void
    {
        $page->slug = $model->slug;
        $page->title = $model->title;
        $page->hidetitle = (bool)$model->hidetitle;
        $page->meta_title = $model->meta_title;
        $page->meta_description = $model->meta_description;
        $page->robots = $model->robots;
        $page->styles = $model->styles;
        $page->text = $model->text;
        $page->layout = $model->layout;
        $page->subpages_layout = $model->subpages_layout;
        $page->parent_id = $model->parent_id ? (int)$model->parent_id : null;
        $page->system = (bool)$model->system;
    }
}
