<?php
/* @var $this View */

$this->title = 'User - Agen nKing';

?>
<div class="ui vertical segment" style="padding: 1em;">
    <table class="ui teal celled striped small table unstackable">
        <thead>
            <tr>
                <th colspan="3">
                    <span class="header"> DAFTAR USER</span>
                    
                    <a class="ui right floated mini primary icon button">
                        <i class="plus icon"></i>
                    </a>
                    <a class="ui right floated mini icon button">
                        <i class="filter icon"></i>
                    </a>
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
                    <a href="#"><i class="edit outline icon"></i></a>
                    <a href="#"><i class="trash alternate outline icon"></i></a>
                </td>
            </tr>
            <?php ENDFOREACH; ?>
        </tbody>
    </table>
</div>