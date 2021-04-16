<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class TestAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/jquery.responsive-collapse.css',
        'css/site.css',
        'css/pace-theme-flash.css',
        'temp/jquery.multilevelpushmenu.min.css',
        'temp/customsize.css',
    ];
    public $js = [
        'js/jquery.responsive-collapse.js',
        'js/pace.min.js',
        'js/scripts.js',
        'temp/jquery.multilevelpushmenu.min.js',
        'temp/customsize.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'rmrevin\yii\fontawesome\AssetBundle',
    ];
}
