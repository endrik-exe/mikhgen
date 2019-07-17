<?php

use app\widgets\Toolbar;
use yii\helpers\Html;
use yii\web\View;
/* @var $this View */

$this->title = 'User - Agen nKing';

?>
<div class="ui vertical segment" style="padding: 1em;">
    <table class="ui teal celled striped small table unstackable">
        <thead>
            <tr>
                <th colspan="3">
                    <span class="header"> DAFTAR USER</span>
                    
                    <?= Toolbar::widget([
                        'buttons' => ['create', 'filter']
                    ]) ?>
                </th>
            </tr>
            <tr>
                <th>User Name</th>
                <th>Agen Code</th>
                <th class="center aligned">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php FOREACH ($model->search() as $user) : ?>
            <tr>
                <td><?= $user->userName ?></td>
                <td><?= $user->isAdmin ? 'Admin' : $user->agenCode ?></td>
                <td class="center aligned collapsing">
                    <?= Html::a('<i class="edit outline icon"></i>', ['update', 'id' => $user->primaryKey, 'referrer' => currentRef()]) ?>
                    <?= Html::a('<i class="trash alternate outline icon"></i>', ['toggle-active', 'id' => $user->primaryKey, 'referrer' => currentRef()]) ?>
                </td>
            </tr>
            <?php ENDFOREACH; ?>
        </tbody>
    </table>
</div>