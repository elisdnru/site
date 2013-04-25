<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 * @version 1.0
 */

Yii::import('application.modules.attribute.models.UserAttribute');

class DAttributeHelper
{
    protected static $_attributes = array();

    /**
     * @param string $class
     * @return array
     */
    public static function attributeLabels($class)
    {
        $attrs = self::attributes($class);

        $attributes = array();
        foreach ($attrs as $attr)
            $attributes[$attr->name] = $attr->label;

        return $attributes;
    }

    /**
     * @param string $class
     * @return array
     */
    public static function attributeNames($class)
    {
        $attrs = self::attributes($class);

        $names = array();
        foreach ($attrs as $attr)
            $names[] = $attr->name;

        return $names;
    }

    /**
     * @param string $class
     * @return array
     */
    public static function rules($class)
    {
        $attrs = self::attributes($class);

        $rules = array();
        foreach ($attrs as $attr)
        {
            if (strpos($attr->rule, '|') === 0)
                $rules[] = array($attr->name, 'match', 'pattern'=>$attr->rule, 'message'=>'Неверный формат поля {attribute}');
            else
                $rules[] = array($attr->name, $attr->rule);

            if ($attr->required)
                $rules[] = array($attr->name, 'required');
        }

        return $rules;
    }

    /**
     * @param string $class
     * @return UserAttribute[]
     */
    public static function attributes($class)
    {
        if (!isset(self::$_attributes[$class]))
            self::$_attributes[$class] = UserAttribute::model()->cache(3600)->findAll(array(
                'condition'=>'class = :class',
                'params'=>array(':class'=>$class),
                'order'=>'sort',
            ));

        return self::$_attributes[$class];
    }
}
