<?php

namespace app\api\v1\controllers;

use Yii;
use app\models\Link;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

class LinkController extends \yii\rest\ActiveController
{
	public $modelClass = Link::class;
	public $createScenario = Link::SCENARIO_CREATE;


	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		$actions = parent::actions();
		unset($actions['view'], $actions['create']);
		return $actions;
	}


	/**
	 * создание короткой ссылки
	 *
	 * @param string $url
	 * ```
	 * 	{
	 * 		"url": "https://ссылка-которую.нужно/сократить"
	 * 	}
	 * ```
	 * 
	 * @return array Возвращает сокращенную ссылку
	 * ```
	 *	{
	 *	 	"link": "https://example.com/jkL98"
	 *	}
	 * ```
	 */
	public function actionCreate()
	{
		$model = new Link(['scenario' => Link::SCENARIO_CREATE]);

		$model->url = Yii::$app->request->getBodyParam('url', '');

		if ($model->validate()) {
			$model->save();
			return [
				'link' => Url::to(['/site/view', 'code' => $model->code], true)
			];
		}
		return $model;
	}


	/**
	 * Получаем свединия о сокращенной ссылке
	 *
	 * @param string $code Код ссылки
	 *
	 * @return array Возвращает исходную ссылку и колличество переходов по ней
	 * ```
	 * 	{
	 * 		"url": "https://ссылка-которую.нужно/сократить",
	 * 		"counter": "0"
	 * 	}
	 * ```
	 */
	public function actionView($code)
	{
		$model = Link::findOne(['code' => $code]);
		if (!$model) {
			throw new NotFoundHttpException('Not found link: "' . $code . '"');
		}
		return $model;
	}
}
