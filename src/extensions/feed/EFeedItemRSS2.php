<?php
/**
 * EFeedItemRSS2 Class file
 * @author Antonio Ramirez
 * @link http://www.ramirezcobos.com
 *
 *
 * THIS SOFTWARE IS PROVIDED BY THE CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace app\extensions\feed;

use CException;
use CHtml;

/**
 * EFeedItemRSS2 is an element of an RSS 2.0 Feed
 *
 * @throws        CException
 * @package    rss
 * @uses        CUrlValidator
 * @author        Antonio Ramirez <ramirez.cobos@gmail.com>
 */
class EFeedItemRSS2 extends EFeedItemAbstract
{
    /**
     * (non-PHPdoc)
     * @see EFeedItemAbstract::setDate()
     */
    public function setDate($date)
    {
        if (!is_numeric($date)) {
            $date = strtotime($date);
        }

        $date = date(DATE_RSS, $date);

        $this->addTag('pubDate', $date);
    }

    /**
     *
     * Property getter date
     * @return mixed value of date | null
     */
    public function getDate()
    {
        return $this->tags->itemAt('pubDate');
    }

    /**
     * (non-PHPdoc)
     * @see EFeedItemAbstract::getNode()
     */
    public function getNode()
    {


        $node = "\t" . CHtml::openTag('item') . PHP_EOL;

        foreach ($this->tags as $tag) {
            $node .= $this->getElement($tag);
        }

        $node .= "\t" . CHtml::closeTag('item');

        return $node . PHP_EOL;
    }

    /**
     *
     * @returns mixed well formatted xml element
     * @param EFeedTag $tag
     */
    private function getElement(EFeedTag $tag)
    {

        $element = "\t\t";

        if (in_array($tag->name, $this->CDATAEncoded)) {
            $element .= CHtml::openTag($tag->name, $tag->attributes);
            $element .= '<![CDATA[';
        } else {
            $element .= CHtml::openTag($tag->name, $tag->attributes);
        }

        if (is_array($tag->content)) {
            foreach ($tag->content as $tag => $content) {
                $tmpTag = new EFeedTag($tag, $content);

                $element .= $this->getElement($tmpTag);
            }
        } else {
            $element .= (in_array($tag->name, $this->CDATAEncoded)) ? $tag->content : CHtml::encode($tag->content);
        }

        $element .= (in_array($tag->name, $this->CDATAEncoded)) ? ']]>' : "";

        $element .= CHtml::closeTag($tag->name) . PHP_EOL;

        return $element;
    }

    /**
     *
     * Set the 'encloser' element of feed item
     *
     * @param string  The url attribute of encloser tag
     * @param string  The length attribute of encloser tag
     * @param string  The type attribute of encloser tag
     */
    public function setEncloser($url, $length, $type)
    {
        $attributes = ['url' => $url, 'length' => $length, 'type' => $type];

        $this->addTag('enclosure', '', $attributes);
    }
}
