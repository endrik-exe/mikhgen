<?php

use app\models\Voucher;
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
                    <span class="header"> DAFTAR VOUCHER</span>
                    
                    <?= Toolbar::widget([
                        'buttons' => ['create', 'generate', 'filter'],
                        'customTools' => [
                            'generate' => function($model) {
                                return Html::a('<i class="upload icon"></i>', ['generate', 'referrer' => currentRef()], [
                                    'class' => 'ui right floated mini grey icon button'
                                ]);
                            }
                        ]
                    ]) ?>
                </th>
            </tr>
            <tr>
                <th>Name</th>
                <th>Alias</th>
                <th>Price</th>
                <th>Uptime</th>
                <th class="center aligned">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php FOREACH (Voucher::getVoucher() as $voucher) : ?>
            <tr>
                <td><?= $voucher->name ?></td>
                <td><?= $voucher->alias ?></td>
                <td><?= $voucher->price ?></td>
                <td><?= $voucher->uptime ?></td>
                <td class="center aligned collapsing">
                    <?= Html::a('<i class="edit outline icon"></i>', ['update', 'id' => $voucher->primaryKey, 'referrer' => currentRef()]) ?>
                    <?= Html::a('<i class="print icon"></i>', ['upload', 'id' => $voucher->primaryKey, 'referrer' => currentRef()]) ?>
                    <?= Html::a('<i class="trash alternate outline icon"></i>', ['toggle-active', 'id' => $voucher->primaryKey, 'referrer' => currentRef()]) ?>
                </td>
            </tr>
            <?php ENDFOREACH; ?>
        </tbody>
    </table>
</div>