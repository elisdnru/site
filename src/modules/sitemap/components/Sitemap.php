<?php

namespace app\modules\sitemap\components;

use DOMDocument;
use Yii;
use yii\db\ActiveRecord;

class Sitemap
{
    public const ALWAYS = 'always';
    public const HOURLY = 'hourly';
    public const DAILY = 'daily';
    public const WEEKLY = 'weekly';
    public const MONTHLY = 'monthly';
    public const YEARLY = 'yearly';
    public const NEVER = 'never';

    protected $items = [];

    /**
     * @param $url
     * @param string $changeFreq
     * @param float $priority
     * @param int $lastMod
     */
    public function addUrl($url, $changeFreq = self::DAILY, $priority = 0.5, $lastMod = 0): void
    {
        $host = Yii::$app->request->hostInfo;
        $item = [
            'loc' => $host . $url,
            'changefreq' => $changeFreq,
            'priority' => $priority
        ];
        if ($lastMod) {
            $item['lastmod'] = $this->dateToW3C($lastMod);
        }

        $this->items[] = $item;
    }

    /**
     * @param ActiveRecord[] $models
     * @param string $changeFreq
     * @param float $priority
     */
    public function addModels(array $models, $changeFreq = self::DAILY, $priority = 0.5): void
    {
        $host = Yii::$app->request->hostInfo;
        foreach ($models as $model) {
            $item = [
                'loc' => $host . $model->getUrl(),
                'changefreq' => $changeFreq,
                'priority' => $priority
            ];

            if ($model->hasAttribute('update_date')) {
                $item['lastmod'] = $this->dateToW3C($model->update_date);
            }

            $this->items[] = $item;
        }
    }

    public function render(): string
    {
        $dom = new DOMDocument('1.0', 'utf-8');
        $urlset = $dom->createElement('urlset');
        $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        foreach ($this->items as $item) {
            $url = $dom->createElement('url');

            foreach ($item as $key => $value) {
                $elem = $dom->createElement($key);
                $elem->appendChild($dom->createTextNode($value));
                $url->appendChild($elem);
            }

            $urlset->appendChild($url);
        }
        $dom->appendChild($urlset);

        return $dom->saveXML();
    }

    private function dateToW3C($date): string
    {
        if (is_int($date)) {
            return date(DATE_W3C, $date);
        }

        return date(DATE_W3C, strtotime($date));
    }
}
