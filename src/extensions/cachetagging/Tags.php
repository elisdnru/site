<?php

namespace app\extensions\cachetagging;

use ICacheDependency;
use Yii;

class Tags implements ICacheDependency
{
    protected $timestamp;
    protected $tags;

    /**
     * В качестве параметров передается список тегов
     *
     * @params tag1, tag2, ..., tagN
     */
    public function __construct()
    {
        $this->tags = func_get_args();
    }

    /**
     * Evaluates the dependency by generating and saving the data related with dependency.
     * This method is invoked by cache before writing data into it.
     */
    public function evaluateDependency(): void
    {
        $this->timestamp = time();
    }

    /**
     * @return boolean whether the dependency has changed.
     */
    public function getHasChanged(): bool
    {
        $tags = array_map(static function ($i) {
            return TaggingBehavior::PREFIX . $i;
        }, $this->tags);
        $values = Yii::app()->cache->mget($tags);

        foreach ($values as $value) {
            if ((integer)$value > $this->timestamp) {
                return true;
            }
        }

        return false;
    }
}
