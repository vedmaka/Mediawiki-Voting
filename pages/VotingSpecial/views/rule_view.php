<?php if ( !defined( 'MEDIAWIKI' ) ) die( 'Not an entry point.' ); ?>

<fieldset>
    <legend><?=wfMsg('voting-specialrules-view-title')?></legend><br>

    <table class="wikivote-table table table-bordered">

        <thead>
        <th><?=wfMsg('voting-specialcolumn-type-id')?></th>
        <th><?=wfMsg('voting-specialcolumn-type-name')?></th>
        <th><?=wfMsg('voting-specialcolumn-type-control-actions')?></th>
        </thead>

        <tbody>

        <? foreach($rules as $rule): ?>

        <tr>
            <td><?=$rule->getId()?></td>
            <td><?=$rule->name?></td>

            <td>

                <a href="<?= $this->getActionURL( 'rule/edit', $rule->getId() ) ?>">
                    <?= wfMsg('voting-speciallink-group-edit') ?>
                </a>

                <span>|</span>

                <a href="<?= $this->getActionURL( 'rule/delete', $rule->getId() ) ?>"  onclick="return confirm('<?=wfMsg('wikivotevoting-js-link-confirm-delete')?>');">
                    <?= wfMsg('voting-speciallink-group-delete') ?>
                </a>

            </td>
        </tr>

            <? endforeach; ?>

        </tbody>

    </table>

    <div class="form-actions">
        <a href="<?=$this->getActionURL('rule/create' )?>" class="btn btn-primary">
            <?=wfMsg('voting-speciallink-create-rule')?>
        </a>
    </div>

</fieldset>