<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class VueAsset extends AssetBundle
{
    //public $basePath = '@webroot';
    //public $baseUrl = '@web';
    public $sourcePath = '@app/assets/vue';
    public $css = [
    ];
    public $js = [
        'vue.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
