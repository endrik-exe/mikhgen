<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\MainAsset;

MainAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script>
        window.readyHandlers = [];
        window.ready = function ready(handler) {
          window.readyHandlers.push(handler);
          handleState();
        };

        window.handleState = function handleState () {
          if (['interactive', 'complete'].indexOf(document.readyState) > -1) {
            while(window.readyHandlers.length > 0) {
              (window.readyHandlers.shift())();
            }
          }
        };

        document.onreadystatechange = window.handleState;
        
        function loadPage()
        {
            $('.page-loader.modal').modal({
                dimmerSettings: {
                    variation: 'inverted'
                },
                onHide: function(){
                    //$('.main.wrap').show();
                }
            }).modal('show');
        }
        
        function loadFinish()
        {
            setTimeout(() => {
                $('.page-loader.modal').modal('hide');
            }, 400);
        }
        
        function unloadPage()
        {
            alert('Bye Now');
        }
        
    </script>
    <?php $this->head() ?>
</head>
<body onunload="unloadPage()">
<?php $this->beginBody() ?>
<div class="ui basic page-loader modal">
    <div class="ui active centered text loader">LOADING</div>
</div>
<script>
    //loadPage();
    window.addEventListener('load', function(){
        loadFinish();
    });
    window.addEventListener('beforeunload', function(){
        loadPage();
    });
</script>
<?php if (Yii::$app->user->identity) echo $this->render('header'); ?>
<div class="main wrap" style="/*display: none;*/ overflow-x: hidden; padding-top: 65px; min-height: 100vh" >
    <?= $content ?>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
