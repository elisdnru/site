<?php

namespace app\components;

use CController;
use Yii;
use yii\base\Action;
use yii\web\View;

class Controller extends CController
{
    protected function beforeAction($action): bool
    {
        Yii::$app->controller = new \yii\web\Controller($this->id, Yii::$app->getModule($this->module->id));
        Yii::$app->controller->action = new Action($this->action->id, Yii::$app->controller);
        return parent::beforeAction($action);
    }

    public function refresh($terminate = true, $anchor = ''): void
    {
        $this->redirect(Yii::$app->request->getUrl() . $anchor, $terminate);
    }

    public function redirectOrAjax($route = ['index']): void
    {
        if (!Yii::$app->request->getIsAjax()) {
            $this->redirect(Yii::$app->request->post('returnUrl', $route));
        }
    }

    public function checkUrl($url): void
    {
        if ('/' . Yii::$app->request->getPathInfo() !== $url) {
            $this->redirect($url, true, 301);
        }
    }

    public function reflash(): void
    {
        foreach (['notice', 'success', 'error'] as $type) {
            if (Yii::$app->session->hasFlash($type)) {
                Yii::$app->session->setFlash($type, Yii::$app->session->getFlash($type));
            }
        }
    }

    public function render($view, $data = null, $return = false): string
    {
        Yii::$app->controller->layout = $this->layout;
        Yii::$app->getView()->context = $this;
        $content = Yii::$app->getView()->render($view, (array)$data, Yii::$app->controller);
        echo $this->renderContent($content);
        return '';
    }

    private function renderContent($content)
    {
        $layoutFile = $this->findLayoutFile(Yii::$app->getView());
        if ($layoutFile !== false) {
            return Yii::$app->getView()->renderFile($layoutFile, ['content' => $content], Yii::$app->controller);
        }

        return $content;
    }

    private function findLayoutFile(View $view)
    {
        $controller = Yii::$app->controller;

        $module = $controller->module;
        if (is_string($controller->layout)) {
            $layout = $controller->layout;
        } elseif ($controller->layout === null) {
            while ($module !== null && $module->layout === null) {
                $module = $module->module;
            }
            if ($module !== null && is_string($module->layout)) {
                $layout = $module->layout;
            }
        }

        if (!isset($layout)) {
            return false;
        }

        if (strncmp($layout, '@', 1) === 0) {
            $file = Yii::getAlias($layout);
        } elseif (strncmp($layout, '/', 1) === 0) {
            $file = Yii::$app->getLayoutPath() . DIRECTORY_SEPARATOR . substr($layout, 1);
        } else {
            $file = $module->getLayoutPath() . DIRECTORY_SEPARATOR . $layout;
        }

        if (pathinfo($file, PATHINFO_EXTENSION) !== '') {
            return $file;
        }
        $path = $file . '.' . $view->defaultExtension;
        if ($view->defaultExtension !== 'php' && !is_file($path)) {
            $path = $file . '.php';
        }

        return $path;
    }
}
