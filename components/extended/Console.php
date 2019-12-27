<?php

namespace app\components\extended;

use Yii;

class Console extends \yii\console\Application
{
    public function coreCommands()
    {
        return [
            // 'asset' => 'yii\console\controllers\AssetController',
            'cache' => 'yii\console\controllers\CacheController',
            // 'fixture' => 'yii\console\controllers\FixtureController',
            'help' => 'yii\console\controllers\HelpController',
            // 'message' => 'yii\console\controllers\MessageController',
            'migrate' => 'yii\console\controllers\MigrateController',
            // 'serve' => 'yii\console\controllers\ServeController',
        ];
    }
}
