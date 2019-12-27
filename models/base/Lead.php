<?php

namespace app\models\base;

use Yii;
use yii\db\ActiveRecord;

use app\models\base\Contact;
use app\models\base\Field;
use app\models\base\Value;

class Lead extends ActiveRecord
{
    const STATUS = [
        'inactive' => 0,
        'active' => 1
    ];

    private $_context = Field::CONTEXT['lead'];

    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS['active']],
            ['status', 'in', 'range' => self::STATUS],
        ];
    }

    public static function getList()
    {
        return self::find()->where([
            'contact.status' => Contact::STATUS['active'],
        ])->joinWith(['contact'], true, 'LEFT JOIN')->all();
    }

    public function getContext()
    {
        return $this->_context;
    }

    public function getContact()
    {
        return $this->hasOne(Contact::className(), ['id' => 'contact_id']);
    }

    public function getFields()
    {
        return $this->hasMany(Field::className(), ['context' => 'context']);
    }

    public function getValues()
    {
        return $this->hasMany(Value::className(), ['essence_id' => 'id']);
    }
}