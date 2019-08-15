<?php


/* @var $this View */

use app\models\Server;
use app\models\User;
use app\models\Voucher;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

?>
<div class="voucher-generator">
    <div class="ui vertical segment" style="padding: 1em;">
        <?php $form = ActiveForm::begin([
            'id' => 'form-generate-voucher',
            'method' => 'post',
        ]); ?>
        <div class="ui unstackable tiny form create user">
            <h3 class="ui teal dividing header">
                Voucher Information
            </h3>
            <div class="fields">
                <div class="six wide field">
                    <label><?= $model->getAttributeLabel('agenId') ?></label>
                    <?= Html::activeDropDownList($model, 'agenId', User::getDropdownList(null, ['roleId' => 2]), [
                        'class' => 'ui dropdown agenId'
                    ]) ?>
                </div>
                <div class="two wide field">
                    <label><?= $model->getAttributeLabel('agenCode') ?></label>
                    <?php 
                    echo Html::dropDownList('agenCode', $model->agenId, User::getDropdownList('agenCode', ['roleId' => 2]), [
                        'id' => 'select-agencode',
                        'class' => 'ui dropdown agenCode',
                        'data-linked' => '#'.Html::getInputId($model, 'agenId'),
                    ]);
                    
                    echo Html::activeHiddenInput($model, 'agenCode');
                    ?>
                    <script>
                        $('#select-agencode').change(function(e){
                            $('<?='#'.Html::getInputId($model, 'agenCode')?>').val($(this).find('option:selected').text());
                        }).change();
                    </script>
                </div>
                <div class="eight wide field">
                    <label><?= $model->getAttributeLabel('server') ?></label>
                    <?= Html::activeDropDownList($model, 'server', ArrayHelper::merge([null => 'All'], Server::getDropdownList()), [
                        'class' => 'ui dropdown server'
                    ]) ?>
                </div>
            </div>
            <div class="fields">
                <div class="six wide field">
                    <label><?= $model->getAttributeLabel('profile') ?></label>
                    <?= Html::activeDropDownList($model, 'profile', Voucher::getDropdownList(), [
                        'class' => 'ui dropdown profile'
                    ]) ?>
                </div>
                <div class="two wide field">
                    <label><?= $model->getAttributeLabel('vcAlias') ?></label>
                    <?php
                    echo Html::dropDownList('vcAlias', $model->profile, Voucher::getDropdownList('alias'), [
                        'id' => 'select-vcalias',
                        'class' => 'ui dropdown vcAlias',
                        'data-linked' => '#'.Html::getInputId($model, 'profile'),
                    ]);
                    
                    echo Html::activeHiddenInput($model, 'vcAlias');
                    ?>
                    <script>
                        $('#select-vcalias').change(function(e){
                            $('<?='#'.Html::getInputId($model, 'vcAlias')?>').val($(this).find('option:selected').text());
                        }).change();
                    </script>
                </div>
                <div class="eight wide field">
                    <label><?= $model->getAttributeLabel('qty') ?></label>
                    <?= Html::activeTextInput($model, 'qty', [
                        'placeholder' => 'Qty',
                    ])?>
                </div>
            </div>
            <?= Html::a('Cancel', referrer(['index']), [
                'class' => 'ui tiny right floated negative button'
            ]) ?>
            <?= Html::submitButton('Generate', [
                'class' => 'ui tiny right floated primary submit button'
            ]) ?>
            <div class="spacey" style="width: 100%; height: 2em;"></div>

        </div>
        <?php $form->end(); ?>
    </div>
</div>
<script>
    $('.ui.dropdown').dropdown();
    
    $("select[data-linked]").each((index, el) => {
        $watch = $($(el).data('linked'));
        
        $watch.change((e) => {
            $listener = $(el);
            $listener.val(e.target.value).change();
        }).change();
    });
</script>