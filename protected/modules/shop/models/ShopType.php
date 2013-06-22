<?php

DUrlRulesHelper::import('shop');
Yii::import('application.modules.category.models.*');

/**
 * This is the model class for table "{{shop_category}}".
 *
 * The followings are the available columns in table '{{shop_category}}':
 * @property boolean $visible
 * @property string $type
 */
class ShopType extends Category
{
    const IMAGE_PATH = 'upload/images/shop/types';

    public $del_image = false;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ShopCategory the static model class
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
		return '{{shop_type}}';
	}

    public function rules()
    {
        return array_merge(parent::rules(), array(
            array('alias', 'unique', 'caseSensitive' => false, 'className'=>'ShopType', 'message' => 'Элемент с таким URL уже существует'),
            array('del_image', 'safe'),
        ));
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array_merge(parent::relations(), array(
            'categories' => array(self::HAS_MANY, 'ShopCategory', 'parent_id',
                'order'=>'categories.sort ASC, categories.title ASC'
            ),
            'items_count' => array(self::STAT, 'ShopProduct', 'type_id',
                'condition'=>'public = 1',
            ),
        ));
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), array(
            'visible'=>'Выводить в меню',
            'image'=>'Изображение',
            'del_image'=>'Удалить',
        ));
    }

    public function behaviors()
    {
        return array(
            'CategoryBehavior'=>array(
                'class'=>'category.components.DCategoryBehavior',
                'titleAttribute'=>'title',
                'aliasAttribute'=>'alias',
                'iconAttribute'=>'imageUrl',
                'linkActiveAttribute'=>'linkActive',
                'requestPathAttribute'=>'type',
                'defaultCriteria'=>array(
                    'order'=>'t.sort ASC, t.title ASC'
                ),
            ),
            'ImageUpload'=>array(
                'class'=>'uploader.components.DFileUploadBehavior',
                'fileAttribute'=>'image',
                'deleteAttribute'=>'del_image',
                'filePath'=>self::IMAGE_PATH,
            )
        );
    }

    public function scopes()
    {
        return array(
            'visible'=>array(
                'condition'=>'t.visible=1',
            ),
        );
    }

    public function getSuperMenuList()
    {
        $types = $this->findAll(array('order'=>'t.sort ASC, t.title ASC'));

        $items = array();

        foreach ($types as $type)
        {
             $items[] = array(
                 'label'=>$type->title,
                 'icon'=>$type->ImageUpload->getImageUrl(),
                 'url'=>$type->getUrl(),
                 'active'=>$type->CategoryBehavior->getLinkActive(),
                 'items'=>ShopCategory::model()->type($type->id)->getMenuList()
             );
        }

        return $items;
    }

    public function getRubricMenuList($rubric_id)
    {
		if (Yii::app()->moduleManager->installed('rubricator'))
		{
			$types = $this->findAll(array('order'=>'t.sort ASC, t.title ASC'));

			$items = array();

			foreach ($types as $type)
			{
				$count = ShopProduct::model()->cache(3600)->count(array(
					'condition'=>'t.public=1 AND product_rubrics.rubric_id = :rubric AND t.type_id = :type',
					'params'=>array(
						':rubric'=>$rubric_id,
						':type'=>$type->id,
					),
					'with'=>'product_rubrics',
				));
	
				if ($count)
				{
					$items[] = array(
						'label'=>$type->title,
						'url'=>$type->getUrl(),
						'active'=>$type->CategoryBehavior->getLinkActive(),
					);
				}
			}

			return $items;
		}
		return array();
    }

    private $_url;

    public function getUrl()
    {
        if ($this->_url === null)
        {
			DUrlRulesHelper::import('shop');
            if ($brand = Yii::app()->getRequest()->getQuery('brand'))
                $this->_url = Yii::app()->createUrl('/shop/default/brand', array('type'=>$this->alias, 'brand'=>$brand));
            elseif ($rubric = Yii::app()->getRequest()->getQuery('rubric'))
                $this->_url = Yii::app()->createUrl('/shop/default/rubric', array('type'=>$this->alias, 'rubric'=>$rubric));
            else
                $this->_url = Yii::app()->createUrl('/shop/default/type', array('type'=>$this->alias));
        }
        return $this->_url;
    }
}