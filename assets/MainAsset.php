<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

class MainAsset extends AssetBundle
{
    //public $basePath =null;
    //public $baseUrl = '@web';
    public $sourcePath = '@app/assets/mainasset';
    public $css = [
        'style.css?v=1.5'
    ];
    public $js = [
        'semantic-ui-vue.min.js'
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    
    public $depends = [
        'app\assets\VueAsset',
        'app\assets\SemanticUIAsset'
    ];
}