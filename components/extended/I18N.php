<?php

namespace app\components\extended;

use Yii;

class I18N extends \yii\i18n\I18N
{   
    const CATEGORY = 'app';

    const LANGUAGES = [
        'ru-RU' => [
            'name' => 'Russian',
            'code' => 'ru-RU'
        ],
        'en-US' => [
            'name' => 'English',
            'code' => 'en-US'
        ],
    ];

    public $language;
    public $category;
    public $path;

    public function init()
    {   
        parent::init();

        $this->language = Yii::$app->language;
    }

    public function get($message, $params = [])
    {
        return $this->translate(self::CATEGORY, $message, $params, $this->language);
    }

    public function getTranslation($language = false)
    {
        if (!$language) {
            $language = $this->language;
        }

        $translation = false;
        $source = $this->getMessageSource(self::CATEGORY);

        if ($source) {
            $messages = require_once Yii::getAlias($source->basePath . DS . $language . DS . self::CATEGORY) . '.php';

            if ($messages) {

                $language = self::LANGUAGES[$language];

                $translation = [
                    'language' => $language,
                    'messages' => [
                        $language['code'] => $messages
                    ]
                ];

            }
        }

        return $translation;
    }
}
