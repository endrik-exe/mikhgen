<?php

use yii\helpers\Url;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$user = Yii::$app->user->identity;

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
    .right-panel {
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
    .panel-container > .right-panel
    {
        margin: 0;
        width: calc(60% + 1px);
        height: 100%;
    }
    
    .left-panel {
        background-color: #4c4c4c;
        height: calc(100% + 2px);
        width: calc(60% + 2px);
        position: absolute;
        left: -60%;
        margin: calc(-1rem - 1px);
        margin-left: -1px;
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
    
    body.open-right .right-panel {
        right: 0;
        opacity: 1;
    }
    body.open-left .left-panel {
        left: 0;
        opacity: 1;
    }
    
    body.open-right .nav.segment > .button.user,
    body.open-right .nav.segment > .header.user,
    body.open-left .nav.segment > .left.header > .link.menu,
    body.open-left .nav.segment > .left.header > .content
    {
        color: white !important;
    }
    body.open-right .nav.segment > .header.user .sub.header,
    body.open-left .nav.segment > .left.header > .content > .sub.header
    {
        color: wheat !important;
    }
    
    body.open-right .panel-container,
    body.open-left .panel-container
    {
        visibility: visible;
    }
    
    .panel-container > .left-panel .vertical.pointing.menu .item
    {
        margin: 0 0px 0 -2px;
        border-right: none;
        border-left-style: solid;
        border-left-color: transparent;
    }
    .panel-container > .left-panel .vertical.pointing.menu .item .icon
    {
        float: left;
        margin: 0 .5em 0 0;
    }
</style>
<div class="ui clearing nav segment" style="border-radius: 0px; margin-top: 0px; position:fixed; z-index: 100; left: 0px; right: 0px;overflow: hidden; border-width: 0px 0px 1px 0px;">
    <button class="ui right floated basic teal circular icon button user" onclick="$('body').toggleClass('open-right');">
        <i class="icon user outline"></i>
    </button>
    <h3 class="ui right floated aligned header user" style="margin-bottom: 0px">
        <div class="uppercase content">
            ACCOUNT
            <div class="normalcase sub header"><?= $user->userName ?> - <?= $user->roleId == 1 ? 'Admin' : $user->agenCode ?></div>
        </div>
    </h3>
    <div class="left-panel header">
        <div></div>
    </div>
    <div class="right-panel header">
        <div></div>
    </div>
    <h3 class="ui left floated header">
        <i class="bars icon link menu" onclick="$('body').toggleClass('open-left');"></i>
        <div class="uppercase content">
            HOME
            <div class="normalcase sub header">Overview</div>
        </div>
    </h3>
</div>
<div class="panel-container">
    <div class="left-panel">
        <div class="ui inverted secondary vertical pointing menu" style="width: 100%">
            <a class="item active" href="<?= Url::to(['/site/index']) ?>">
                <i class="home icon"></i> OVERVIEW
            </a>
            <a class="item" href="#">
                <i class="money bill alternate outline icon"></i> SALES
            </a>
            <a class="item" href="#">
                <i class="wifi icon"></i> HOTSPOT USER
            </a>
            <a class="item" href="<?= Url::to(['/voucher'])?>">
                <i class="credit card outline icon"></i> VOUCHER
            </a>
            <a class="item" href="#">
                <i class="folder outline icon"></i> TEMPLATE MANAGER
            </a>
            <a class="item" href="#">
                <i class="chart bar icon"></i> INSIGHT
            </a>
            <a class="item" href="#">
                <i class="envelope outline icon"></i> SMS GATEWAY
            </a>
            <a class="item" href="<?= Url::to(['/user'])?>">
                <i class="users icon"></i> USER
            </a>
            <a class="item" href="#">
                <i class="cog icon"></i> SETTING
            </a>
        </div>
    </div>
    <div class="right-panel">
        <div class="ui inverted secondary vertical pointing menu" style="width: 100%">
            <a class="item active text-right" href="<?= Url::to(['/site/index']) ?>">
                PROFILE <i class="home icon"></i>
            </a>
            <a class="item text-right" href="<?= Url::to(['/site/logout']) ?>">
                LOGOUT <i class="power off icon"></i>
            </a>
        </div>
    </div>
</div>