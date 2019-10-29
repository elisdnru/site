<?php

namespace app\components\behaviors;

use CHtml;
use CHtmlPurifier;
use CMarkdownParser;
use yii\base\Behavior;
use yii\base\Component;
use yii\db\ActiveRecord;

class PurifyTextBehavior extends Behavior
{
    /**
     * @var string source attribute name
     */
    public $sourceAttribute = 'text';

    /**
     * @var string destination attribute name for result
     */
    public $destinationAttribute = 'purified_text';

    /**
     * @var bool use or not use the Markdown parser
     */
    public $enableMarkdown = false;

    /**
     * @var bool use CHtml::encode instead of HTML Purifier for <pre> and <code> contents
     */
    public $encodePreContent = false;

    /**
     * @var bool use or not use HTML Purifier
     */
    public $enablePurifier = true;

    /**
     * @var array options for the HTML Purifier
     */
    public $purifierOptions = [];

    /**
     * @var bool
     */
    public $processOnBeforeSave = true;

    /**
     * @var bool allow process if destination attribute is empty
     */
    public $processOnAfterFind = true;

    /**
     * @var bool save or don't save result to DB
     */
    public $updateOnAfterFind = true;

    private $contentHash = '';

    public function events(): array
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
        ];
    }

    public function beforeSave(): void
    {
        $model = $this->getModel();

        if (!$this->processOnBeforeSave) {
            return;
        }

        if ($this->sourceAttribute &&
            $this->destinationAttribute &&
            $this->calculateHash($model->{$this->sourceAttribute}) !== $this->contentHash
        ) {
            $model->{$this->destinationAttribute} = $this->processContent($model->{$this->sourceAttribute});
        }
    }

    public function afterFind(): void
    {
        $model = $this->getModel();

        if (!$this->processOnAfterFind) {
            return;
        }

        $this->contentHash = $this->calculateHash($model->{$this->sourceAttribute});

        if ($this->sourceAttribute &&
            $this->destinationAttribute &&
            $model->{$this->sourceAttribute} &&
            !$model->{$this->destinationAttribute}
        ) {
            $model->{$this->destinationAttribute} = $this->processContent($model->{$this->sourceAttribute});
            if ($this->updateOnAfterFind) {
                $this->updateModel();
            }
        }
    }

    private function processContent(?string $text): string
    {
        if ($this->enableMarkdown) {
            $text = $this->markdownText($text);
        }

        if ($this->enablePurifier) {
            $text = $this->purifyText($text);
        }

        return $text;
    }

    public function markdownText(?string $text): string
    {
        $pre = preg_replace('#(~~~[\r\n]+\[php\][\r\n]+)#', '$1<?php' . PHP_EOL, $text);

        $md = new CMarkdownParser;
        $transform = $md->transform($pre);

        return str_replace('<pre><span class="php-hl-inlinetags">&lt;?php</span>' . PHP_EOL, '<pre>', $transform);
    }

    public function purifyText(?string $text): string
    {
        $p = new CHtmlPurifier;
        $p->setOptions($this->purifierOptions);

        if ($this->encodePreContent) {
            $text = preg_replace_callback('|<pre([^>]*)>(.*)</pre>|ismU', [$this, 'storePreContent'], $text);
            $text = preg_replace_callback('|<code([^>]*)>(.*)</code>|ismU', [$this, 'storeCodeContent'], $text);
        }

        $text = $p->purify(trim($text));

        if ($this->encodePreContent) {
            $text = preg_replace_callback('|<pre([^>]*)>(.*)</pre>|ismU', [$this, 'resumePreContent'], $text);
            $text = preg_replace_callback('|<code([^>]*)>(.*)</code>|ismU', [$this, 'resumeCodeContent'], $text);
        }

        return $text;
    }

    private function updateModel(): void
    {
        $model = $this->getModel();
        $model->updateAttributes([
            $this->destinationAttribute => $model->{$this->destinationAttribute}
        ]);
    }

    private $preContents = [];

    /**
     * @return ActiveRecord|Component
     */
    private function getModel(): ActiveRecord
    {
        return $this->owner;
    }

    private function storePreContent(array $matches): string
    {
        return '<pre' . $matches[1] . '>' . $this->storeContent($matches[2]) . '</pre>';
    }

    private function resumePreContent(array $matches): string
    {
        return '<pre' . $matches[1] . '>' . $this->resumeContent($matches[2]) . '</pre>';
    }

    private function storeCodeContent(array $matches): string
    {
        return '<code' . $matches[1] . '>' . $this->storeContent($matches[2]) . '</code>';
    }

    private function resumeCodeContent(array $matches): string
    {
        return '<code' . $matches[1] . '>' . $this->resumeContent($matches[2]) . '</code>';
    }

    private function storeContent(?string $content): string
    {
        do {
            $id = md5(random_int(0, 100000));
        } while (isset($this->preContents[$id]));
        $this->preContents[$id] = $content;
        return $id;
    }

    private function resumeContent(string $id): string
    {
        return isset($this->preContents[$id]) ? CHtml::encode($this->preContents[$id]) : '';
    }

    private function calculateHash(?string $content): string
    {
        return md5($content);
    }
}
