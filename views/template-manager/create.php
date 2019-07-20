<?php

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
/* @var $this View */

$this->title = 'Create Voucher - Agen nKing';

?>
<div class="create-voucher">
    <?= $this->render('_form', [
        'model' => $model
    ]) ?>
</div>