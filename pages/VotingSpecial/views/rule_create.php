<?php if ( !defined( 'MEDIAWIKI' ) ) die( 'Not an entry point.' ); ?>

<? if(isset($error)): ?>
<div class="alert alert-error">
    <?=@$error?>
</div>
<? endif; ?>

<form class="form-horizontal" method="post">
    <fieldset>
        <legend><?=wfMsg('voting-specialrule-create-title')?></legend>

        <div class="control-group">
            <label class="control-label" for="name"><?=wfMsg('voting-specialrule-create-input-name')?></label>
            <div class="controls">
                <input type="text" class="input-xlarge" id="name" name="name">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"><?=wfMsg('voting-specialrule-create-input-groups-title')?></label>
            <div class="controls">

            <table class="table">
                <thead>
                <th>Группе</th>
                <th>Доступны оценки группы</th>
                </thead>

            <? foreach($wikiGroups as $group): ?>


                    <tr>

                    <td>
                        <b><?=$group?></b>
                    </td>

                    <td>
                    <? foreach($wikiGroups as $group2): ?>
                        <div>
                            <input type="checkbox" name="value[<?=$group?>][]" value="<?=$group2?>" />
                            <?=$group2?>
                        </div>
                    <? endforeach; ?>
                    </td>

                    </tr>


            <? endforeach; ?>

            </table>

            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?=wfMsg('voting-specialgroup-create-input-submit')?></button>
        </div>

    </fieldset>
</form>