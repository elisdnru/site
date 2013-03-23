<?php
/**
 * MultilingualBehavior class file
 *
 * @author guillemc, Frédéric Rocheron<frederic.rocheron@gmail.com>
 */
/**
 * MultilingualBehavior handles active record model translation.
 *
 * This behavior allow you to create multilingual models and to use them (almost) like normal models.
 * For each model, translations have to be stored in a separate table of the database (ex: PostLang or ProductLang),
 * which allow you to easily add or remove a language without modifying your database.
 * 
 * Here an example of base 'post' table :
 * <pre>
 * CREATE TABLE IF NOT EXISTS `post` (
 *   `id` int(11) NOT NULL AUTO_INCREMENT,
 *   `title` varchar(255) NOT NULL,
 *   `content` TEXT NOT NULL,
 *   `created_at` datetime NOT NULL,
 *   `updated_at` datetime NOT NULL,
 *   `enabled` tinyint(1) NOT NULL DEFAULT '1',
 *   PRIMARY KEY (`id`)
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 * </pre>
 * 
 * And his associated translation table (configured as default), assuming translated fields are 'title' and 'content':
 * <pre>
 * CREATE TABLE IF NOT EXISTS `postLang` (
 *   `l_id` int(11) NOT NULL AUTO_INCREMENT,
 *   `post_id` int(11) NOT NULL,
 *   `lang_id` varchar(6) NOT NULL,
 *   `l_title` varchar(255) NOT NULL,
 *   `l_content` TEXT NOT NULL,
 *   PRIMARY KEY (`l_id`),
 *   KEY `post_id` (`post_id`),
 *   KEY `lang_id` (`lang_id`)
 * ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
 * 
 * ALTER TABLE `postLang`
 *   ADD CONSTRAINT `postlang_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
 * </pre>
 * 
 * Attach this behavior to the model (Post in the example).
 * (Everything that is commented is default values)
 * <pre>
 * public function behaviors() {
 *     return array(
 *         'ml' => array(
 *             'class' => 'application.models.behaviors.MultilingualBehavior',
 *             //'langClassName' => 'PostLang',
 *             //'langTableName' => 'postLang',
 *             //'langForeignKey' => 'post_id',
 *             //'langField' => 'lang_id',
 *             'localizedAttributes' => array('title', 'content'), //attributes of the model to be translated
 *             //'localizedPrefix' => 'l_',
 *             'languages' => Yii::app()->params['translatedLanguages'], // array of your translated languages. Example : array('fr' => 'Français', 'en' => 'English')
 *             'defaultLanguage' => Yii::app()->params['defaultLanguage'], //your main language. Example : 'fr'
 *             //'createScenario' => 'insert',
 *             //'localizedRelation' => 'i18nPost',
 *             //'multilangRelation' => 'multilangPost',
 *             //'forceOverwrite' => false,
 *             //'forceDelete' => true, 
 *             //'dynamicLangClass' => true, //Set to true if you don't want to create a 'PostLang.php' in your models folder
 *         ),
 *     );
 * }
 * </pre>
 * 
 * In order to retrieve translated models by default, add this function in the model class:
 * <pre>
 * public function defaultScope()
 * {
 *     return $this->ml->localizedCriteria();
 * }
 * </pre>
 * 
 * You also can modify the loadModel function of your controller as guillemc suggested in a previous post :
 * <pre>
 * public function loadModel($id, $ml=false) {
 *     if ($ml) {
 *         $model = Post::model()->multilang()->findByPk((int) $id);
 *     } else {
 *         $model = Post::model()->findByPk((int) $id);
 *     }
 *     if ($model === null)
 *         throw new CHttpException(404, 'The requested post does not exist.');
 *     return $model;
 * }
 * </pre>
 * 
 * and use it like this in the update action :
 * <pre>
 * public function actionUpdate($id) {
 *     $model = $this->loadModel($id, true);
 *     ...
 * }
 * </pre>
 * 
 * Here is a very simple example for the form view : 
 * 
 * <?php foreach (Yii::app()->params['translatedLanguages'] as $l => $lang) :
 *     if($l === Yii::app()->params['defaultLanguage']) $suffix = '';
 *     else $suffix = '_'.$l;
 *     ?>
 * <fieldset>
 *     <legend><?php echo $lang; ?></legend>
 *     <div class="row">
 *     <?php echo $form->labelEx($model,'slug'); ?>
 *     <?php echo $form->textField($model,'slug'.$suffix,array('size'=>60,'maxlength'=>255)); ?>
 *     <?php echo $form->error($model,'slug'.$suffix); ?>
 *     </div>
 * 
 *     <div class="row">
 *     <?php echo $form->labelEx($model,'title'); ?>
 *     <?php echo $form->textField($model,'title'.$suffix,array('size'=>60,'maxlength'=>255)); ?>
 *     <?php echo $form->error($model,'title'.$suffix); ?>
 *     </div>
 * </fieldset>
 * 
 * <?php endforeach; ?>
 * 
 * 
 * To enable search on translated fields, you can modify the search() function in the model like this :
 * Example: $model = Post::model()->localized('fr')->findByPk((int) $id);
 * 
 * public function search()
 * {
 *     $criteria=new CDbCriteria;
 *     
 *     //...
 *     //here your criteria definition
 *     //...
 * 
 *     return new CActiveDataProvider($this, array(
 *         'criteria'=>$this->ml->modifySearchCriteria($criteria),
 *         //instead of
 *         //'criteria'=>$criteria,
 *     ));
 * }
 * 
 * Warning: the modification of the search criteria is based on a simple str_replace so it may not work properly under certain circumstances.
 * 
 * It's also possible to retrieve languages translation of two or more related models in one query.
 * Example for a Page with a "articles" HAS_MANY relation : 
 * $model = Page::model()->multilang()->with('articles', 'articles.multilangArticle')->findByPk((int) $id);
 * echo $model->articles[0]->content_en;
 * 
 * With this method it's possible to make multi model forms like it's explained here @link http://www.yiiframework.com/wiki/19/how-to-use-a-single-form-to-collect-data-for-two-or-more-models/
 * 
 * 28/03/2012:
 * It's now possible to modify language when retrieving data with the localized relation.
 * Example: $model = Post::model()->localized('en')->findByPk((int) $id);
 * 
 * 
 */
