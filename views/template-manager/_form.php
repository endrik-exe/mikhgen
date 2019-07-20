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
            Template Editor
        </h3>
        <div class="fields">
            <div class="eight wide field required">
                <label><?= $model->getAttributeLabel('name') ?></label>
                <?= Html::activeTextInput($model, 'name', [
                    'placeholder' => 'Name',
                ])?>
            </div>
            <div class="eight wide field">
                <label>&nbsp;</label>
                <?= Html::a('Set Default', referrer(['index']), [
                    'class' => 'ui tiny right floated teal button'
                ]) ?>
                <?= Html::a("<i class='print icon'></i>", referrer(['index']), [
                    'class' => 'ui tiny right floated icon button'
                ]) ?>
            </div>
            
        </div>
        <div class="field">
            <label><?= $model->getAttributeLabel('source') ?></label>
            <?= Html::activeTextarea($model, 'source', [
                'placeholder' => 'Source',
                'rows' => '20',
            ])?>
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