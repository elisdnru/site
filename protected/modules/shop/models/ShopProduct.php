<?php

Yii::import('application.modules.shop.models.*');

/**
 * This is the model class for table "{{shop_product}}".
 *
 * The followings are the available columns in table '{{shop_product}}':
 * @property integer $id
 * @property string $artikul
 * @property integer $type_id
 * @property integer $category_id
 * @property integer $brand_id
 * @property string $title
 * @property string $short
 * @property string $text
 * @property string $count
 * @property float $price
 * @property float $public
 * @property float $popular
 * @property float $inhome
 * @property float $sale
 * @property float $priority
 * @property float $rating
 * @property float $rating_count
 * @property float $rating_summ
 * @property string $pagetitle
 * @property string $description
 * @property string $keywords
 *
 * @property ShopProductAttributeValue[] $inshort_attribute_values
 * @property ShopProductAttributeValue[] $all_attribute_values
 *
 * @property ShopProductAttribute[] $otherAttributes
 * @property ShopCategory[] $otherCategories
 * @property ShopSize[] $sizes
 * @property ShopColor[] $colors
 *
 * @method ShopProduct published()
 * @method ShopProduct inhome()
 * @method ShopProduct popular()
 */
class ShopProduct extends CActiveRecord
{
    public $size;
    public $color;
    public $grouped;
    public $rubric;

    protected $_otherAttributes;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ShopProduct the static model class
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
		return '{{shop_product}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('artikul, title, price, priority, type_id, category_id', 'required'),
			array('type_id, category_id, brand_id, public, popular, inhome, sale, count, priority', 'numerical', 'integerOnly'=>true),
			array('artikul', 'length', 'max'=>128),
            array('artikul', 'unique', 'caseSensitive' => false, 'className' => 'ShopProduct', 'message' => 'Такой {attribute} уже используется'),
			array('title, pagetitle, keywords', 'length', 'max'=>255),
			array('title, short, text, description', 'safe'),
			array('otherAttributesAssoc', 'safe'),

