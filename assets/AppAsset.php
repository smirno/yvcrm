<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    	'assets/css/components.css',
        'assets/css/app.css',
    ];
    public $js = [
        'assets/js/app.js',
    ];
}
