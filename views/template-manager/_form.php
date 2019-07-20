<?php


/* @var $this View */

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

?>

<div class="ui vertical segment" style="padding: 1em;">
    <?php $form = ActiveForm::begin([
        'id' => 'form-voucher',
        'method' => 'post',
    ]); ?>
    <div class="ui unstackable tiny form create user">
        <h3 class="ui teal dividing header">
            User Information
        </h3>
        <div class="fields">
            <div class="eight wide field required">
                <label><?= $model->getAttributeLabel('name') ?></label>
                <?= Html::activeTextInput($model, 'name', [
                    'placeholder' => 'Name',
                ])?>
            </div>
            <div class="four wide field">
                <label><?= $model->getAttributeLabel('alias') ?></label>
                <?= Html::activeTextInput($model, 'alias', [
                    'placeholder' => 'Alias',
                ])?>
            </div>
            <div class="four wide field">
                <label><?= $model->getAttributeLabel('price') ?></label>
                <?= Html::activeTextInput($model, 'price', [
                    'placeholder' => 'Price',
                ])?>
            </div>
        </div>
        <div class="fields">
            <div class="eight wide field">
                <label><?= $model->getAttributeLabel('uptime') ?></label>
                <?= Html::activeTextInput($model, 'uptime', [
                    'placeholder' => 'Uptime',
                ])?>
            </div>
            <div class="eight wide field">
                <label><?= $model->getAttributeLabel('gracePeriod') ?></label>
                <?= Html::activeTextInput($model, 'gracePeriod', [
                    'placeholder' => 'Grace period',
                ])?>
            </div>
        </div>
        <div class="fields">
            <div class="eight wide field">
                <label><?= $model->getAttributeLabel('rateLimit') ?></label>
                <?= Html::activeTextInput($model, 'rateLimit', [
                    'placeholder' => 'Rate limit',
                ])?>
            </div>
        </div>
        <?= Html::a('Cancel', referrer(['index']), [
            'class' => 'ui tiny right floated negative button'
        ]) ?>
        <?= Html::submitButton('Save', [
            'class' => 'ui tiny right floated primary submit button'
        ]) ?>
        <div class="spacey" style="width: 100%; height: 2em;"></div>
        
    </div>
    <?php $form->end(); ?>
</div>

<script>
    $('.ui.dropdown').dropdown();
</script>