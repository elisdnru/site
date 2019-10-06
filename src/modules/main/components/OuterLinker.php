<?php

namespace app\modules\main\components;

/**
 * Replaces outer links like '<a href="http://..."></a>'
 * to redirection URL like '<a href="/link?url=http..."></a>'
 *
 * Inline usage:
 * <pre>
 *     echo DOuterLinker::load()->process($html);
 *     echo DOuterLinker::load()->setPrefix('/link?a=')->process($html);
 *     echo DOuterLinker::load()->addProtocols(array('dc'))->setPrefix('/link?a=')->process($html);
 * </pre>
 *
 * Classic usage:
 * <pre>
 *     $linker = new DOuterLinker();
 *     $linker->setProtocols(array('http'));
 *     $linker->setPrefix('/site/link?a=');
 *     echo $linker->process($html);
 * </pre>
 *
 */
class OuterLinker
{
    protected $_protocols = ['ftp', 'http', 'https'];
    protected $_prefix = '/link?url=';

    /**
     * @return OuterLinker
     */
    public static function load()
    {
        return new self();
    }

    /**
     * Adds array of your protocols into protocols list
     * @param mixed $protocols like array('dc');
     * @return OuterLinker
     */
    public function addProtocols($protocols)
    {
        $this->_protocols = array_unique(array_merge($this->_protocols, $protocols));
        return $this;
    }

    /**
     * Replaces protocol list
     * @param mixed $protocols like array('http', 'https');
     * @return OuterLinker
     */
    public function setProtocols($protocols)
    {
        $this->_protocols = $protocols;
        return $this;
    }

    /**
     * Sets prefix for new URL generating
     * @param string $value
     * @return OuterLinker
     */
    public function setPrefix($value)
    {
        $this->_prefix = $value;
        return $this;
    }

    /**
     * @param string $html source HTML content
     * @return string processed content
     */
    public function process($html)
    {
        $protocols = implode('|', $this->_protocols);
        return preg_replace_callback('@\<a(?P<before>[^>]+)href=(?P<beginquote>[\'"]?)(?P<protocol>' . $protocols . ')://(?P<url>[^\'"\s]+)(?P<endquote>[\'"]?)(?P<after>[^>]+)?\>@i', [get_class($this), 'pregCallback'], $html);
    }

    protected function pregCallback($matches)
    {
        $before = $matches['before'] ?? '';
        $beginquote = $matches['beginquote'] ?? '';
        $protocol = $matches['protocol'] ?? '';
        $url = $matches['url'] ?? '';
        $endquote = $matches['endquote'] ?? '';
        $after = $matches['after'] ?? '';

        return '<a' . $before . 'href=' . $beginquote . $this->_prefix . $protocol . '://' . urlencode($url) . $endquote . $after . '>';
    }
}
