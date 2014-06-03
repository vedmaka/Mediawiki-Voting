<?php if ( !defined( 'MEDIAWIKI' ) ) die( 'Not an entry point.' ); ?>

<? if(isset($error)): ?>
<div class="alert alert-error">
    <?=@$error?>
</div>
<? endif; ?>

<form class="form-horizontal" method="post">
    <fieldset>
        <legend><?=wfMsg('voting-specialrating-edit-title', $rating->name )?></legend>

        <div class="control-group">
            <label class="control-label" for="name"><?=wfMsg('voting-specialrating-create-input-name')?></label>
            <div class="controls">
                <input type="text" class="input-xlarge" id="name" name="name" value="<?=$rating->name?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="desc"><?=wfMsg('voting-specialrating-create-input-desc')?></label>
            <div class="controls">
                <input type="text" class="input-xlarge" id="desc" name="description" value="<?=$rating->description?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="desc"><?=wfMsg('voting-specialrating-create-input-typeid')?></label>
            <div class="controls">
                <select class="input-xlarge" id="type_id" name="type_id">

                    <? foreach($widgetTypes as $type): ?>
                        <option value="<?=$type->getId()?>" <?=($rating->type_id==$type->getId()) ? 'selected' : ''?> ><?=$type->name?></option>
                    <?endforeach;?>

                </select>
                <span class="wvw-span-right">
                    <a href="<?=$this->getActionURL('type/edit', $rating->type_id)?>">
                        <?=wfMsg('voting-specialrating-create-input-typeid-edit')?>
                    </a>
                </span>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="name"><?=wfMsg('voting-specialrating-create-input-group')?></label>
            <div class="controls">
                <select name="group_id">
                    <? foreach( $groups as $group ): ?>
                    <option value="<?=$group->getId()?>" <?=($group->getId()==$rating->group_id) ? 'selected' : ''?> >
                        <?=$group->name?>
                    </option>
                    <? endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?=wfMsg('voting-specialgroup-edit-input-submit')?></button>
        </div>

    </fieldset>
</form>