<?php if ( !defined( 'MEDIAWIKI' ) ) die( 'Not an entry point.' ); ?>

<fieldset>
    <legend><?=wfMsg('voting-specialtype-view-title')?></legend><br>

    <table class="wikivote-table table table-bordered">

        <thead>
        <th><?=wfMsg('voting-specialcolumn-type-id')?></th>
        <th><?=wfMsg('voting-specialcolumn-type-name')?></th>
        <th><?=wfMsg('voting-specialcolumn-type-control-id')?></th>
        <th><?=wfMsg('voting-specialcolumn-rating-actions')?></th>
        </thead>

        <tbody>

        <? foreach($widgetTypes as $widget): ?>

        <tr>
            <td><?=$widget->getId()?></td>
            <td><?=$widget->name?></td>
            <td>
                <?
                switch($widget->control_id) {
                    case 0:
                        echo wfMsg('voting-specialtype-create-input-control-id-0');
                    break;
                    case 1:
                        echo wfMsg('voting-specialtype-create-input-control-id-1');
                    break;
                    case 2:
                        echo wfMsg('voting-specialtype-create-input-control-id-2');
                    break;
                    case 3:
                        echo wfMsg('voting-specialtype-create-input-control-id-3');
                    break;
					case 4:
						echo wfMsg('voting-specialtype-create-input-control-id-4');
					break;
                }
                ?>
            </td>
            <td>

                <a href="<?= $this->getActionURL( 'type/edit', $widget->getId() ) ?>">
                    <?= wfMsg('voting-speciallink-group-edit') ?>
                </a>

                <span>|</span>

                <a href="<?= $this->getActionURL( 'type/delete', $widget->getId() ) ?>"  onclick="return confirm('<?=wfMsg('voting-js-link-confirm-delete')?>');">
                    <?= wfMsg('voting-speciallink-group-delete') ?>
                </a>

            </td>
        </tr>

            <? endforeach; ?>

        </tbody>

    </table>

    <div class="form-actions">
        <a href="<?=$this->getActionURL('type/create' )?>" class="btn btn-primary">
            <?=wfMsg('voting-speciallink-create-widget-type')?>
        </a>
    </div>

</fieldset>