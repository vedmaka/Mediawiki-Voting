<?php if ( !defined( 'MEDIAWIKI' ) ) die( 'Not an entry point.' ); ?>

<table class="wikivote-table table table-bordered">

    <thead>

        <th>
            <?=wfMsg('voting-specialcolumn-group-id')?>
        </th>

        <th>
            <?=wfMsg('voting-specialcolumn-group-name')?>
        </th>

        <th>
            <?=wfMsg('voting-specialcolumn-group-category')?>
        </th>

        <th>
            <?=wfMsg('voting-specialcolumn-group-active')?>
        </th>

        <th>
            <?=wfMsg('voting-specialcolumn-group-actions')?>
        </th>

    </thead>

    <tbody>

    <?foreach( $groups as $group ):?>

        <tr>

            <td>
                <?= $group->getId() ?>
            </td>

            <td>
                <a href="<?=$this->getActionURL('group/view', $group->getId())?>">
                    <?= $group->name ?>
                </a><br>
                <?= $group->title ?>
            </td>

            <td>
                <ul>
                <?foreach ($group->category as $category):
                    $title = Title::newFromText($category, NS_CATEGORY);
                    ?>
                    <li>
                        <a href="<?=$title->getFullURL()?>">
                            <?=$title->getBaseText()?>
                        </a>
                    </li>
                <?endforeach;?>
                </ul>
            </td>

            <td>
                <?=($group->active) ? wfMsg('voting-specialcolumn-group-active-1')
                : wfMsg('voting-specialcolumn-group-active-0') ?>
            </td>

            <td>

                <a href="<?= $this->getActionURL( 'group/edit', $group->getId() ) ?>">
                    <?= wfMsg('voting-speciallink-group-edit') ?>
                </a>

                <span>|</span>

                <a href="<?= $this->getActionURL( 'group/delete', $group->getId() ) ?>" onclick="return confirm('<?=wfMsg('wikivotevoting-js-link-confirm-delete')?>');">
                    <?= wfMsg('voting-speciallink-group-delete') ?>
                </a>

            </td>

        </tr>

    <?endforeach;?>

    </tbody>

</table>
