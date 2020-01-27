<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\filters\AjaxFilter;

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
            ],
            'ajax' => [
                'class' => AjaxFilter::className(),
                'only' => ['filters'],
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
        $page = new ContactsPage;
        $filters = $page->getFilters();

        if ($filters) {
            return $this->renderJson(true, [
                'filters' => $filters
            ]);
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

        Yii::debug($contacts);

        if ($contacts) {
            $items = [];
            foreach ($contacts as $contact) {
                $items[$contact->id] = [
                    'id' => $contact->id,
                    'url' => '/contacts/' . $contact->id,
                    'fullname' => $contact->fullname,
                    'leads' => count($contact->leads)
                ];
            }

            return $this->renderJson(true, [
                'contacts' => $items
            ]);
        } else {
            return $this->renderJson(false, [
                'message' => $this->i18n->get('Contacts not found!')
            ]);
        }

    }
}
