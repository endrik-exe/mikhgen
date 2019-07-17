<?php

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
/* @var $this View */

$this->title = 'Update User - Agen nKing';

?>
<div class="update-user">
    <?= $this->render('_form', [
        'model' => $model
    ]) ?>
</div>