class MultilingualBehavior extends CActiveRecordBehavior
{
    /**
     * @var string the name of translation model class. Default to '[base model class name]Lang'.
     * Example: for a base model class named 'Post', the translation model class name is 'PostLang'. 
     */
	public $langClassName;
    
    /**
     * @var string the name of the translation table. Default to '[base model table name]Lang'.
     * Example: for a base model table named 'post', the translation model table name is 'postLang'. 
     */
    public $langTableName;
    
    /**
     * @var string the name of the foreign key field of the translation table related to base model table. Default to '[base model table name]_id'.
     * Example: for a base model table named post', the translation model table name is 'post_id'. 
     */
	public $langForeignKey;
    
    /**
     * @var string the name of the lang field of the translation table. Default to 'lang_id'.
     */
	public $langField = 'lang_id';
    
    /**
     * @var array the attributes of the base model to be translated
     * Example: array('title', 'content')
     */
	public $localizedAttributes;
    
    /**
     * @var string the prefix of the localized attributes in the lang table. Here to avoid collisions in queries.
     * In the translation table, the columns corresponding to the localized attributes have to be name like this: 'l_[name of the attribute]'
     * and the id column (primary key) like this : 'l_id'
     * Default to 'l_'.
     */
    public $localizedPrefix = 'l_';
    
    /**
     * @var array the languages to use.
     * It can be a simple array: array('fr', 'en')
     * or an associative array: array('fr' => 'Français', 'en' => 'English')
     *  For associatives assray, only the keys will be used.
     */
	public $languages;
    
    /**
     * @var string the default language.
     * Example: 'en'.
     */
	public $defaultLanguage;
    
