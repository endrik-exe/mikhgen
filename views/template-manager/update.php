<?php

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
/* @var $this View */

$this->title = 'Create User - Agen nKing';

?>
<div class="create-user">
    <?= $this->render('_form', [
        'model' => $model
    ]) ?>
</div>