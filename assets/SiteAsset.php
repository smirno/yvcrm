<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class SiteAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [];
}
