<?php

Yii::import('application.modules.shop.components.IShopItem');

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
			array('rubrika_id', 'numerical', 'integerOnly'=>true),
			array('artikul', 'length', 'max'=>128),
            array('artikul', 'unique', 'caseSensitive' => false, 'className' => 'ShopProduct', 'message' => 'Такой {attribute} уже используется'),
			array('title, pagetitle, keywords', 'length', 'max'=>255),
			array('title, short, text, description', 'safe'),
			array('colorsArray', 'safe'),
			array('sizesArray', 'safe'),
			array('otherCategoriesArray', 'safe'),
			array('otherAttributesAssoc', 'safe'),

			array('id, artikul, type_id, category_id, title, pagetitle, description, keywords, text, price, count, priority, public, popular, inhome, rating, rating_count, rating_summ, size', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'type' => array(self::BELONGS_TO, 'ShopType', 'type_id'),
            'category' => array(self::BELONGS_TO, 'ShopCategory', 'category_id'),
            'brand' => array(self::BELONGS_TO, 'ShopBrand', 'brand_id'),
            'images' => array(self::HAS_MANY, 'ShopImage', 'product_id',
                'order'=>'images.main DESC, images.id ASC'
            ),
            'models' => array(self::HAS_MANY, 'ShopModel', 'product_id',
                'order'=>'models.title ASC'
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
            'rubrika_id' => 'Категория рубрикатора',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($pageSize=10)
	{
		$criteria=new CDbCriteria;

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
        $criteria->compare('t.public',$this->public);
        $criteria->compare('t.popular',$this->popular);
        $criteria->compare('t.inhome',$this->inhome);
        $criteria->compare('t.sale',$this->sale);
        $criteria->compare('t.rating',$this->rating);
        $criteria->compare('t.rating_count',$this->rating_count);
        $criteria->compare('t.rating_summ',$this->rating_summ);
        //$criteria->compare('t.type_id',$this->type_id);

        $searchCategories = array();

        if ($this->type_id && !$this->category_id)
        {
            $categoriesArray = CHtml::listData(ShopCategory::model()->type($this->type_id)->findAll(), 'id', 'id');
            $searchCategories = array_merge($searchCategories, array_keys($categoriesArray));
        }

        if ($this->category_id)
        {
            $searchCategories = array_merge($searchCategories, array($this->category_id));
        }

        if (count($searchCategories))
        {
            $categoryIds = array();

            foreach ($searchCategories as $categoryId)
            {
                $category = ShopCategory::model()->findByPk($categoryId);
                $categoryIds = array_merge($categoryIds, array($category->id) + $category->getChildsArray());
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
            $sizeProductIds = CHtml::listData(ShopProductSize::model()->with('size')->findAll('size.alias = :size', array('size'=>$this->size)), 'product_id', 'product_id');
            $criteria->addInCondition('t.id', array_unique($sizeProductIds));
        }

        if ($this->color)
        {
            $colorProductIds = CHtml::listData(ShopProductColor::model()->with('color')->findAll('color.alias = :color', array('color'=>$this->color)), 'product_id', 'product_id');
            $criteria->addInCondition('t.id', array_unique($colorProductIds));
        }

        $criteria->with = array('type', 'category');

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
        return array(
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
                'class'=>'ShopItemBehavior',
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
        );
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

    protected function saveOtherCategories()
    {
        foreach ($this->other_product_categories as $otherCategory)
            $otherCategory->delete();

        if (is_array($this->otherCategoriesArray))
        {
            foreach ($this->otherCategoriesArray as $other_id)
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
        foreach ($this->product_sizes as $size)
            $size->delete();

        if (is_array($this->sizesArray))
        {
            foreach ($this->sizesArray as $size_id)
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
        foreach ($this->product_colors as $color)
            $color->delete();

        if (is_array($this->colorsArray))
        {
            foreach ($this->colorsArray as $color_id)
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
        ShopProductAttributeValue::model()->deleteAllByAttributes(array('product_id' => $this->id));

        if ($this->_otherAttributes !== null)
        {
            foreach ($this->_otherAttributes as $attribute)
            {
                $attr = new ShopProductAttributeValue();
                $attr->product_id = $this->id;
                $attr->attribute_id = $attribute->id;
                $attr->value = $attribute->value;
                $attr->save();
            }
        }
    }

    /**
     * @param string $type
     * @return ShopProductAttribute[]
     */
    public function getOtherAttributes($type='')
    {
        if ($this->_otherAttributes === null)
        {
            $attrFields = $this->loadAttrFields($type);

            $attributes = array();
            foreach ($attrFields as $attribute)
            {
                foreach ($this->all_attribute_values as $shop_attribute_value)
                {
                    if ($shop_attribute_value->attribute_id == $attribute->id)
                        $attribute->value = $shop_attribute_value->value;
                }
                $attributes[] = $attribute;
            }

            $this->_otherAttributes = $attributes;
        }

        return $this->_otherAttributes;
    }

    public function getOtherAttributesAssoc()
    {
        $attributes = array();
        foreach ($this->getOtherAttributes() as $attribute)
        {
            $attributes[$attribute->alias] = $attribute->value;
        }

        return $attributes;
    }

    public function setOtherAttributesAssoc($value)
    {
        $attrFields = $this->loadAttrFields();

        $attributes = array();
        foreach ($attrFields as $field)
        {
            if (isset($value[$field->alias]))
                $field->value = $value[$field->alias];

            $attributes[] = $field;
        }

        $this->_otherAttributes = $attributes;
    }

    private $_attrFields;

    /**
     * @param int $type
     * @return ShopProductAttribute[]
     */
    protected function loadAttrFields($type=0)
    {
        if ($this->_attrFields === null)
        {
            $this->_attrFields = ShopProductAttribute::model()->type($type ? $type : $this->type_id)->findAll(array(
                'order' => 'sort ASC',
            ));
        }

        return $this->_attrFields;
    }

    private $_firstImage;

    public function getFirstImage()
    {
        if ($this->_firstImage === null)
        {
            $this->_firstImage = ShopImage::model()->find(array(
                'condition'=>'product_id = :id',
                'params'=>array('id'=>$this->id),
                'order'=>'main DESC, id ASC',
                'limit'=>1
            ));
            if ($this->_firstImage === null)
            {
                $image = new ShopImage();
                $image->product_id = $this->id;
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
            $this->_url = Yii::app()->createUrl('/shop/product/show', array('type'=>$this->type->alias, 'category'=>$this->category->path, 'id'=>$this->id));
        return $this->_url;
    }
}