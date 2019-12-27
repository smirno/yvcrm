<?php

namespace app\models\base;

use Yii;
use yii\db\ActiveRecord;

use app\models\base\Value;

class Field extends ActiveRecord
{
    const PREFIX = 'F';
    const CONTEXT = [
        'contact' => 1,
        'lead' 	=> 2
    ];
    const TYPE = [
        'text' => 1,
        'select' => 2
    ];

    public function getType()
    {
    	$types = array_flip(self::TYPE);
        return $types[$this->type_id];
    }
}