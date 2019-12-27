<?php

namespace app\components\extended;

use Yii;

class View extends \yii\web\View
{
    public function snippet($snippet, array $params = [])
    {
        return parent::renderFile('@app/views/snippets/' . $snippet . '.php', $params);
    }

    public function getRequest()
    {
        return Yii::$app->request;
    }
}
