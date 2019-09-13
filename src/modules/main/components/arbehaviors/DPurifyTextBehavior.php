<?php
/**
 * DPurifyTextBehavior will automatically purify
 * content from source attribute to destination attribute.
 *
 * Purify source when the active record is created and/or updated.
 * You may specify an active record model to use this behavior like so:
 * <pre>
 * public function behaviors()
 * {
 *     return array(
 *         'PurifyText'=>array(
 *             'class'=>'DPurifyTextBehavior',
 *             'sourceAttribute'=>'text',
 *             'destinationAttribute'=>'purified_text',
 *             'purifierOptions'=> array(
 *                 'HTML.SafeObject'=>true,
 *                 'Output.FlashCompat'=>true,
 *             ),
 *             'processOnBeforeSave'=>true,
 *         )
 *     );
 * }
 * </pre>
 *

 * @version 1.3
 */

class DPurifyTextBehavior extends CActiveRecordBehavior
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

    private $_contentHash = '';

    /**
     * @param CModelEvent $event event parameter
     */
    public function beforeSave($event)
    {
        $model = $this->getOwner();

        if ($this->processOnBeforeSave) {
            if ($this->sourceAttribute &&
                $this->destinationAttribute &&
                $this->calculateHash($model->{$this->sourceAttribute}) !== $this->_contentHash
            ) {
                $model->{$this->destinationAttribute} = $this->processContent($model->{$this->sourceAttribute});
            }
        }
    }

    /**
     * @param CModelEvent $event event parameter
     */
    public function afterFind($event)
    {
        $model = $this->getOwner();

        $this->_contentHash = $this->calculateHash($model->{$this->sourceAttribute});

        if ($this->processOnAfterFind) {
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
    }

    protected function processContent($text)
    {
        if ($this->enableMarkdown) {
            $text = $this->markdownText($text);
        }

        if ($this->enablePurifier) {
            $text = $this->purifyText($text);
        }

        return $text;
    }

    /**
     * @param string $text
     * @return string
     */
    public function markdownText($text)
    {
        $pre = preg_replace('#(~~~[\r\n]+\[php\][\r\n]+)#', '$1<?php' . PHP_EOL, $text);

        $md = new CMarkdownParser;
        $transform = $md->transform($pre);

        return str_replace('<pre><span class="php-hl-inlinetags">&lt;?php</span>' . PHP_EOL, '<pre>', $transform);
    }

    /**
     * @param string $text
     * @return string
     */
    public function purifyText($text)
    {
        $p = new CHtmlPurifier;
        $p->options = $this->purifierOptions;

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

    protected function updateModel()
    {
        $model = $this->getOwner();
        $model->updateByPk($model->getPrimaryKey(), [
            $this->destinationAttribute => $model->{$this->destinationAttribute}
        ]);
    }

    private $_preContents = [];

    private function storePreContent($matches)
    {
        return '<pre' . $matches[1] . '>' . $this->storeContent($matches[2]) . '</pre>';
    }

    private function resumePreContent($matches)
    {
        return '<pre' . $matches[1] . '>' . $this->resumeContent($matches[2]) . '</pre>';
    }

    private function storeCodeContent($matches)
    {
        return '<code' . $matches[1] . '>' . $this->storeContent($matches[2]) . '</code>';
    }

    private function resumeCodeContent($matches)
    {
        return '<code' . $matches[1] . '>' . $this->resumeContent($matches[2]) . '</code>';
    }

    private function storeContent($content)
    {
        do {
            $id = md5(rand(0, 100000));
        } while (isset($this->_preContents[$id]));
        $this->_preContents[$id] = $content;
        return $id;
    }

    private function resumeContent($id)
    {
        return isset($this->_preContents[$id]) ? CHtml::encode($this->_preContents[$id]) : '';
    }

    private function calculateHash($content)
    {
        return md5($content);
    }
}
