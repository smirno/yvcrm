<?php

namespace app\components;

use Yii;
use yii\base\Component;
use yii\helpers\Json;

class Translation extends Component
{
    const FOLDER = '/translation/';
    const DEFAULT = 'en-US';

    private $_language;
    private $_translation;

    public function __construct()
    {
        $language = Yii::$app->language;
        $translation = Yii::getAlias('@app') . self::FOLDER . $language . '.json';

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
            return Yii::t('app', $found, $params);
        }

        return $found;
    }

    public function getTranslation()
    {   
        return $this->_translation;
    }
}
