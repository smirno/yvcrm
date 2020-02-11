<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

use app\components\extended\Controller;
use app\models\base\Lead;
use app\models\LeadPage;

class LeadController extends Controller
{

    public $defaultAction = 'lead';
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
                    'lead' => ['get', 'post', 'put'],
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

    public function actionLead($id)
    {
        if ($this->isAjax()) {

            if ($id != 'create') {
                $lead = Lead::findOne($id);
            } else {
                $lead = new Lead;
            }

            if ($lead) {

                $page = new LeadPage($lead);

                switch ($this->method) {
                    case 'GET':

                        // sleep(1);
                        $return = [
                            'lead' => $page->lead,
                            'fields' => $page->fields
                        ];

                        break;

                    case 'PUT':

                        $page->setAttributes($this->data, false);
                        $return = $page->save();

                        break;
                }

                return $this->renderJson(true, $return);

            } else {
                return $this->renderJson(false);
            }
        }
        
        return $this->renderApp();
    }
}
