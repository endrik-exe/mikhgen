<?php

use app\widgets\Toolbar;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
/* @var $this View */

$this->title = 'User - Agen nKing';

?>
<div class="ui tiny filter modal">
    <i class="close icon"></i>
    <div class="header">Filter</div>
    <div class="content">
        <?php $form = ActiveForm::begin([
            'id' => 'form-filter',
            'method' => 'get',
        ]); ?>
        <div class="ui unstackable tiny form filter">
            <div class="fields">
                <div class="eight wide field">
                    <label>Name</label>
                    <?= Html::activeTextInput($model, 'name', [
                        'class' => '',
                        'placeholder' => 'Search name'
                    ]) ?>
                </div>
                <div class="eight wide field" style="width: 30%">
                    <label>Profile</label>
                    <?= Html::activeDropDownList($model, 'profileName',
                        ArrayHelper::merge(['' => 'All'], ArrayHelper::map($model->getList(), 'profileName', 'profileName')),
                    [
                        'class' => 'ui search dropdown profileName',
                        'value' => $model->profileName
                    ]) ?>
                </div>
            </div>
            <div class="fields">
                <div class="sixteen wide field" style="width: 30%">
                    <label>Comement</label>
                    <?= Html::activeDropDownList($model, 'comment',
                        ArrayHelper::merge(['' => 'All'], ArrayHelper::map($model->getList(), 'comment', 'comment')),
                    [
                        'class' => 'ui search dropdown comment',
                        'value' => $model->comment
                    ]) ?>
                </div>
            </div>
            <script>
                ready(() => {
                    $('.search.dropdown.profileName, .search.dropdown.comment').dropdown({
                        fullTextSearch: true,
                        allowAdditions: true,
                        forceSelection: false,
                        clearable: true
                    });
                });
            </script>
        </div>
        <?php $form->end(); ?>
    </div>
    <div class="actions">
        <button type="submit" form="form-filter" class="ui tiny primary button">Filter</button>
    </div>
</div>
<div class="ui vertical segment" style="padding: 1em;">
    <div class="eexe table container">
        <table class="ui teal celled striped small table unstackable">
            <thead>
                <tr>
                    <th colspan="4">
                        <span class="header"> DAFTAR HOTSPOT USER</span>

                        <?= Toolbar::widget([
                            'buttons' => ['create', 'print', 'filter'],
                            'customTools' => [
                                'print' => function($model){
                                    return Html::a('<i class="print icon"></i>', ['print'], [
                                        'class' => 'ui right floated mini basic primary icon button',
                                        'target' => '_blank'
                                    ]);
                                }
                            ]
                        ]) ?>
                    </th>
                </tr>
            </thead>
        </table>
        <div class="scrolling content">
            <table class="ui teal celled striped small table unstackable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Agen Code</th>
                        <th>Profile</th>
                        <th class="center aligned">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php FOREACH ($model->search() as $user) : ?>
                    <tr>
                        <td><?= $user->name ?></td>
                        <td><?= $user->agenCode ?></td>
                        <td><?= $user->profileName ?></td>
                        <td class="center aligned collapsing">
                            <?= Html::a('<i class="edit outline icon"></i>', ['update', 'id' => $user->primaryKey, 'referrer' => currentRef()]) ?>
                            <?= Html::a('<i class="trash alternate outline icon"></i>', ['toggle-active', 'id' => $user->primaryKey, 'referrer' => currentRef()]) ?>
                        </td>
                    </tr>
                    <?php ENDFOREACH; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>