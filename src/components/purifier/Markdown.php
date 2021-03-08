<?php

declare(strict_types=1);

namespace app\components\purifier;

use app\extensions\markdown\MarkdownParser;

class Markdown
{
    public function transform(string $source): string
    {
        $pre = preg_replace('#(~~~[\r\n]+\[php][\r\n]+)#', '$1<?php' . PHP_EOL, $source);

        $md = new MarkdownParser();
        $transform = (string)$md->transform($pre);

        return str_replace('<pre><span class="php-hl-inlinetags">&lt;?php</span>' . PHP_EOL, '<pre>', $transform);
    }
}
