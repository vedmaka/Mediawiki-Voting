<?php if ( !defined( 'MEDIAWIKI' ) ) die( 'Not an entry point.' ); ?>

<? if(isset($error)): ?>
<div class="alert alert-error">
    <?=@$error?>
</div>
<? endif; ?>

<? if (!count($widgetTypes)): ?>
<div class="alert alert-error">
    <?=wfMsg('voting-voting-special-rating-create-notypes')?>
    <a href="<?=$this->getActionURL('type/create')?>">
        <?=wfMsg('voting-voting-special-rating-create-notypes')?>
    </a>.
</div>
<?
    return;
endif;
?>

<form class="form-horizontal" method="post">
    <fieldset>
        <legend><?=wfMsg('voting-special-rating-create-title')?></legend>

        <div class="control-group">
            <label class="control-label" for="name"><?=wfMsg('voting-special-rating-create-input-name')?></label>
            <div class="controls">
                <input type="text" class="input-xlarge" id="name" name="name">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="desc"><?=wfMsg('voting-special-rating-create-input-desc')?></label>
            <div class="controls">
                <input type="text" class="input-xlarge" id="desc" name="description">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="desc"><?=wfMsg('voting-special-rating-create-input-typeid')?></label>
            <div class="controls">
                <select class="input-xlarge" id="type_id" name="type_id">

                    <? foreach($widgetTypes as $type): ?>
                        <option value="<?=$type->getId()?>"><?=$type->name?></option>
                    <?endforeach;?>

                </select>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="group_id"><?=wfMsg('voting-special-rating-create-input-group')?></label>
            <div class="controls">
                <select name="group_id" id="group_id">
                <? foreach( $groups as $group ): ?>
                    <option value="<?=$group->getId()?>" <?=($group->getId()==$group_id) ? 'selected' : ''?> >
                        <?=$group->name?>
                    </option>
                <? endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?=wfMsg('voting-special-group-create-input-submit')?></button>
        </div>

    </fieldset>
</form>