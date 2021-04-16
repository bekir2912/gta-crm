<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/select2.min.css',
        'css/site.css',
        'css/pace-theme-flash.css',
        'css/navbar-fixed-side.css',


        'app-assets/vendors/css/vendors.min.css',
        'app-assets/vendors/css/weather-icons/climacons.min.css',
        'app-assets/fonts/meteocons/style.css',
        'app-assets/vendors/css/charts/morris.css',
        'app-assets/vendors/css/charts/chartist.css',
        'app-assets/vendors/css/charts/chartist-plugin-tooltip.css',

        'app-assets/css/bootstrap.css',
        'app-assets/css/bootstrap-extended.css',
        'app-assets/css/colors.css',
        'app-assets/css/components.css',




        'app-assets/css/core/menu/menu-types/vertical-content-menu.css',
        'app-assets/css/core/colors/palette-gradient.css',
        'app-assets/fonts/simple-line-icons/style.css',
        'app-assets/css/core/colors/palette-gradient.css',
        'app-assets/css/pages/timeline.css',
        'app-assets/css/pages/dashboard-ecommerce.css',



        'css/style.css',

    ];
    public $js = [
        'js/pace.min.js',
        'js/select2.min.js',
        'js/scripts.js',


        'app-assets/vendors/js/ui/headroom.min.js',
        'app-assets/vendors/js/charts/chartist.min.js',
        'app-assets/vendors/js/charts/chartist-plugin-tooltip.min.js',
        'app-assets/vendors/js/charts/raphael-min.js',
        'app-assets/vendors/js/charts/morris.min.js',
        'app-assets/vendors/js/timeline/horizontal-timeline.js',
        'app-assets/js/core/app-menu.js',
        'app-assets/js/core/app.js',
        'app-assets/js/scripts/pages/dashboard-ecommerce.js',
        'app-assets/vendors/js/vendors.min.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'rmrevin\yii\fontawesome\AssetBundle',
    ];
}
