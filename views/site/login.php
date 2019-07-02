<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<style>
    .main.wrap
    {
        height: 100%;
    }
</style>
<div class="ui middle aligned center aligned grid" style="height:100%;">
    <div class="column" style="max-width: 350px">
        <h2 class="ui teal header">
            <div class="content">
                Login MIKHGEN
            </div>
        </h2>
        <?php $form = ActiveForm::begin([
            'options' => [
                'autocomplete' => "off",
                'class' => 'ui large form'
            ]
        ]); ?>
            <div class="ui stacked segment">
                <div class="field">
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <?= Html::activeInput('text', $model, 'userName', [
                            'placeholder' => 'Nama',
                        ]) ?>
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <?= Html::activeInput('password', $model, 'password', [
                            'placeholder' => 'Password',
                        ]) ?>
                    </div>
                </div>
                <?= Html::submitButton('Login', [
                    'class' => 'ui fluid large teal submit button',
                ]) ?>
            </div>

            <div class="ui error message"></div>
        <?php $form->end() ?>

        <div class="ui message">
            Ingin bergaung? hubungi 085885562xxx
        </div>
    </div>
</div>