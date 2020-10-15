<?php

declare(strict_types=1);

namespace app\components\module\sitemap;

interface SitemapProvider
{
    /**
     * @return Group[]
     */
    public static function sitemap(): array;
}
