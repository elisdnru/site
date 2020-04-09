<?php

namespace app\extensions\markdown;

use MarkdownExtra_Parser;
use Text_Highlighter;
use Text_Highlighter_Renderer_Html;
use yii\helpers\Html;

// phpcs:disable PSR1.Methods.CamelCapsMethodName
// phpcs:disable PSR2.Methods.MethodDeclaration.Underscore

/**
 * MarkdownParser class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * MarkdownParser is a wrapper of {@link http://michelf.com/projects/php-markdown/extra/ MarkdownExtra_Parser}.
 *
 * MarkdownParser extends MarkdownExtra_Parser by using Text_Highlighter
 * to highlight code blocks with specific language syntax.
 * In particular, if a code block starts with the following:
 * <pre>
 * [language]
 * </pre>
 * The syntax for the specified language will be used to highlight
 * code block. The languages supported include (case-insensitive):
 * ABAP, CPP, CSS, DIFF, DTD, HTML, JAVA, JAVASCRIPT,
 * MYSQL, PERL, PHP, PYTHON, RUBY, SQL, XML
 *
 * You can also specify options to be passed to the syntax highlighter. For example:
 * <pre>
 * [php showLineNumbers=1]
 * </pre>
 * which will show line numbers in each line of the code block.
 *
 * For details about the standard markdown syntax, please check the following:
 * <ul>
 * <li>{@link http://daringfireball.net/projects/markdown/syntax official markdown syntax}</li>
 * <li>{@link http://michelf.com/projects/php-markdown/extra/ markdown extra syntax}</li>
 * </ul>
 *
 * @property string $defaultCssFile The default CSS file that is used to highlight code blocks.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @package system.utils
 * @since 1.0
 */
class MarkdownParser extends MarkdownExtra_Parser
{
    /**
     * @var string the css class for the div element containing
     * the code block that is highlighted. Defaults to 'hl-code'.
     */
    public $highlightCssClass = 'hl-code';

    /**
     * Callback function when a code block is matched.
     * @param array $matches matches
     * @return string the highlighted code block
     */
    public function _doCodeBlocks_callback($matches)
    {
        $codeblock = $this->outdent($matches[1]);
        if (($codeblock = $this->highlightCodeBlock($codeblock)) !== null) {
            return "\n\n" . $this->hashBlock($codeblock) . "\n\n";
        }
        return parent::_doCodeBlocks_callback($matches);
    }

    /**
     * Callback function when a fenced code block is matched.
     * @param array $matches matches
     * @return string the highlighted code block
     */
    public function _doFencedCodeBlocks_callback($matches)
    {
        return "\n\n" . $this->hashBlock($this->highlightCodeBlock($matches[2])) . "\n\n";
    }

    /**
     * Highlights the code block.
     * @param string $codeblock the code block
     * @return string the highlighted code block. Null if the code block does not need to highlighted
     */
    private function highlightCodeBlock($codeblock)
    {
        if (($tag = $this->getHighlightTag($codeblock)) !== null && ($highlighter = $this->createHighLighter($tag))) {
            $codeblock = preg_replace('/\A\n+|\n+\z/', '', $codeblock);
            $tagLen = strpos($codeblock, $tag) + strlen($tag);
            $codeblock = ltrim(substr($codeblock, $tagLen));
            $output = preg_replace('/<span\s+[^>]*>(\s*)<\/span>/', '\1', $highlighter->highlight($codeblock));
            return "<div class=\"{$this->highlightCssClass}\">" . $output . "</div>";
        }
        return "<pre>" . Html::encode($codeblock) . "</pre>";
    }

    /**
     * Returns the user-entered highlighting options.
     * @param string $codeblock code block with highlighting options.
     * @return string the user-entered highlighting options. Null if no option is entered.
     */
    private function getHighlightTag($codeblock)
    {
        $str = trim(current(preg_split("/\r|\n/", $codeblock, 2)));
        if (strlen($str) > 2 && $str[0] === '[' && $str[strlen($str) - 1] === ']') {
            return $str;
        }
        return '';
    }

    /**
     * Creates a highlighter instance.
     * @param string $options the user-entered options
     * @return Text_Highlighter the highlighter instance
     */
    private function createHighLighter($options)
    {
        if (!class_exists('Text_Highlighter', false)) {
            require_once(__DIR__ . '/TextHighlighter/Text/Highlighter.php');
            require_once(__DIR__ . '/TextHighlighter/Text/Highlighter/Renderer/Html.php');
        }
        $lang = current(preg_split('/\s+/', substr(substr($options, 1), 0, -1), 2));
        $highlighter = Text_Highlighter::factory($lang);
        if ($highlighter) {
            $highlighter->setRenderer(new Text_Highlighter_Renderer_Html($this->getHighlightConfig($options)));
        }
        return $highlighter;
    }

    /**
     * Generates the config for the highlighter.
     * @param string $options user-entered options
     * @return array the highlighter config
     */
    private function getHighlightConfig($options)
    {
        $config = ['use_language' => true];
        if ($this->getInlineOption('showLineNumbers', $options, false)) {
            $config['numbers'] = HL_NUMBERS_LI;
        }
        $config['tabsize'] = $this->getInlineOption('tabSize', $options, 4);
        return $config;
    }

    /**
     * Retrieves the specified configuration.
     * @param string $name the configuration name
     * @param string $str the user-entered options
     * @param mixed $defaultValue default value if the configuration is not present
     * @return mixed the configuration value
     */
    private function getInlineOption($name, $str, $defaultValue)
    {
        if (preg_match('/' . $name . '(\s*=\s*(\d+))?/i', $str, $v) && count($v) > 2) {
            return $v[2];
        }
        return $defaultValue;
    }
}
