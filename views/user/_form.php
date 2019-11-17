<?php


/* @var $this View */

use app\models\HotspotUser;
use app\models\Voucher;
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
<div class="ui vertical segment detail-tab" style="padding: 4px 0px;">
    <div class="ui top attached pointing secondary menu">
        <a class="item active" data-tab="tab-1">STOCK VOUCHER</a>
        <a class="item" data-tab="tab-2">TOP VOUCHER</a>
    </div>
    <div class="ui bottom attached tab segment active" data-tab="tab-1" style="margin: 0px">
       <div class="sub header">Voucher</div>
       <div class="ui middle aligned divided list">
            <?php
            $userQuery = new HotspotUser();
            $userQuery->comment = "vc.|.$model->agenCode.|.";
            
            $allStockUser = count($userQuery->search());
            IF ($allStockUser) :
                FOREACH (Voucher::getVoucher() as $voucher) :
                ?>
                <div class="item">
                    <i class="large middle aligned icon" style="min-width: 46px"><?= $voucher->alias ?></i>
                    <div class="content">
                        <a class="header"><?= $voucher->name ?></a>
                        <?php
                            $userQuery->comment = "vc.|.$model->agenCode.|.$voucher->alias";
                            $stockUser = count($userQuery->search());

                            $percentage = ($stockUser / $allStockUser) * 100;
                            $min = max(0, $percentage - 8);

                            echo "<div class='description' style='background: linear-gradient(90deg, #83e6e6 $min%, #83e6e600 $percentage%);'>";
                            echo $stockUser;
                            echo "</div>";
                        ?>
                    </div>
                </div>
                <?php ENDFOREACH;
            ENDIF; ?>
        </div>
    </div>
</div>
<script>
    $('.ui.dropdown').dropdown();
</script>