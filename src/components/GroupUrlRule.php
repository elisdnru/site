<?php

declare(strict_types=1);

namespace app\components;

use CBaseUrlRule;
use Yii;

class GroupUrlRule extends CBaseUrlRule
{
    public $prefix = '';
    public $routePrefix = '';
    /**
     * @var CBaseUrlRule[]
     */
    public $rules = [];

    public function createUrl($manager, $route, $params, $ampersand)
    {
        $routePrefix = $this->getRoutePrefix();

        if (strpos($route . '/', $routePrefix . '/') !== 0) {
            return false;
        }

        $subRoute = mb_substr($route, mb_strlen($routePrefix) + 1);

        foreach ($this->rules as $i => $rule) {
            if (is_array($rule)) {
                $this->rules[$i] = $rule = Yii::createComponent($rule);
            } elseif (is_string($rule)) {
                $this->rules[$i] = $rule = new $manager->urlRuleClass($rule, $i);
            }
            if (($url = $rule->createUrl($manager, $subRoute, $params, $ampersand)) !== false) {
                return $routePrefix . ($url ? '/' . $url : '');
            }
        }

        return false;
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {
        if (strpos($pathInfo . '/', $this->prefix . '/') !== 0) {
            return false;
        }

        $subPathInfo = mb_substr($pathInfo, mb_strlen($this->prefix) + 1);
        $subRawPathInfo = mb_substr($rawPathInfo, mb_strlen($this->prefix) + 1);

        foreach ($this->rules as $i => $rule) {
            if (is_array($rule)) {
                $this->rules[$i] = $rule = Yii::createComponent($rule);
            } elseif (is_string($rule)) {
                $this->rules[$i] = $rule = new $manager->urlRuleClass($rule, $i);
            }
            $route = $rule->parseUrl($manager, $request, $subPathInfo, $subRawPathInfo);
            if ($route !== false) {
                return $this->getRoutePrefix() . '/' . $route;
            }
        }

        return false;
    }

    private function getRoutePrefix(): string
    {
        return $this->routePrefix ?: $this->prefix;
    }
}
