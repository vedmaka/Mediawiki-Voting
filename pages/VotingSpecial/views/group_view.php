<?php if ( !defined( 'MEDIAWIKI' ) ) die( 'Not an entry point.' ); ?>

<fieldset>
    <legend><?=wfMsg('voting-specialgroup-view-title', $group->name)?></legend><br>

<table class="wikivote-table table table-bordered">

    <thead>
        <th><?=wfMsg('voting-specialcolumn-rating-id')?></th>
        <th><?=wfMsg('voting-specialcolumn-rating-name')?></th>
        <th style="max-width: 120px"><?=wfMsg('voting-specialcolumn-rating-description')?></th>
        <th><?=wfMsg('voting-specialcolumn-rating-type')?></th>
        <th><?=wfMsg('voting-specialcolumn-rating-actions')?></th>
    </thead>

    <tbody>

    <? foreach($ratings as $rating): ?>

        <tr>
            <td><?=$rating->getId()?></td>
            <td><?=$rating->name?></td>
            <td style="max-width: 120px"><?=$rating->description?></td>
            <td>
                <?=$rating->type_name?>
            </td>
            <td>

                <a href="<?= $this->getActionURL( 'rating/edit', $rating->getId() ) ?>">
                    <?= wfMsg('voting-speciallink-group-edit') ?>
                </a>

                <span>|</span>

                <a href="<?= $this->getActionURL( 'rating/delete', $rating->getId() ) ?>"  onclick="return confirm('<?=wfMsg('wikivotevoting-js-link-confirm-delete')?>');">
                    <?= wfMsg('voting-speciallink-group-delete') ?>
                </a>

            </td>
        </tr>

    <? endforeach; ?>

    </tbody>

</table>

    <div class="form-actions">
        <a href="<?=$this->getActionURL('rating/create', $group->getId() )?>" class="btn btn-primary">
            <?=wfMsg('voting-speciallink-create-rating')?>
        </a>
    </div>

</fieldset>