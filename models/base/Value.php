<?php

namespace app\models\base;

use Yii;
use yii\db\ActiveRecord;

class Value extends ActiveRecord
{
    public function getField()
    {
        return $this->field_id;
    }

    public function setField($field)
    {
        return $this->field_id = $field;
    }

    public function getEssence()
    {
        return $this->essence_id;
    }

    public function setEssence($essence)
    {
        return $this->essence_id = $essence;
    }
}