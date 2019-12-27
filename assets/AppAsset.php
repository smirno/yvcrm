<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    	'css/components.css',
        'css/app.css',
    ];
    public $js = [
        'js/app.js',
    ];
}
