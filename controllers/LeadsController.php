<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;

use app\components\extended\Controller;
use app\models\base\Lead;

class LeadsController extends Controller
{

    public $defaultAction = 'leads';
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
                    'leads' => ['get'],
                ],
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

    public function actionLeads()
    {
        if (!$this->isAjax()) {
            return $this->renderApp();
        }

        $leads = Lead::getList();

        // sleep(1);
        
        if ($leads) {
            $list = [];
            foreach ($leads as $lead) {
                $list[] = [
                    'id' => $lead->id,
                    'url' => '/leads/' . $lead->id,
                    'name' => $lead->name,
                    'contact' => $lead->contact->fullname
                ];
            }

            return $this->renderJson(true, $list);
        }

    }
}
