<?php


/* @var $this View */

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

?>

<div class="ui vertical segment" style="padding: 1em;">
    <?php $form = ActiveForm::begin([
        'id' => 'form-create-user',
        'method' => 'post',
    ]); ?>
    <div class="ui unstackable tiny form create user">
        <h3 class="ui teal dividing header">
            User Information
        </h3>
        <div class="fields">
            <div class="eight wide field required">
                <label><?= $model->getAttributeLabel('userName') ?></label>
                <?= Html::activeTextInput($model, 'userName', [
                    'placeholder' => 'User name',
                ])?>
            </div>
            <div class="four wide field">
                <label><?= $model->getAttributeLabel('agenCode') ?></label>
                <?= Html::activeTextInput($model, 'agenCode', [
                    'placeholder' => 'Agen code',
                ])?>
            </div>
            <div class="four wide field">
                <label><?= $model->getAttributeLabel('roleId') ?></label>
                <?= Html::activeDropDownList($model, 'roleId', [1 => 'Admin', 2 => 'Agen'], [
                    'class' => 'ui dropdown agenCode'
                ]) ?>
            </div>
        </div>
        <div class="fields">
            <div class="eight wide field">
                <label><?= $model->getAttributeLabel('email') ?></label>
                <?= Html::activeTextInput($model, 'email', [
                    'placeholder' => 'Email',
                ])?>
            </div>
            <div class="eight wide field">
                <label><?= $model->getAttributeLabel('handphone') ?></label>
                <?= Html::activeTextInput($model, 'handphone', [
                    'placeholder' => 'Handphone',
                ])?>
            </div>
        </div>
        <div class="fields">
            <div class="eight wide field required">
                <label><?= $model->getAttributeLabel('password') ?></label>
                <?= Html::activePasswordInput($model, 'password', [
                    'placeholder' => 'New Password',
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