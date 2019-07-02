<?php

use yii\helpers\Url;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<style>
    .panel-container {
        position: fixed;
        top: 0px;
        width: 100vw;
        height:100vh;
        max-width: 600px;
        z-index: 99;
        padding-top: calc(39px + 2rem);
        visibility: hidden;
        overflow: hidden;
    }
    .left-panel {
        background-color: #4c4c4c;
        height: calc(100% + 2px);
        width: calc(60% + 2px);
        position: absolute;
        right: -60%;
        margin: calc(-1rem - 1px);
        margin-right: -1px;
        z-index: -1;
        opacity: 0;
        transition: all 0.3s ease;
    }
    .panel-container > .left-panel
    {
        margin: 0;
        width: calc(60% + 1px);
        height: 100%;
    }
    body.open-left .left-panel {
        right: 0;
        opacity: 1;
    }
    body.open-left .nav.segment > .button.user,
    body.open-left .nav.segment > .header.user
    {
        color: white !important;
    }
    body.open-left .nav.segment > .header.user .sub.header
    {
        color: wheat !important;
    }
    
    body.open-left .panel-container
    {
        visibility: visible;
    }
</style>
<div class="ui clearing nav segment" style="border-radius: 0px; margin-top: 0px; position:fixed; z-index: 100; left: 0px; right: 0px;overflow: hidden; border-width: 0px 0px 1px 0px;">
    <button class="ui right floated basic teal circular icon button user" onclick="$('body').toggleClass('open-left');">
        <i class="icon user outline"></i>
    </button>
    <h3 class="ui right floated aligned header user" style="margin-bottom: 0px">
        <div class="uppercase content">
            AKUN
            <div class="normalcase sub header"><?= Yii::$app->user->identity->userName ?> - <?= Yii::$app->user->identity->agenCode ?></div>
        </div>
    </h3>
    <div class="left-panel header">
        <div></div>
    </div>
    <h3 class="ui left floated header">
        <i class="home icon"></i>
        <div class="uppercase content">
            BERANDA
            <div class="normalcase sub header">Ikhtisar</div>
        </div>
    </h3>
</div>
<div class="panel-container">
    <div class="left-panel">
        <div class="ui inverted secondary vertical pointing menu" style="width: 100%">
            <a class="item active text-right" href="<?= Url::to(['/site/index']) ?>">
                BERANDA <i class="home icon"></i>
            </a>
            <a class="item text-right" href="<?= Url::to(['/site/logout']) ?>">
                LOGOUT <i class="power off icon"></i>
            </a>
        </div>
    </div>
</div>