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
        'https://use.fontawesome.com/releases/v5.3.1/css/all.css',
        'css/site.css',
        //'https://fonts.googleapis.com/css?family=Lato&display=swap',
    ];
    public $js = [
        'js/site.js',
        //"https://use.fontawesome.com/releases/v5.3.1/js/all.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
