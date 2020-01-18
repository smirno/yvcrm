<?php

namespace app\models;

use Yii;

use app\components\extended\Model;
use app\models\base\Contact;

class ContactsPage extends Model
{
    public function getFilters()
    {
        $filters = [
            'status' => [
                'type' => 'radio',
                'value' => 1,
                'buttons' => [
                    'all' => [
                        'label' => $this->translation->get('app.contacts.filters.status.buttons.all', 'All')
                    ],
                    '0' => [
                        'label' => $this->translation->get('app.contacts.filters.status.buttons.archive', 'Archive')
                    ], 
                    '1' => [
                        'label' => $this->translation->get('app.contacts.filters.status.buttons.active', 'Active')
                    ]
                ]
            ],
            'search' => [
                'type' => 'text',
                'value' => '',
                'label' => $this->translation->get('app.contacts.filters.search.label', 'Search')
            ],
            'create' => [
                'type' => 'link',
                'label' => $this->translation->get('app.contacts.filters.create.label', 'Create contact'),
                'to' => [
                    'name' => 'contact',
                    'params' => ['id' => 'create']
                ]
            ]
        ];

        return $filters;
    }

    public function getContacts($filters)
    {
        $contacts = Contact::find()->joinWith(['leads'], true, 'LEFT JOIN');

        foreach ($filters as $type => $filter) {
            switch ($type) {

                case 'status':
                    if ($filter != 'all') {
                        if (in_array($filter, Contact::STATUS)) {
                            $contacts->andWhere(['contact.status' => $filter]);
                        }
                    }
                    break;

                case 'search':
                    if ($filter) {

                        $filter = array_diff(explode(' ', trim($filter)), [' ', Null]);

                        // Делаем выборку по fulltext индексу
                        $strings = array_map(function($string) {
                            return  $string . '*';
                        }, $filter);

                        $strings = implode(' ', $strings);
                        $contacts->andWhere('MATCH(firstname, lastname) AGAINST(\'' . $strings . '\' IN BOOLEAN MODE)');

                        // Отсеиваем лишние записи
                        $strings = array_map(function($string) {
                            return  $string . '%';
                        }, $filter);
                        
                        if (count($strings) == 1) {
                            $contacts->andWhere(['OR',
                                ['OR LIKE', 'contact.lastname', $strings, false],
                                ['OR LIKE', 'contact.firstname', $strings, false],
                            ]);
                        } else {
                            $contacts->andWhere(['OR LIKE', 'contact.lastname', $strings, false]);
                            $contacts->andWhere(['OR LIKE', 'contact.firstname', $strings, false]);
                        }

                    }
                    break;
            }
        }

        return $contacts->all();
    }
}