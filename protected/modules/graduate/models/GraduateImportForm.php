<?php

class GraduateImportForm extends CFormModel
{
	public $list;
	public $grade_id;

	public function rules()
	{
		return array(
			array('list, grade_id', 'required'),
			array('grade_id', 'DExistOrEmpty', 'className' => 'application.modules.graduate.models.GraduateGrade', 'attributeName' => 'id'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'list'=>'Список выпускников',
			'grade_id'=>'Класс',
		);
	}

	public function getListLines()
	{
		return preg_split('/\r?\n/', trim($this->list));
	}
}