    /**
     * @var string the scenario corresponding to the creation of the model. Default to 'insert'.
     */
	public $createScenario = 'insert';
    
    /**
     * @var string the name the relation that is used to get translated attributes values for the current language.
     * Default to 'multilang[base model class name]'.
     * Example: for a base model class named 'Post', the relation name is 'multilangPost'. 
     */
	public $localizedRelation;

	/**
     * @var string the name the relation that is used to all translations for all translated attributes.
     * Used to have access to all translations at once, for example when you want to display form to update a model
     * Every translation for an attribute can be accessed like this: $model->[name of the attribute]_[language code] (example: $model->title_en, $model->title_fr).
     * Default to 'i18n[base model class name]'.
     * Example: for a base model table named post', the relation name is 'i18nPost'. 
     */
    public $multilangRelation;

    /**
     * @var boolean wether to force overwrite of the default language value with translated value even if it is empty.
     * Used only for {@link localizedRelation}.
     * Default to false. 
     */
	public $forceOverwrite=false;

    /**
     * @var boolean wether to force deletion of the associated translations when a base model is deleted.
     * Not needed if using foreign key with 'on delete cascade'.
     * Default to true. 
     */
	public $forceDelete = true;
    
    /**
     * @var boolean wether to dynamically create translation model class.
     * If true, the translation model class will be generated on runtime with the use of the eval() function so no additionnal php file is needed.
     * See {@link createLangClass()}
     * Default to true. 
     */
	public $dynamicLangClass = true; 
	
	private $_langAttributes = array();
    
    private $_notDefaultLanguage = false;
	
    private function createLocalizedRelation($owner, $lang) {
        $class = CActiveRecord::HAS_MANY;
        $owner->getMetaData()->relations[$this->localizedRelation] = new $class($this->localizedRelation, $this->langClassName, $this->langForeignKey, array('on' => $this->localizedRelation . "." . $this->langField . "='" . $lang . "'", 'index' => $this->langField));
    }
            
    /**
     * Attach the behavior to the model.
     * @param model $owner 
     */
	public function attach($owner) {
		parent::attach($owner);
        $owner_classname = get_class($owner);
        $table_name_chunks = explode('.', $owner->tableName());
        $simple_table_name = str_replace(array('{{', '}}'), '', array_pop($table_name_chunks));
        
		if (!isset($this->langClassName)) {
			$this->langClassName = $owner_classname . 'Lang';
		}
        if (!isset($this->langTableName)) {
			$this->langTableName = $simple_table_name . 'Lang';
		}
        if (!isset($this->localizedRelation)) {
			$this->localizedRelation = 'i18n' . $owner_classname;
		}
        if (!isset($this->multilangRelation)) {
			$this->multilangRelation = 'multilang' . $owner_classname;
		}
		if (!isset($this->langForeignKey)) {
            $this->langForeignKey = $simple_table_name . '_id';
		}
        if ($this->dynamicLangClass) {
			$this->createLangClass();
		}
		if (array_values($this->languages) !== $this->languages) { //associative array
			$this->languages = array_keys($this->languages);
		}
        $class = CActiveRecord::HAS_MANY;
        $this->createLocalizedRelation($owner, Yii::app()->language);
		$owner->getMetaData()->relations[$this->multilangRelation] = new $class($this->multilangRelation, $this->langClassName, $this->langForeignKey, array('index' => $this->langField));
        
        $rules = $owner->rules();
        $validators = $owner->getValidatorList();
        foreach ($this->languages as $l) {
			foreach($this->localizedAttributes as $attr) {
				foreach($rules as $rule) {
					$rule_attributes = array_map('trim', explode(',', $rule[0]));
					if(in_array($attr, $rule_attributes)) {
						if ($rule[1] !== 'required' || $this->forceOverwrite) {
							$validators->add(CValidator::createValidator($rule[1], $owner, $attr . '_' . $l, array_slice($rule, 2)));
						}
						else if($rule[1] === 'required') {
							//We add a safe rule in case the attribute has only a 'required' validation rule assigned
							//and forceOverWrite == false
							$validators->add(CValidator::createValidator('safe', $owner, $attr . '_' . $l, array_slice($rule, 2)));
						}
					}
				}
			}
        }
    }
    
