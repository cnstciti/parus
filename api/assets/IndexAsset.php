<?php

namespace api\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class IndexAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/index/index.css',
    ];
    public $js = [
    ];

    public $depends = [
    ];
}
