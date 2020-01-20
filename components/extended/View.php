<?php

namespace app\components\extended;

use Yii;

class View extends \yii\web\View
{
	public $request;
	
	public function init()
    {   
        $this->request = Yii::$app->request;
    }

    public function snippet($snippet, array $params = [])
    {
        return parent::renderFile('@app/views/snippets/' . $snippet . '.php', $params);
    }
}
