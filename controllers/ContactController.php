<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

use app\components\extended\Controller;
use app\models\base\Contact;
use app\models\ContactPage;

class ContactController extends Controller
{

    public $defaultAction = 'contact';
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
                    'contact' => ['get', 'post', 'put'],
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

    public function actionContact($id)
    {
        if ($this->isAjax()) {

            if ($id != 'create') {
                $contact = Contact::findOne($id);
            } else {
                $contact = new Contact;
            }

            if ($contact) {

                $page = new ContactPage($contact);

                switch ($this->method) {
                    case 'GET':

                        // sleep(1);
                        $return = $page->fields;

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
