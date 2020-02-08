<?php

namespace app\components\extended;

use Yii;
use yii\helpers\Json;

class Controller extends \yii\web\Controller
{
    public $request;
    public $response;
    public $i18n;

    /**
     * {@inheritdoc}
     */
    public function init()
    {   
        $this->request = Yii::$app->request;
        $this->response = Yii::$app->response;
        $this->i18n = Yii::$app->i18n;

        $this->request->csrfParam = 'csrf';
    }

    /**
     * Отрисовать каркас фронтенд приложения
     * 
     * @param array $render входные данные
     * @return string
     */
    public function renderApp(array $render = [])
    {
        $render['csfr'] = $this->request->getCsrfToken();
        $render['translation'] = $this->i18n->getTranslation();
        $render['filters'] = $this->i18n->getTranslation();

        return $this->render('/app/app', ['render' => Json::encode($render)]);
    }

    /**
     * Отправить JSON данные пользователю
     * 
     * @param int $status статус запроса
     * @param array $data массив данных
     * @return array
     */
    public function renderJson(int $status, array $data = [])
    {
        $this->response->format = $this->response::FORMAT_JSON;

        $response = [
            'csrf' => $this->request->csrfToken,
            'status' => $status,
            'data' => $data
        ];

        return $response;
    }

    /**
     * Получить метод запроса
     * 
     * @return string метод
     */
    public function getMethod()
    {
        return $this->request->method;
    }

    /**
     * Получить данные запроса
     * 
     * @return array|false
     */
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

    /**
     * Проверяет AJAX запрос или нет
     * 
     * @return bool
     */
    public function isAjax()
    {
        return $this->request->isAjax;
    }
}
