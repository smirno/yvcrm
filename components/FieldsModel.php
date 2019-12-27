<?php

namespace app\components;

use Yii;
use yii\helpers\ArrayHelper;

use app\models\base\Field;
use app\models\base\Value;

class FieldsModel extends \yii\base\DynamicModel
{
    private $_essence;
    private $_labels = [];
    private $_types = [];
    private $_context = [];

    public function __construct($essence, $config = [])
    {   
        $this->_essence = $essence;
        $attributes = [];

        foreach ($essence->fields as $field) {

            $attribute = Field::PREFIX . $field->id;

            if ($attribute) {
                $attributes[$attribute] = $field->default;
                $this->_labels[$attribute] = $field->label;
                $this->_types[$attribute] = $field->type;

                $this->addContext($essence, $attribute);
            }

        }

        foreach ($essence->values as $value) {

            $attribute = Field::PREFIX . $value->field;

            if (ArrayHelper::keyExists($attribute, $attributes)) {
                $attributes[$attribute] = $value->value;
            }

        }

        parent::__construct($attributes, $config);
    }

    public function addAttribute($essence, $name, $type = null, $label = null)
    {   
        if ($essence && $name) {
            if (is_object($essence)) {

                if ($type != null) {
                    $this->_types[$name] = $type;
                }
                
                if ($label != null) {
                    $this->_labels[$name] = $label;
                }

                $value = $essence->{$name} ? $essence->{$name} : '';
                $this->addContext($essence, $name);
                
                return parent::defineAttribute($name, $value);
            }
        }
    }

    public function attributeLabels()
    {
        return $this->_labels;
    }

    public function attributeTypes()
    {
        return $this->_types;
    }

    public function getAttributeType($attribute)
    {
        $types = $this->attributeTypes();
        return isset($types[$attribute]) ? $types[$attribute] : 'text';
    }

    public function getFields()
    {
        $fields = [];

        foreach ($this->attributes as $key => $attribute) {
            $fields[$key] = [
                'id' => $key,
                'type' => $this->getAttributeType($key), 
                'label' => $this->getAttributeLabel($key), 
                'value' => $attribute
            ];
        }

        return $fields;
    }

    public function addContext($essence, $attribute)
    {
        $this->_context[$attribute] = $essence->context;
    }

    public function getContext()
    {
        return $this->_context;
    }

    public function getEssence()
    {
        return $this->_essence;
    }

    public function save()
    {
        if ($this->validate()) {

            $essence = $this->essence;
            $changed = false;

            $fields = ArrayHelper::index($essence->fields, 'id');
            $values = ArrayHelper::index($essence->values, 'field');

            foreach ($this->attributes as $attribute => $value) {
                // if ($value) {
                    if ($essence->context == $this->context[$attribute]) {
                        if ($attribute[0] == Field::PREFIX) {

                            $field = substr($attribute, 1);

                            if (ArrayHelper::keyExists($field, $fields)) {

                                if (ArrayHelper::keyExists($field, $values)) {
                                    $current = $values[$field];
                                } else {
                                    $current = new Value;
                                    $current->essence = $essence->id;
                                    $current->field = $field;
                                }

                                $current->value = $value;

                                if (count($current->getDirtyAttributes())) {
                                    $changed = $current->save();
                                }

                            }

                        }
                    }
                // }
            }

            return $changed;

        }

        return false;
    }
}
