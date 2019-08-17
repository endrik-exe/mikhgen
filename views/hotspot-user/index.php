<?php

use app\widgets\Toolbar;
use yii\helpers\Html;
use yii\web\View;
/* @var $this View */

$this->title = 'User - Agen nKing';

?>
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