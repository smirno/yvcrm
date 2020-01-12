<?php

namespace app\components;

use \RecursiveIteratorIterator;
use \RecursiveArrayIterator;

use Yii;
use yii\helpers\Json;

class Translation extends \yii\base\Component
{
    const FOLDER = '/translation/';
    const DEFAULT = 'en-En';

    private $_language;
    private $_translation;

    public function __construct()
    {
        $language = Yii::$app->language;
        $translation = Yii::getAlias('@app') . self::FOLDER . $language . '.json';
        $slugs = [];

        if (file_exists($translation)) {
            $translation = Json::decode(file_get_contents($translation));
        } else {
            $language = self::DEFAULT;
            $translation = Json::decode(file_get_contents(Yii::getAlias('@app') . self::FOLDER . self::DEFAULT . '.json'));
        }

        $this->_language = $language;
        $this->_translation = $translation;
    }

    public function get($slug, $found, $params = false)
    {   
        $translation = $this->_translation['slugs'];
        $slugs = explode('.', trim($slug));

        foreach ($slugs as $key => $slug) {
            if (isset($translation[$slug])) {
                if ((count($slugs) - 1) == $key) {
                    $found = $translation[$slug];
                } else {
                    $translation = $translation[$slug];
                }
            }
        }

        if ($params) {
            true;
        }

        return $found;
    }

    public function getTranslation()
    {   
        return $this->_translation;
    }
}
