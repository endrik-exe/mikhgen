<?php

use app\models\Template;
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
                <th colspan="5">
                    <span class="header">TEMPLATE LIST</span>
                    
                    <?= Toolbar::widget([
                        'buttons' => ['create']
                    ]) ?>
                </th>
            </tr>
            <tr>
                <th>Name</th>
                <th>Last Modified</th>
                <th class="center aligned">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php FOREACH (Template::getTemplates() as $template) : ?>
            <tr>
                <td><?= $template->name ?></td>
                <td><?= $template->modifiedDate ?></td>
                <td class="center aligned collapsing">
                    <?= Html::a('<i class="edit outline icon"></i>', ['update', 'id' => $template->primaryKey, 'referrer' => currentRef()]) ?>
                    <?= Html::a('<i class="trash alternate outline icon"></i>', ['toggle-active', 'id' => $template->primaryKey, 'referrer' => currentRef()]) ?>
                </td>
            </tr>
            <?php ENDFOREACH; ?>
        </tbody>
    </table>
</div>