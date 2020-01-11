<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    	'assets/css/vendor.css',
        'assets/css/app.css',
    ];
    public $js = [
        'assets/js/manifest.js',
        'assets/js/vendor.js',
        'assets/js/app.js',
    ];
}
