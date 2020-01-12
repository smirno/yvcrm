<?php

namespace app\components\extended;

use Yii;

class Model extends \yii\base\Model
{
	public $translation;
	
    public function init()
    {   
        $this->translation = Yii::$app->translation;
    }
}
