<?php

declare(strict_types=1);

namespace app\components\purifier;

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

final class Purifier
{
    /**
     * @var string[]
     */
    private array $fragments = [];

    public function purify(string $content, array $options, bool $encodePreContent): string
    {
        $text = $content;

        if ($encodePreContent) {
            $text = $this->storePreContents($text);
        }

        $text = HtmlPurifier::process(trim($text), $options);

        if ($encodePreContent) {
            $text = $this->resumePreContents($text);
        }

        return $text;
    }

    private function storePreContents(string $text): string
    {
        return preg_replace_callback('|<pre([^>]*)>(.*)</pre>|ismU', function (array $matches): string {
            /** @var string[] $matches */
            return '<pre' . $matches[1] . '>' . $this->store($matches[2]) . '</pre>';
        }, $text);
    }

    private function resumePreContents(string $text): string
    {
        return preg_replace_callback('|<pre([^>]*)>(.*)</pre>|ismU', function (array $matches): string {
            /** @var string[] $matches */
            return '<pre' . $matches[1] . '>' . $this->resume($matches[2]) . '</pre>';
        }, $text);
    }

    private function store(string $content): string
    {
        do {
            $id = bin2hex(random_bytes(5));
        } while (\array_key_exists($id, $this->fragments));
        $this->fragments[$id] = $content;
        return $id;
    }

    private function resume(string $id): string
    {
        if (\array_key_exists($id, $this->fragments)) {
            $value = Html::encode($this->fragments[$id]);
            unset($this->fragments[$id]);
            return $value;
        }
        return '';
    }
}
