<?php

namespace app\components\extended;

use Yii;
use yii\helpers\Json;

use app\components\Translation;

class Controller extends \yii\web\Controller
{

    public $request;
    public $response;
    public $translation;

    public function init()
    {   
        $this->request = Yii::$app->request;
        $this->response = Yii::$app->response;
        $this->translation = Yii::$app->translation;

        $this->request->csrfParam = 'csrf';
    }

    public function render($view, $params = [])
    {
        if ($this != null) {
            if ($this->id != 'default') {
                $view = '@app/views/templates/' . $this->id . DIRECTORY_SEPARATOR . $view;
            }
            return parent::render($view, $params);
        } else {
            throw new InvalidCallException("Unable to resolve view file for view '$view': no active view context.");
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
            'lang' => $this->translation->get('app.test.test', 'Hello, {username}!', ['username' => 'test']),
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
            if (!empty($request['data'])) {
                return $request['data'];
            }
        }
        
        return false;
    }

    public function isAjax()
    {
        return $this->request->isAjax;
    }
}
