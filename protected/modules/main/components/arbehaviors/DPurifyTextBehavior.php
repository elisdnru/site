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
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 * @version 1.2
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
    public $purifierOptions = array();

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

    /**
     * @param CModelEvent $event event parameter
     */
    public function beforeSave($event)
    {
        if ($this->processOnBeforeSave)
        {
            $model = $this->getOwner();
            if ($this->sourceAttribute && $this->destinationAttribute)
                $model->{$this->destinationAttribute} = $this->processContent($model->{$this->sourceAttribute});
        }
    }

    /**
     * @param CModelEvent $event event parameter
     */
    public function afterFind($event)
    {
        if ($this->processOnAfterFind)
        {
            $model = $this->getOwner();
            if (
                $this->sourceAttribute &&
                $this->destinationAttribute &&
                $model->{$this->sourceAttribute} &&
                !$model->{$this->destinationAttribute}
            )
            {
                $model->{$this->destinationAttribute} = $this->processContent($model->{$this->sourceAttribute});
                if ($this->updateOnAfterFind)
                    $this->updateModel();
            }
        }
    }

    protected function processContent($text)
    {
        if ($this->enableMarkdown)
            $text = $this->markdownText($text);

        if ($this->enablePurifier)
            $text = $this->purifyText($text);

        return $text;
    }

    /**
     * @param string $text
     * @return string
     */
    public function markdownText($text)
    {
        $md = new CMarkdownParser;
        return $md->transform($text);
    }

    /**
     * @param string $text
     * @return string
     */
    public function purifyText($text)
    {
        $p = new CHtmlPurifier;
        $p->options = $this->purifierOptions;

        if ($this->encodePreContent)
        {
            $text = preg_replace_callback('|<pre([^>]*)>(.*)</pre>|ismU', array($this, 'storePreContent'), $text);
            $text = preg_replace_callback('|<code([^>]*)>(.*)</code>|ismU', array($this, 'storeCodeContent'), $text);
        }

        $text = $p->purify(trim($text));

        if ($this->encodePreContent)
        {
            $text = preg_replace_callback('|<pre([^>]*)>(.*)</pre>|ismU', array($this, 'resumePreContent'), $text);
            $text = preg_replace_callback('|<code([^>]*)>(.*)</code>|ismU', array($this, 'resumeCodeContent'), $text);
        }

        return $text;
    }

    protected function updateModel()
    {
        $model = $this->getOwner();
        $model->updateByPk($model->getPrimaryKey(), array(
            $this->destinationAttribute => $model->{$this->destinationAttribute}
        ));
    }

    private $_preContents = array();

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

    private  function resumeContent($id)
    {
        return isset($this->_preContents[$id]) ? CHtml::encode($this->_preContents[$id]) : '';
    }
}