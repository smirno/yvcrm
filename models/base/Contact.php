<?php

namespace app\models\base;

use Yii;
use yii\db\ActiveRecord;

use app\models\base\Lead;
use app\models\base\Field;
use app\models\base\Value;

class Contact extends ActiveRecord
{
    const STATUS = [
        'inactive' => 0,
        'active' => 1
    ];

    private $_context = Field::CONTEXT['contact'];

    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS['active']],
            ['status', 'in', 'range' => self::STATUS],
            ['firstname', 'default', 'value' => ''],
            ['lastname', 'default', 'value' => ''],
        ];
    }
    
    public static function getList(array $filters = [])
    {
        $leads = self::find();

        if (count($filters)) {
            foreach ($filters as $filter) {
                $leads->where($filter);
            }
        }

        return $leads->joinWith(['leads'], true, 'LEFT JOIN')->all();

        // return self::find()->where([
        //     'contact.status' => self::STATUS['active']
        // ])->leftJoin(['lead'], 'contact.id = lead.contact_id')->all();
    }

    public function getFullName()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getContext()
    {
        return $this->_context;
    }

    public function getLeads()
    {
        return $this->hasMany(Lead::className(), ['contact_id' => 'id']);
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