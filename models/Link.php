<?php

namespace app\models;

use app\helpers\StringHelper;
use yii\db\ActiveRecord;
use yii\helpers\Url;

class Link extends ActiveRecord
{
	const SCENARIO_CREATE = 'create';

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['url'], 'required'],
			[['code', 'url'], 'string'],
			[['url'], 'url'],
			[['counter'], 'integer'],
			[['counter'], 'default', 'value' => 0],
		];
	}


	// /**
	//  * @inheritdoc
	//  */
	// public static function primaryKey()
	// {
	//     return ['code'];
	// }


	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'counter' => 'Количество переходов',
			'code'    => 'Код сокращения',
			'url'     => 'Исходная ссылка',
		];
	}


	/**
	 * @inheritdoc
	 */
	public function scenarios()
	{
		return [
			self::SCENARIO_CREATE => ['url'],
			self::SCENARIO_DEFAULT => ['code'],
		];
	}


	/**
	 * @inheritdoc
	 */
	public function fields()
	{
		switch ($this->scenario) {
			case Link::SCENARIO_CREATE:
				return ['code'];
			default:
				return ['url', 'counter'];
		}
	}


	/**
	 * @inheritdoc
	 */
	public function __toString()
	{
		return $this->url;
	}


	/**
	 * @inheritdoc
	 */
	public function beforeSave($insert)
	{
		if ($insert) {
			// Получаем последний идентификатор
			$id = (int)Link::find()->orderBy(['id' => SORT_DESC])->limit(1)->select('id')->scalar();

			// Преобразуем идентификатор в строковое представление
			$this->code = StringHelper::convertToString($id + 1);
		}
		return parent::beforeSave($insert);
	}
}
