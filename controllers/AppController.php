<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\filters\AjaxFilter;

use app\components\extended\Controller;

class AppController extends Controller
{

    public $defaultAction = 'app';
    public $layout = 'app';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'translation' => ['get'],
                    'app' => ['get'],
                ],
            ],
            'ajax' => [
                'class' => AjaxFilter::className(),
                'only' => ['translation'],
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function actionApp() {
        return $this->renderApp();
    }
}
