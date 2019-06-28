<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class SemanticUIAsset extends AssetBundle
{
    //public $basePath = '@webroot';
    //public $baseUrl = '@web';
    public $sourcePath = '@app/assets/semanticui';
    public $css = [
        'semantic.min.css'
    ];
    public $js = [
        'semantic.min.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
