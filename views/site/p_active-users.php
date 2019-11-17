<?php
/* @var $this View */

use app\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use yii\widgets\ActiveForm;

?>
<div class="sub header"><?= count($model->activeUsers) ?> Pengguna</div>
<div class="ui middle aligned divided list">
    <?php FOREACH ($model->activeUsers as $user) : ?>
    <div class="item">
        <div class="right floated content">
            <div class="circular ui red mini icon button"><i class="icon minus"></i></div>
        </div>
        <i class="large middle aligned icon" style="min-width: 46px"><?= $user['profileAlias'] ?></i>
        <div class="content">
            <a class="header"><?= $user['user'] ?></a>
            <div class="description">
                <?= $user['agenCode'] ?? $user['comment'] ?? '-' ?>,&nbsp;
                Uptime <?= formatTimespan($user['uptime']) ?>
            </div>
        </div>
    </div>
    <?php ENDFOREACH; ?>
</div>