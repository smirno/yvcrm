<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;

use app\components\extended\Controller;
use app\models\ContactsPage;

class ContactsController extends Controller
{

    public $defaultAction = 'contacts';
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
                    'contacts' => ['get'],
                    'filters' => ['get'],
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

    public function actionFilters()
    {
        if (!$this->isAjax()) {
            return $this->renderApp();
        }

        $page = new ContactsPage;
        $filters = $page->getFilters();

        if ($filters) {
            return $this->renderJson(true, $filters);
        } else {
            return $this->renderJson(false, [
                'message' => 'Фильтры не найдены!'
            ]);
        }
    }

    public function actionContacts()
    {
        if (!$this->isAjax()) {
            return $this->renderApp();
        }

        $page = new ContactsPage;

        $filters = [
            'status' => $this->request->get('status'),
            'search' => $this->request->get('search')
        ];

        $contacts = $page->getContacts($filters);

        if ($contacts) {
            $list = [];
            foreach ($contacts as $contact) {
                $list[] = [
                    'id' => $contact->id,
                    'url' => '/contacts/' . $contact->id,
                    'fullname' => $contact->fullname,
                    'leads' => count($contact->leads)
                ];
            }

            Yii::debug($list);

            return $this->renderJson(true, $list);
        } else {
            return $this->renderJson(false, [
                'message' => 'Ни чего не найдено!'
            ]);
        }

    }
}