    /**
     * Dynamically create the translation model class with the use of the eval() function so no additionnal php file is needed. 
     * The translation model class created is a basic active record model corresponding to the translations table.
     * It include a BELONG_TO relation to the base model which allow advanced usage of the translation model like conditional find on translations to retrieve base model.
     */
    public function createLangClass() {
        if(!class_exists($this->langClassName, false)) {
            $owner_classname = get_class($this->getOwner());
            eval("class {$this->langClassName} extends CActiveRecord
            {
                public static function model(\$className=__CLASS__)
                {
                    return parent::model(\$className);
                }

                public function tableName()
                {
                    return '{{{$this->langTableName}}}';
                }
                    
                public function relations()
                {
                    return array('$owner_classname' => array(self::BELONGS_TO, '$owner_classname', '{$this->langForeignKey}'));
                }
            }");
        }
    }
	
    /**
     * 
     * @return model 
     */
    /**
     * Named scope to use {@link localizedRelation}
     * @param string $lang the lang the retrieved models will be translated (default to current application language)
     * @return model 
     */
	public function localized($lang = null) {
        $owner = $this->getOwner();
        if($lang != null && $lang != Yii::app()->language && in_array($lang, $this->languages)) {
            $this->createLocalizedRelation($owner, $lang);
            $this->_notDefaultLanguage = true;
        }
		$owner->getDbCriteria()->mergeWith(
			$this->localizedCriteria()
		);
		return $owner;
	}
    
    /**
     * Named scope to use {@link multilangRelation}
     * @return model 
     */
    public function multilang() {
        $owner = $this->getOwner();
		$owner->getDbCriteria()->mergeWith(
			$this->multilangCriteria()
		);
		return $owner;
	}
    
    /**
     * Array of criteria to use {@link localizedRelation}
     * @return array 
     */
    public function localizedCriteria() {
        return array(
            'with'=>array(
                $this->localizedRelation => array(),
            ),
        );
    }
    
    /**
     * Array of criteria to use {@link multilangRelation}
     * @return array 
     */
    public function multilangCriteria() {
        return array(
            'with'=>array(
                $this->multilangRelation => array(),
            ),
        );
    }
    
    /**
     * Wether the attribute exists
     * @param string $name the name of the attribute
     * @return boolean 
     */
	public function hasLangAttribute($name) {
        return array_key_exists($name, $this->_langAttributes);
	}

    /**
     * @param string $name the name of the attribute
     * @return string the attribute value 
     */
	public function getLangAttribute($name) {
		return $this->hasLangAttribute($name) ? $this->_langAttributes[$name] : null;
	}

    /**
     * @param string $name the name of the attribute
     * @param string $value the value of the attribute
     */
	public function setLangAttribute($name, $value) {
		$this->_langAttributes[$name] = $value;
	}

    /**
     * @param CEvent $event 
     */
	public function afterConstruct($event) {
		$owner = $this->getOwner();
		if ($owner->scenario==$this->createScenario) {
			$owner = new $this->langClassName;
			foreach ($this->languages as $lang) {
				foreach ($this->localizedAttributes as $field) {
                    $ownerfield = $this->localizedPrefix . $field;
					$this->setLangAttribute($field. '_' . $lang, $owner->$ownerfield);
                }
            }
		}
	}

    /**
     * Modify passed criteria by replacing conditions on base attributes with conditions on translations.
     * Allow to make search on model translated values.
     * @param CDbCriteria $event 
     */
    public function modifySearchCriteria(CDbCriteria $criteria) {
        $owner = $this->getOwner();
        $criteria_array = $criteria->toArray();
        foreach($this->localizedAttributes as $attribute) {
            if(!empty($owner->$attribute)) {
                $criteria_array['condition'] = str_replace($attribute . ' ', $this->localizedPrefix . $attribute . ' ', $criteria_array['condition']);
            }
        }
        $criteria_array['together'] = true;
        $criteria = new CDbCriteria($criteria_array);
        return $criteria;
    }
    
    /**
     * @param CEvent $event 
     */
	public function afterFind($event) {
		$owner = $this->getOwner();
        if ($owner->hasRelated($this->multilangRelation)) {
			$related = $owner->getRelated($this->multilangRelation);
			foreach ($this->languages as $lang)
				foreach ($this->localizedAttributes as $field)
					$this->setLangAttribute($field. '_' . $lang, isset($related[$lang][$this->localizedPrefix . $field]) ? $related[$lang][$this->localizedPrefix . $field] : null);
		} else if ($owner->hasRelated($this->localizedRelation)) {
			$related = $owner->getRelated($this->localizedRelation);
			if ($row = current($related)) {
				foreach ($this->localizedAttributes as $field)
					if (isset($owner->$field) && (!empty($row[$this->localizedPrefix . $field]) || $this->forceOverwrite)) $owner->$field = $row[$this->localizedPrefix . $field];
			}
            if($this->_notDefaultLanguage) {
                $this->createLocalizedRelation($owner, Yii::app()->language);
                $this->_notDefaultLanguage = false;
            }
		}
        
	}

    /**
     * @param CModelEvent $event 
     */
	public function afterSave($event) {
		$main_owner = $this->getOwner();
		$ownerPk = $main_owner->getPrimaryKey();
		$rs = array();
		if (!$main_owner->isNewRecord) {
			$model = call_user_func(array($this->langClassName, 'model'));
			$c = new CdbCriteria();
			$c->condition = "{$this->langForeignKey}=:id";
			$c->params = array('id'=>$ownerPk);
			$c->index = $this->langField;
			$rs = $model->findAll($c);              
		}
		foreach ($this->languages as $lang) {
            $defaultLanguage = $lang == $this->defaultLanguage;
			if (!isset($rs[$lang])) {
				$owner = new $this->langClassName;          
				$owner->{$this->langField} = $lang;
				$owner->{$this->langForeignKey} = $ownerPk;          
			} else {
				$owner = $rs[$lang];
			}
			foreach ($this->localizedAttributes as $field) {
                if($defaultLanguage) {
                    $value = $main_owner->$field;
                } else {
                    $value = $this->getLangAttribute($field . '_'.$lang);
                }
                if($value !== null) {
                    $langfield = $this->localizedPrefix . $field;
                    $owner->$langfield = $value;
                }
			}
			$owner->save(false);
		}
	}
    
    /**
     * @param CEvent $event 
     */
	public function afterDelete($event) {
		if ($this->forceDelete) {
			$ownerPk = $this->getOwner()->getPrimaryKey();
			$model = call_user_func(array($this->langClassName, 'model'));
			$model->deleteAll("{$this->langForeignKey}=:id", array('id'=>$ownerPk));
		}
	}
	
	public function __get($name) {
		try { return parent::__get($name); } 
		catch (CException $e) {
			if ($this->hasLangAttribute($name)) return $this->getLangAttribute($name);
			else throw $e;
		}                                                     
	}

	public function __set($name, $value) {
		try { parent::__set($name, $value); } 
		catch (CException $e) {
			if ($this->hasLangAttribute($name)) $this->setLangAttribute($name, $value);
			else throw $e;
		}                                     
	}
	
	public function __isset($name){
		if (! parent::__isset($name)) {
			return ($this->hasLangAttribute($name));
		} else {
			return true;
		}
	}

	public function canGetProperty($name)
	{
		return parent::canGetProperty($name) or $this->hasLangAttribute($name);
	}
	
	public function canSetProperty($name)
	{
		return parent::canSetProperty($name) or $this->hasLangAttribute($name);
	}
	
	public function hasProperty($name)
	{
		return parent::hasProperty($name) or $this->hasLangAttribute($name);
	}
}