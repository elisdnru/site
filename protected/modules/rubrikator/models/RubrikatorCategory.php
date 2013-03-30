<?php

DUrlRulesHelper::import('rubrikator');
Yii::import('application.modules.category.models.*');

/**
 * This is the model class for table "{{rubrikator_category}}".
 *
 * The followings are the available columns in table '{{rubrikator_category}}':
 * @property string $type
 */
class RubrikatorCategory extends Category
{
    const IMAGE_PATH = 'upload/images/rubrikator/categories';

    public $urlRoute = '/rubrikator/default/category';
    public $multiLanguage = true;

    public $del_image = false;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RubrikatorCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{rubrikator_category}}';
	}

    public function rules()
    {
        return array_merge(parent::rules(), array(
            array('alias', 'unique', 'caseSensitive' => false, 'className'=>'RubrikatorCategory', 'message' => 'Элемент с таким URL уже существует'),
            array('image', 'file', 'types'=>'jpg,jpeg,gif,png', 'allowEmpty'=>true, 'safe'=>false),
            array('parent_id', 'exists', 'className' => 'RubrikatorCategory', 'attributeName' => 'id'),
            array('del_image', 'safe'),
        ));
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), array(
            'image'=>'Изображение',
            'del_image'=>'Удалить',
        ));
    }

    public function behaviors()
    {
        return array_replace(parent::behaviors(), array(
            'CategoryBehavior'=>array(
                'class'=>'category.components.DCategoryBehavior',
                'titleAttribute'=>'title',
                'aliasAttribute'=>'alias',
                'iconAttribute'=>'imageUrl',
                'linkActiveAttribute'=>'linkActive',
                'requestPathAttribute'=>'category',
                'defaultCriteria'=>$this->multiLanguage && DMultilangHelper::enabled() ? array(
                    'with'=>'i18n' . get_class($this),
                    'order'=>'t.sort ASC, t.title ASC'
                ) : array(
                    'order'=>'t.sort ASC, t.title ASC'
                ),
            ),
            'ImageUpload'=>array(
                'class'=>'uploader.components.DFileUploadBehavior',
                'fileAttribute'=>'image',
                'deleteAttribute'=>'del_image',
                'filePath'=>self::IMAGE_PATH,
            )
        ));
    }

    public function getArticleMenuList($activeCategory='')
    {
        $categories = $this->findAll(array('order'=>'t.sort ASC, t.title ASC'));

        $items = array();

        foreach ($categories as $model)
        {
            $items[] = array(
                'label'=>$model->title,
                'icon'=>$model->ImageUpload->getImageUrl(),
                'active'=>$model->alias == $activeCategory,
                'url'=>$model->getUrl(),
                'items'=>RubrikatorArticle::model()->category($model)->getMenuList()
            );
        }

        return $items;
    }

    private $_url;

    public function getUrl()
    {
        if ($this->_url === null)
            $this->_url = Yii::app()->createUrl($this->urlRoute, array('category'=>$this->alias));
        return $this->_url;
    }
}