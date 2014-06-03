<?php if ( !defined( 'MEDIAWIKI' ) ) die( 'Not an entry point.' ); ?>

<? if(isset($error)): ?>
<div class="alert alert-error">
    <?=@$error?>
</div>
<? endif; ?>

<form class="form-horizontal" method="post">
    <fieldset>
        <legend><?=wfMsg('voting-specialgroup-edit-title', $group->name)?></legend>

        <div class="control-group">
            <label class="control-label" for="name"><?=wfMsg('voting-specialgroup-create-input-name')?></label>
            <div class="controls">
                <input type="text" class="input-xlarge" id="name" name="name" value="<?=$group->name?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="title"><?=wfMsg('voting-specialgroup-create-input-title')?></label>
            <div class="controls">
                <input type="text" class="input-xlarge" id="title" name="title" value="<?=$group->title?>">
                <p class="help-block">
                    <?=wfMsg('voting-specialgroup-create-input-title-help')?>
                </p>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="description"><?=wfMsg('voting-specialgroup-create-input-description')?></label>
            <div class="controls">
                <input type="text" class="input-xxlarge" id="description" name="description" value="<?=$group->description?>">
                <p class="help-block">
                    <?=wfMsg('voting-specialgroup-create-input-description-help')?>
                </p>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="result_message"><?=wfMsg('voting-specialgroup-create-input-result_message')?></label>
            <div class="controls">
                <input type="text" class="input-xxlarge" id="result_message" name="result_message" value="<?=$group->result_message?>">
                <p class="help-block">
                    <?=wfMsg('voting-specialgroup-create-input-result_message-help')?>
                </p>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="category"><?=wfMsg('voting-specialgroup-create-input-category')?></label>
            <div class="controls">

                <? if ( !count($group->category) ): ?>

                        <div class="category-select" name="category[]" id="category-select" >
                            <select id="category" name="category[]" >

                                <? foreach($categories as $id => $title):?>
                                <? $cTitle = Category::newFromID($id)->getTitle()->getBaseText(); ?>

                                <option value="<?=$cTitle?>">
                                    <?=$cTitle?>
                                </option>

                                <? endforeach; ?>

                            </select>
                            <p class="help-block">
                                <?=wfMsg('voting-specialgroup-create-input-category-help')?>
                            </p>
                        </div>

                <? else: ?>

                    <?
                    $c = 0;
                    foreach( $group->category as $cat ): ?>

                        <div class="<?=($c>0) ? 'multilized' : 'category-select' ?>" name="category[]" id="category-select-clone-<?=$c?>" >
                            <select id="category-clone-<?=$c+1?>" name="category[]">

                                <? foreach($categories as $id => $title):?>
                                <? $cTitle = Category::newFromID($id)->getTitle()->getBaseText(); ?>

                                <option value="<?=$cTitle?>" <?=($cTitle==$cat) ? 'selected' : ''?>>
                                    <?=$cTitle?>
                                </option>

                                <? endforeach; ?>

                            </select>
                        </div>

                    <?
                    $c++;
                    endforeach; ?>

                <? endif; ?>

            </div>
        </div>

        <div class="control-group" style="display: none;">
            <label class="control-label" for="rule_id"><?=wfMsg('voting-specialgroup-input-rule')?></label>
            <div class="controls">
                <select id="rule_id" name="rule_id">

                    <option value="-1">---</option>

                    <? foreach($rules as $rule): ?>

                    <option value="<?=$rule->getId()?>" <?=($group->rule_id == $rule->getId()) ? 'selected' : ''?>><?=$rule->name?></option>

                    <? endforeach; ?>

                </select>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="active"><?=wfMsg('voting-specialgroup-create-input-active')?></label>
            <div class="controls">
                <select id="active" name="active">
                    <option value="1" <?=($group->active) ? 'selected' : '' ?> >
                        <?=wfMsg('voting-specialgroup-create-input-active-1')?>
                    </option>
                    <option value="0" <?=(!$group->active) ? 'selected' : '' ?> >
                        <?=wfMsg('voting-specialgroup-create-input-active-0')?>
                    </option>
                </select>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?=wfMsg('voting-specialgroup-edit-input-submit')?></button>
        </div>

    </fieldset>
</form>