<?php

namespace app\components\extended;

use Yii;

class Model extends \yii\base\Model
{
    public $i18n;
    
    public function init()
    {   
        $this->i18n = Yii::$app->i18n;
    }
}
