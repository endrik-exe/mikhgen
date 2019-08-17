<?php


/* @var $this View */

use app\models\User;
use app\models\Voucher;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

?>

<div class="ui vertical segment" style="padding: 1em;">
    <?php $form = ActiveForm::begin([
        'id' => 'form-update-hsuser',
        'method' => 'post',
    ]); ?>
    <div class="ui unstackable tiny form create user">
        <h3 class="ui teal dividing header">
            Hotspot User Information
        </h3>
        <div class="fields">
            <div class="eight wide field required">
                <label><?= $model->getAttributeLabel('name') ?></label>
                <?= Html::activeTextInput($model, 'name', [
                    'placeholder' => 'User name',
                ])?>
            </div>
            <div class="four wide field">
                <label><?= $model->getAttributeLabel('agenCode') ?></label>
                <?= Html::dropDownList('agenCode', $model->agenCode, ArrayHelper::merge(['' => 'None'], User::getDropdownList('agenCode', ['roleId' => 2])), [
                        'id' => 'select-agencode',
                        'class' => 'ui dropdown agenCode',
                    ])
                ?>
            </div>
            <div class="four wide field">
                <label><?= $model->getAttributeLabel('profileName') ?></label>
                <?= Html::activeDropDownList($model, 'profileName', Voucher::getDropdownList(), [
                    'class' => 'ui dropdown profileName'
                ]) ?>
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