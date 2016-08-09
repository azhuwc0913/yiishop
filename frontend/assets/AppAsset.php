<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/bottomnav.css',
        'style/footer.css'
    ];
    public $js = [
        'js/jquery-1.8.3.min.js',
        'js/header.js'
    ];
    public $depends = [
//        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
