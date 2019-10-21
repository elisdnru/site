<?php
/**

 * @version 1.2
 */

namespace app\components\widgets\grid;

use CActiveDataProvider;
use CException;
use CGridColumn;
use CHtml;
use CJavaScript;
use Yii;
use yii\web\View;

Yii::import('zii.widgets.grid.CGridColumn');

class ToggleColumn extends CGridColumn
{
    /**
     * @var string the attribute name of the data model.
     */
    public $name;
    /**
     * @var boolean a PHP expression if needle.
     */
    public $value;
    /**
     * @var string or a PHP expression that will be evaluated url to toggle action.
     */
    public $linkUrl;
    /**
     * @var array captions for 'alt' and 'title' attributes of icon.
     */
    public $titles = [1 => 'Active', 0 => 'Not active'];
    /**
     * @var string icon address.
     */
    public $onImageUrl;
    /**
     * @var string icon address.
     */
    public $offImageUrl;
    /**
     * @var int icon width and icon height.
     */
    public $imageSize = 16;
    /**
     * @var string confirmation text if needle.
     */
    public $confirmation;
    /**
     * @var boolean whether the column is sortable.
     */
    public $sortable = true;
    /**
     * @var mixed the HTML code representing a filter input.
     */
    public $filter;
    /**
     * @var array the HTML options for the data cell tags.
     */
    public $htmlOptions = ['class' => 'toggle-column'];

    /**
     * @var string stores CSS class name for link
     */
    protected $class;

    private static $increment_id = 0;

    /**
     * @throws CException
     */
    public function init(): void
    {
        parent::init();

        if (empty($this->name)) {
            $this->sortable = false;
        }

        if (empty($this->onImageUrl)) {
            $this->onImageUrl = '/images/admin/yes.png';
        }

        if (empty($this->offImageUrl)) {
            $this->offImageUrl = '/images/admin/no.png';
        }

        if (empty($this->name) && empty($this->value)) {
            throw new CException('Either "name" or "value" must be specified for DToggleColumn.');
        }

        $this->registerClientScript();
    }

    public function getFilterCellContent(): string
    {
        if (is_string($this->filter)) {
            return $this->filter;
        }

        if ($this->filter !== false && $this->grid->filter !== null && $this->name !== null && strpos($this->name, '.') === false) {
            if (is_array($this->filter)) {
                return CHtml::activeDropDownList($this->grid->filter, $this->name, $this->filter, ['id' => false, 'prompt' => '']);
            }

            if ($this->filter === null) {
                return CHtml::activeTextField($this->grid->filter, $this->name, ['id' => false]);
            }
        }

        return parent::getFilterCellContent();
    }

    public function getHeaderCellContent(): string
    {
        $provider = $this->grid->dataProvider;

        if ($this->grid->enableSorting && $this->sortable && $this->name !== null) {
            return $provider->getSort()->link($this->name, $this->header, ['class' => 'sort-link']);
        }
        if ($this->name !== null && $this->header === null) {
            if ($provider instanceof CActiveDataProvider) {
                return CHtml::encode($provider->model->getAttributeLabel($this->name));
            }
            return CHtml::encode($this->name);
        }
        return parent::getHeaderCellContent();
    }

    protected function registerClientScript(): void
    {
        if (is_string($this->confirmation)) {
            $confirmation = 'if(!confirm(' . CJavaScript::encode($this->confirmation) . ')) return false;';
        } else {
            $confirmation = '';
        }

        if (Yii::app()->request->enableCsrfValidation) {
            $csrfTokenName = Yii::app()->request->csrfTokenName;
            $csrfToken = Yii::app()->request->csrfToken;
            $csrf = "\n\t\tdata:{ '$csrfTokenName':'$csrfToken' },";
        } else {
            $csrf = '';
        }

        $this->class = 'toggle-property-p' . ++self::$increment_id;

        $js = "
$(document).on('click','#{$this->grid->id} a.{$this->class}', function(){
    $confirmation
    $('#{$this->grid->id}').addClass('{$this->grid->loadingCssClass}');
    var th=this;
    $.ajax({
        type:'POST',
        url:$(this).attr('href'),$csrf
        success:function(data) {
            $('#{$this->grid->id}').removeClass('{$this->grid->loadingCssClass}');
            $(th).toggleClass('toggle-true');
            afterAjaxUpdate(th,true,data);
        },
        error:function(XHR) {
            $('#{$this->grid->id}').removeClass('{$this->grid->loadingCssClass}');
            alert(XHR.responseText);
        }
    });
    return false;
});
        ";

        Yii::$app->view->registerJs($js, View::POS_END);

        $style = '
        .toggle-link .icon-on, .toggle-link .icon-off {display:block; margin:0 auto;}
        .toggle-link .icon-on {display:none;}
        .toggle-link .icon-off {display:block;}
        .toggle-link.toggle-true .icon-on {display:block !important;}
        .toggle-link.toggle-true .icon-off {display:none !important;}
        ';

        Yii::$app->view->registerCSS($style);
    }

    protected function renderDataCellContent($row, $data): void
    {
        if (!empty($this->visible) && !is_bool($this->visible)) {
            $visible = $this->evaluateExpression($this->visible, ['data' => $data, 'row' => $row]);
        } else {
            $visible = $this->visible;
        }

        if ($visible) {
            $value = null;
            if (!empty($this->value)) {
                $value = $this->evaluateExpression($this->value, ['data' => $data, 'row' => $row]);
            } elseif (!empty($this->name)) {
                $value = CHtml::value($data, $this->name);
            }

            if (!empty($this->linkUrl)) {
                $url = $this->evaluateExpression($this->linkUrl, ['data' => $data, 'row' => $row]);
            } elseif ($this->linkUrl !== false) {
                $url = Yii::app()->controller->createUrl('toggle', ['id' => $data->primaryKey, 'attribute' => $this->name]);
            } else {
                $url = '';
            }

            $iconStyle = 'width:' . $this->imageSize . 'px; height:' . $this->imageSize . 'px;';
            $onImage = CHtml::image($this->onImageUrl, $this->titles[1], ['title' => $this->titles[1], 'style' => $iconStyle, 'class' => 'icon-on']);
            $offImage = CHtml::image($this->offImageUrl, $this->titles[0], ['title' => $this->titles[0], 'style' => $iconStyle, 'class' => 'icon-off']);

            if (!empty($url)) {
                echo CHtml::link($onImage . $offImage, $url, ['class' => 'toggle-link ' . $this->class . ($value ? ' toggle-true' : '')]);
            } else {
                echo $value ? $onImage : $offImage;
            }
        } else {
            echo $this->grid->nullDisplay;
        }
    }
}
