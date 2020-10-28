<?php

namespace app\modules\sitemap\components;

use DateTimeImmutable;
use DOMDocument;

class Sitemap
{
    /**
     * @var array[]
     */
    protected array $items = [];

    public function addLoc(string $loc, string $changeFreq, float $priority, ?DateTimeImmutable $lastMod): void
    {
        $item = [
            'loc' => $loc,
            'changefreq' => $changeFreq,
            'priority' => $priority
        ];

        if ($lastMod) {
            $item['lastmod'] = $lastMod->format(DATE_W3C);
        }

        $this->items[] = $item;
    }

    public function render(): string
    {
        $dom = new DOMDocument('1.0', 'utf-8');
        $urlset = $dom->createElement('urlset');
        $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        foreach ($this->items as $item) {
            $url = $dom->createElement('url');

            /**
             * @var string $key
             * @var string $value
             */
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
}