			array('id, artikul, type_id, category_id, title, pagetitle, description, keywords, text, price, count, priority, public, popular, inhome, rating, rating_count, rating_summ, size, rubric', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		$relations = array(
            'type' => array(self::BELONGS_TO, 'ShopType', 'type_id'),
            'category' => array(self::BELONGS_TO, 'ShopCategory', 'category_id'),
            'brand' => array(self::BELONGS_TO, 'ShopBrand', 'brand_id'),
            'images' => array(self::HAS_MANY, 'ShopImage', 'product_id',
                'order'=>'images.main DESC, images.id ASC'
            ),
            'models' => array(self::HAS_MANY, 'ShopModel', 'product_id',
                'order'=>'models.title ASC'
            ),
            'related_products' => array(self::HAS_MANY, 'ShopProduct', array('title'=>'title'),
                'order'=>'related_products.id ASC'
            ),
            'inshort_attribute_values' => array(self::HAS_MANY, 'ShopProductAttributeValue', 'product_id',
                'condition'=>'attribute.inshort = 1',
                'order'=>'attribute.sort ASC',
                'with'=>'attribute',
            ),
            'all_attribute_values' => array(self::HAS_MANY, 'ShopProductAttributeValue', 'product_id',
                'order'=>'attribute.sort ASC',
                'with'=>'attribute',
            ),
            'other_product_categories' => array(self::HAS_MANY, 'ShopProductOthercategory', 'product_id'),
            'other_categories'=>array(self::MANY_MANY, 'ShopCategory', '{{shop_product_othercategory}}(product_id, category_id)',
                'order'=>'other_categories.title',
            ),
            'product_sizes' => array(self::HAS_MANY, 'ShopProductSize', 'product_id'),
            'sizes'=>array(self::MANY_MANY, 'ShopSize', '{{shop_product_size}}(product_id, size_id)',
                'order'=>'sizes.sort',
            ),
            'product_colors' => array(self::HAS_MANY, 'ShopProductColor', 'product_id'),
            'colors'=>array(self::MANY_MANY, 'ShopColor', '{{shop_product_color}}(product_id, color_id)',
                'order'=>'colors.sort',
            ),
            'images_count' => array(self::STAT, 'ShopImage', 'product'),
		);

        if (Yii::app()->moduleManager->installed('rubricator'))
        {
            Yii::import('application.modules.rubricator.models.RubricatorArticle');
            $relations = array_merge($relations, array(
                'product_rubrics' => array(self::HAS_MANY, 'ShopProductRubric', 'product_id'),
                'rubrics'=>array(self::MANY_MANY, 'RubricatorArticle', '{{shop_product_rubric}}(product_id, rubric_id)',
                    'order'=>'rubrics.date DESC',
                ),
            ));
        }

        return $relations;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'type_id' => 'Тип',
            'category_id' => 'Категория',
            'brand_id' => 'Производитель',
            'artikul' => 'Артикул',
            'title' => 'Наименование',
            'pagetitle' => 'Заголовок окна (title)',
            'description' => 'Описание (description)',
            'keywords' => 'Ключевые слова (keywords)',
            'image' => 'Изображения',
            'short' => 'Превью',
            'text' => 'Текст',
            'price' => 'Цена',
            'priority' => 'Приоритет',
            'count' => 'Количество на складе',
            'public' => 'Опубликован',
            'popular' => 'Популярный',
            'inhome' => 'На главной',
            'sale' => 'Участвует в акции',
            'rating' => 'Рейтинг',
            'otherCategoriesArray' => 'Дополнительные категории',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($pageSize=10)
	{
		$criteria=new CDbCriteria;
        $with = array();

        if ($this->grouped)
            $criteria->group = 't.title';

        $searchCategories = array();

        if ($this->type_id && !$this->category_id)
        {
            $categoriesArray = CHtml::listData(ShopCategory::model()->type($this->type_id)->findAll(), 'id', 'id');
            $searchCategories = array_merge($searchCategories, array_keys($categoriesArray));
        }

        if ($this->category_id)
            $searchCategories = array_merge($searchCategories, array($this->category_id));

        if (count($searchCategories))
        {
            $categoryIds = array();

            foreach ($searchCategories as $categoryId)
            {
                $category = ShopCategory::model()->findByPk($categoryId);
                $categoryIds = CArray::merge($categoryIds, CArray::merge(array($category->id), $category->getChildsArray()));
            }

            $othersArray = array();
            $categoryCriteria = new CDbCriteria();
            $categoryCriteria->addInCondition('t.id', $searchCategories);
            $categories = ShopCategory::model()->findAll($categoryCriteria);
            foreach ($categories as $category)
            {
                $others = ShopProductOthercategory::model()->findAllByAttributes(array('category_id'=>$category->id));
                foreach ($others as $other)
                    $othersArray[] = $other->product_id;
            }

            $criteria->addInCondition('t.category_id', $categoryIds);
            $criteria->addInCondition('t.id', array_unique($othersArray), 'OR');
        }

        if ($this->size)
        {
            if (!is_numeric($this->size))
                $size = ShopSize::model()->findByAlias($this->size);
            else
                $size = $this->size;

            $criteria->compare('product_sizes.size_id', $size);
            $with['product_sizes'] = array('together'=>true);
        }

        if ($this->color)
        {
            if (!is_numeric($this->color))
                $color = ShopColor::model()->findByAlias($this->color);
            else
                $color = $this->size;

            $criteria->compare('product_colors.color_id', $color);
            $with['product_colors'] = array('together'=>true);
        }

        if (Yii::app()->moduleManager->installed('rubricator'))
        {
            if ($this->rubric)
            {
                $criteria->compare('product_rubrics.rubric_id', $this->rubric);
                $with['product_rubrics'] = array('together'=>true);
            }
        }

        $criteria->compare('t.id',$this->id);
        $criteria->compare('t.brand_id',$this->brand_id);
        $criteria->compare('t.artikul',$this->artikul,true);
        $criteria->compare('t.title',$this->title,true);
        $criteria->compare('t.pagetitle',$this->pagetitle,true);
        $criteria->compare('t.description',$this->description,true);
        $criteria->compare('t.keywords',$this->keywords,true);
        $criteria->compare('t.text',$this->text,true);
        $criteria->compare('t.price',$this->price,true);
        $criteria->compare('t.priority',$this->priority);
        $criteria->compare('t.rating',$this->rating);
        $criteria->compare('t.rating_count',$this->rating_count);
        $criteria->compare('t.rating_summ',$this->rating_summ);
        $criteria->compare('t.public',$this->public);
        $criteria->compare('t.popular',$this->popular);
        $criteria->compare('t.inhome',$this->inhome);
        $criteria->compare('t.sale',$this->sale);

        $criteria->with = array_merge(array('type', 'category'), $with);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'t.id DESC',
                'attributes'=>array(
                    'date',
                    'title',
                    'artikul',
                    'type_id'=>array(
                        'asc'=>'type.title ASC',
                        'desc'=>'type.title DESC',
                    ),
                    'category_id'=>array(
                        'asc'=>'category.title ASC',
                        'desc'=>'category.title DESC',
                    ),
                    'brand_id'=>array(
                        'asc'=>'brand.title ASC',
                        'desc'=>'brand.title DESC',
                    ),
                    'color_id'=>array(
                        'asc'=>'color.title ASC',
                        'desc'=>'color.title DESC',
                    ),
                    'public',
                    'inhome',
                    'popular',
                    'sale',
                    'price',
                    'priority',
                ),
                'sortVar'=>'sort',
            ),
            'pagination'=>array(
                'pageSize'=>$pageSize,
                'pageVar'=>'page',
            ),
        ));
	}

    public function scopes()
    {
        return array(
            'published'=>array(
                'condition'=>'t.public=1',
            ),
            'inhome'=>array(
                'condition'=>'t.inhome=1',
            ),
            'popular'=>array(
                'condition'=>'t.popular=1',
            ),
        );
    }

    public function behaviors()
    {
        $behaviors = array(
            'PurifyText'=>array(
                'class'=>'DPurifyTextBehavior',
                'sourceAttribute'=>'text',
                'destinationAttribute'=>'text_purified',
                'purifierOptions'=> array(
                    'HTML.SafeObject'=>true,
                    'Output.FlashCompat'=>true,
                ),
                'processOnBeforeSave'=>true,
            ),
            'shopItem'=>array(
                'class'=>'application.modules.shop.components.ShopItemBehavior',
            ),
            'MultiListCategory'=>array(
                'class'=>'DMultiplyListBehavior',
                'attribute'=>'otherCategoriesArray',
                'relation'=>'other_categories',
                'relationPk'=>'id',
            ),
            'MultiListSize'=>array(
                'class'=>'DMultiplyListBehavior',
                'attribute'=>'sizesArray',
                'relation'=>'sizes',
                'relationPk'=>'id',
            ),
            'MultiListColor'=>array(
                'class'=>'DMultiplyListBehavior',
                'attribute'=>'colorsArray',
                'relation'=>'colors',
                'relationPk'=>'id',
            ),
            'PingBehavior'=>array(
                'class'=>'DPingBehavior',
                'urlAttribute'=>'url',
            ),
        );

        if (Yii::app()->moduleManager->installed('rubricator'))
        {
            $behaviors = array_merge($behaviors, array(
                'MultiListRubric'=>array(
                    'class'=>'DMultiplyListBehavior',
                    'attribute'=>'rubricsArray',
                    'relation'=>'rubrics',
                    'relationPk'=>'id',
                ),
            ));
        }

        return $behaviors;
    }

    public function findByArtikul($artikul)
    {
        $model = $this->find(array(
            'condition'=>'artikul = :artikul',
            'params'=>array(':artikul'=>$artikul)
        ));
        return $model;
    }

    public function getSlidesList($width=0, $height=0)
    {
        $items = array();

        $products = $this->findAll(array(
            'order'=>'id DESC',
        ));

        foreach($products as $product)
        {
            $items[] = array(
                'title' => $product->title,
                'text' => '',
                'image' => $product->firstImage ? $product->firstImage->getImageThumbUrl($width, $height) : '',
                'url' => $product->url,
            );
        }

        return $items;
    }

    public function getSizesAccos()
    {
        $result = array();

        foreach ($this->sizes as $size)
        {
             $result[$size->title] = $size->title;
        }

        return $result;
    }

    public function getColorsAccos()
    {
        $result = array();

        foreach ($this->colors as $color)
        {
             $result[$color->title] = $color->title;
        }

        return $result;
    }

    public function updateRating($value=0)
    {
        $value = (float)$value;

        if ($value)
        {
            $this->rating_count++;
            $this->rating_summ += $value;
        }

        $this->rating = $this->rating_count ? $this->rating_summ / $this->rating_count : 0;

        $this->updateByPk($this->id, array(
            'rating_count'=>$this->rating_count,
            'rating_summ'=>$this->rating_summ,
            'rating'=>$this->rating,
        ));
    }

    protected function beforeDelete()
    {
        if (parent::beforeDelete())
        {
            foreach ($this->all_attribute_values as $val)
                $val->delete();

            foreach ($this->product_sizes as $productSize)
                $productSize->delete();

            foreach ($this->images as $image)
                $image->delete();

            foreach ($this->models as $model)
                $model->delete();

            return true;
        }
        else
            return false;
    }

    protected function afterSave()
    {
        $this->loadImages();
        $this->saveColors();
        $this->saveSizes();
        $this->saveRubrics();
        $this->saveOtherCategories();
        $this->saveOtherAttributes();
        parent::afterSave();
    }

    protected function loadImages()
    {
        if (isset($_FILES['ShopProduct']) && isset($_FILES['ShopProduct']['tmp_name']))
        {
            foreach ($_FILES['ShopProduct']['tmp_name'] as $input=>$data)
            {
                if ($_FILES['ShopProduct']['tmp_name'][$input] && preg_match('|^image_.+|', $input))
                {
                    $image = new ShopImage();
                    $image->product_id = $this->id;
                    $image->image = CUploadedFile::getInstance($this, $input);
                    $image->save();
                }
                unset($_FILES['News']['tmp_name'][$input]);
            }
        }
    }

    protected function saveRubrics()
    {
        if (Yii::app()->moduleManager->installed('rubricator'))
        {
            $rubrics = $this->rubricsArray;

            foreach ($this->product_rubrics as $productRubric)
                $productRubric->delete();

            if (is_array($rubrics))
            {
                foreach ($rubrics as $rubric_id)
                {
                    $productRubric = new ShopProductRubric();
                    $productRubric->product_id = $this->id;
                    $productRubric->rubric_id = $rubric_id;
                    $productRubric->save();
                }
            }
        }
    }

    protected function saveOtherCategories()
    {
        $categories = $this->otherCategoriesArray;

        foreach ($this->other_product_categories as $otherCategory)
            $otherCategory->delete();

        if (is_array($categories))
        {
            foreach ($categories as $other_id)
            {
                $otherCategory = new ShopProductOthercategory();
                $otherCategory->product_id = $this->id;
                $otherCategory->category_id = $other_id;
                $otherCategory->save();
            }
        }
    }

    protected function saveSizes()
    {
        $sizes = $this->sizesArray;

        foreach ($this->product_sizes as $size)
            $size->delete();

        if (is_array($sizes))
        {
            foreach ($sizes as $size_id)
            {
                $size = new ShopProductSize();
                $size->product_id = $this->id;
                $size->size_id = $size_id;
                $size->save();
            }
        }
    }

    protected function saveColors()
    {
        $colors = $this->colorsArray;

        foreach ($this->product_colors as $color)
            $color->delete();

        if (is_array($colors))
        {
            foreach ($colors as $color_id)
            {
                $size = new ShopProductColor();
                $size->product_id = $this->id;
                $size->color_id = $color_id;
                $size->save();
            }
        }
    }

    protected function saveOtherAttributes()
    {
        $attributes = $this->getOtherAttributesAssoc();

        ShopProductAttributeValue::model()->deleteAllByAttributes(array('product_id' => $this->primaryKey));

        if (is_array($attributes))
        {
            foreach ($attributes as $id=>$value)
            {
                if (ShopProductAttribute::model()->countByAttributes(array('id'=>$id))){
                    $attr = new ShopProductAttributeValue();
                    $attr->product_id = $this->primaryKey;
                    $attr->attribute_id = $id;
                    $attr->value = $value;
                    $attr->save();
                }
            }
        }
    }

    public function getOtherAttributesAssoc()
    {
        if ($this->_otherAttributes === null)
        {
            foreach ($this->getOtherAttributes($this->type_id) as $attribute)
                $this->_otherAttributes[$attribute->id] = $attribute->value;
        }

        return $this->_otherAttributes;
    }

    public function setOtherAttributesAssoc($value)
    {
        $this->_otherAttributes = array();

        foreach ($this->loadAttrFields($this->type_id) as $field)
        {
            if (isset($value[$field->id]))
                $field->value = $value[$field->id];

            $this->_otherAttributes[$field->id] = $field->value;
        }
    }

    /**
     * @param string $type
     * @return ShopProductAttribute[]
     */
    public function getOtherAttributes($type=0)
    {
        $attributes = array();
        $attrFields = $this->loadAttrFields($type);

        foreach ($attrFields as $attribute)
        {
            foreach ($this->all_attribute_values as $shop_attribute_value)
            {
                if ($shop_attribute_value->attribute_id == $attribute->id)
                    $attribute->value = $shop_attribute_value->value;
            }

            if (is_array($this->_otherAttributes)){
                foreach ($this->_otherAttributes as $key=>$value)
                {
                    if ($attribute->id == $key)
                        $attribute->value = $value;
                }
            }
            $attributes[] = $attribute;
        }

        return $attributes;
    }

    /**
     * @param int $type
     * @return ShopProductAttribute[]
     */
    protected function loadAttrFields($type=0)
    {
        return ShopProductAttribute::model()->type($type ? $type : $this->type_id)->findAll(array(
            'order' => 'sort ASC',
        ));
    }

    public function getFullTitle()
    {
        return $this->artikul . ' / ' . $this->title;
    }

    private $_firstImage;

    public function getFirstImage()
    {
        $main_product = $this->getMainProduct();

        if ($this->_firstImage === null)
        {
            $this->_firstImage = ShopImage::model()->find(array(
                'condition'=>'product_id = :id',
                'params'=>array('id'=>$main_product->id),
                'order'=>'main DESC, id ASC',
                'limit'=>1
            ));
            if ($this->_firstImage === null)
            {
                $image = new ShopImage();
                $image->product_id = $main_product->id;
                $this->_firstImage = $image;
            }
        }

        return $this->_firstImage;
    }

    private $_url;

    public function getUrl(){

        if (!$this->type || !$this->category)
            return '';

        if ($this->_url === null)
        {
            $main_product = $this->getMainProduct();
            $this->_url = Yii::app()->createUrl('/shop/product/show', array('type'=>$main_product->type->alias, 'category'=>$main_product->category->path, 'id'=>$main_product->id));
        }
        return $this->_url;
    }

    public function isMainProduct()
    {
        $main_product = $this->getMainProduct();
        return $main_product ? $this->getPrimaryKey() == $main_product->id : true;
    }

    protected function getMainProduct()
    {
        if (Yii::app()->config->get('SHOP.GROUP_BY_TITLE'))
        {
            $related_products = $this->related_products;
            $main = isset($related_products[0]) ? $related_products[0] : null;
        }
        else
            $main = $this;

        return $main ;
    }
}