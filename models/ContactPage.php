<?php

namespace app\models;

use Yii;

use app\components\FieldsModel;
use app\models\base\Contact;

class ContactPage extends FieldsModel
{

    public function __construct($contact, $config = [])
    {
        $this->addAttribute($contact, 'firstname', 'text', 'Имя');
        $this->addAttribute($contact, 'lastname', 'text', 'Фамилия');

        parent::__construct($contact, $config);
    }

    public function save()
    {
        if ($this->validate()) {

            $contact = $this->essence;

            foreach ($this->attributes as $attribute => $value) {
                if (in_array($attribute, ['firstname', 'lastname'])) {
                    $contact->setAttribute($attribute, $value);
                }
            }

            if (count($contact->getDirtyAttributes())) {
                $save = $contact->save();
            } else {
                $save = false;
            }

            $parent = parent::save();

            if ($save || $parent) {
                return $contact->id;
            }
        }

        return false;
    }

}
