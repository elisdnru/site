<?php

namespace app\components\purifier;

use BadMethodCallException;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class PurifyTextBehavior extends Behavior
{
    public string $sourceAttribute = 'text';
    public string $destinationAttribute = 'purified_text';
    public bool $enableMarkdown = false;
    public bool $encodePreContent = false;
    public bool $enablePurifier = true;
    public array $purifierOptions = [];
    public bool $processOnBeforeSave = true;
    public bool $processOnAfterFind = true;
    public bool $updateOnAfterFind = true;

    private Markdown $markdown;
    private Purifier $purifier;
    private string $contentHash = '';

    public function __construct(Markdown $markdown, Purifier $purifier, array $config = [])
    {
        parent::__construct($config);
        $this->markdown = $markdown;
        $this->purifier = $purifier;
    }

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

        if (
            $this->sourceAttribute &&
            $this->destinationAttribute &&
            $this->calculateHash($this->getSource($model)) !== $this->contentHash
        ) {
            $model->{$this->destinationAttribute} = $this->processContent($this->getSource($model));
        }
    }

    public function afterFind(): void
    {
        $model = $this->getModel();

        if (!$this->processOnAfterFind) {
            return;
        }

        $this->contentHash = $this->calculateHash($this->getSource($model));

        if (
            $this->sourceAttribute &&
            $this->destinationAttribute &&
            $this->getSource($model) &&
            !$this->getDestination($model)
        ) {
            $model->{$this->destinationAttribute} = $this->processContent($this->getSource($model));
            if ($this->updateOnAfterFind) {
                $this->updateModel();
            }
        }
    }

    private function processContent(?string $text): ?string
    {
        if ($text === null) {
            return null;
        }

        if ($this->enableMarkdown) {
            $text = $this->markdown->transform($text);
        }

        if ($this->enablePurifier) {
            $text = $this->purifier->purify($text, $this->purifierOptions, $this->encodePreContent);
        }

        return $text;
    }

    private function updateModel(): void
    {
        $model = $this->getModel();
        $model->updateAttributes([
            $this->destinationAttribute => $this->getDestination($model)
        ]);
    }

    private function getModel(): ActiveRecord
    {
        /** @var ActiveRecord|null $owner */
        $owner = $this->owner;
        if ($owner === null) {
            throw new BadMethodCallException('Empty owner.');
        }
        return $owner;
    }

    private function calculateHash(?string $content): string
    {
        return md5($content ?: '');
    }

    private function getSource(ActiveRecord $model): ?string
    {
        /** @var string|null */
        return $model->{$this->sourceAttribute};
    }

    private function getDestination(ActiveRecord $model): ?string
    {
        /** @var string|null */
        return $model->{$this->destinationAttribute};
    }
}
