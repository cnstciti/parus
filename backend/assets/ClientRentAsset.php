<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class ClientRentAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/client-rent/index.css',
        'css/card.css',
    ];
    public $js = [
    ];

    public $depends = [
    ];
}
