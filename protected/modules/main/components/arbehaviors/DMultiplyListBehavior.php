<?php
/**
 * DMultiplyListBehavior
 * Adds new property into model for getting related list as array of primary keys.
 * It can be helpful for working with CHtml::activeCheckBoxList() and multiple CHtml::activeDropDownList().
 *
 * You can use property $model->categoriesArray for example.
 *
 * <pre>
 * class Post extends CActiveRecord
 * {
 *     public function rules()
 *     {
 *         return array(
 *             array('categoriesArray', 'safe'),
 *         );
 *     }
 *
 *     public function relations()
 *     {
 *         return array(
 *             'categories'=>array(self::MANY_MANY, 'Category', '{{post_category}}(post_id, category_id)'),
 *         ),
 *     );
 *
 *     public function behaviors()
 *     {
 *         return array(
 *             'DMultiplyListBehavior'=>array(
 *                  'class'=>'DMultiplyListBehavior',
 *                  'attribute'=>'categoriesArray',
 *                  'relation'=>'categories',
 *                  'relationPk'=>'id',
 *             ),
 *         );
 *     }
 *
 *     // Process new array there if needle
 *     protected function afterSave()
 *     {
 *         foreach ($this->categoriesArray as $id)
 *         {
 *             // ...
 *         }
 *         parent::afterSave();
 *     }
 * }
 * </pre>
 *
 * Property $model->categoriesArray returns array of related PKs like Array(5, 12, 18, ...).
 * You can use this property as field in your forms:
 *
 * <pre>
 * <?php $items = CHtml::listData(Category::model()->findAll(), 'id', 'name'); ?>
 * <?php echo $form->checkBoxList($model, 'categoriesArray', $items); ?>
 * </pre>
 *
 * and manually process new values in Post::afterSave() method
 * or process in your controller after line $model->attributes=$_POST['Post'].
 *
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */

class DMultiplyListBehavior extends CActiveRecordBehavior
{
    /**
     * @var string public property name
     */
    public $attribute;
    /**
     * @var string MANY_MANY relation name
     */
    public $relation;
    /**
     * @var string primary key name of related model
     */
    public $relationPk = 'id';

    protected $value;

	public function canGetProperty($name)
    {
        return $this->validProperty($name);
    }

    public function canSetProperty($name)
    {
        return $this->validProperty($name);
    }

    public function __get($name)
    {
        if (!$this->validProperty($name))
            return null;

        if ($this->value === null)
            $this->value = CHtml::listData($this->getOwner()->{$this->relation}, $this->relationPk, $this->relationPk);

        return $this->value;
    }

    public function __set($name, $value)
    {
        if ($this->validProperty($name))
            $this->value = $value;
    }

    protected function validProperty($name)
    {
        if (empty($this->attribute))
            throw new CException(__CLASS__ . '::attribute is empty');
        if (empty($this->relation))
            throw new CException(__CLASS__ . '::relation is empty');
        if (empty($this->relationPk))
            throw new CException(__CLASS__ . '::relationPk is empty');

        return $name == $this->attribute;
    }
}