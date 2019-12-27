<?php

namespace app\models;

use Yii;
use yii\helpers\VarDumper;

use app\components\FieldsModel;
use app\models\base\Lead;
use app\models\base\Contact;

class LeadPage extends FieldsModel
{

    private $contact;

    public function __construct($lead, $config = [])
    {
        if ($lead->contact) {
            $this->contact = $lead->contact;
        } else {
            $this->contact = new Contact;
        }

        $this->addAttribute($this->contact, 'firstname', 'text', 'Имя');
        $this->addAttribute($this->contact, 'lastname', 'text', 'Фамилия');

        parent::__construct($lead, $config);
    }

    public function getLead()
    {
        return [
            'name' => $this->essence->name
        ];
    }

    public function save()
    {
        if ($this->validate()) {

            $save = false;

            $lead = $this->essence;
            $contact = $this->contact;

            foreach ($this->attributes as $attribute => $value) {
                if ($contact->context == $this->context[$attribute]) {
                    $contact->setAttribute($attribute, $value);
                }
            }

            if (count($contact->getDirtyAttributes())) {
                $save = $contact->save();
            }

            if (count($lead->getDirtyAttributes()) || $lead->isNewRecord) {
                if ($save && $lead->isNewRecord) {
                    $lead->link('contact', $contact);
                }
                $save = $lead->save();
            }

            $parent = parent::save();

            if ($save || $parent) {
                return $lead->id;
            }
        }

        return false;
    }

}
