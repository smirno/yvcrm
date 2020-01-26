<?php

namespace app\components\extended;

use Yii;
use yii\helpers\Json;

class Controller extends \yii\web\Controller
{

    public $request;
    public $response;
    public $i18n;

    public function init()
    {   
        $this->request = Yii::$app->request;
        $this->response = Yii::$app->response;
        $this->i18n = Yii::$app->i18n;

        $this->request->csrfParam = 'csrf';
    }

    public function render($view, $params = [])
    {
        if ($this != null) {
            if ($this->id != 'default') {
                $view = '@app/views/templates/' . $this->id . DIRECTORY_SEPARATOR . $view;
            }
            return parent::render($view, $params);
        }
    }

    public function renderApp($render = 'false')
    {
        return parent::render('@app/views/templates/app/app', ['render' => $render]);
    }

    public function renderJson($status, $data)
    {
        $this->response->format = $this->response::FORMAT_JSON;

        $response = [
            'csrf' => $this->request->csrfToken,
            'status' => $status,
            'data' => $data
        ];

        return $response;
    }

    public function getMethod()
    {
        return $this->request->method;
    }

    public function getData()
    {
        $request = $this->request->getRawBody();

        if ($request) {
            $request = Json::decode($request);
            if (!empty($request)) {
                return $request;
            }
        }
        
        return false;
    }

    public function isAjax()
    {
        return $this->request->isAjax;
    }
}
