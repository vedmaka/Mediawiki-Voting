<?php if ( !defined( 'MEDIAWIKI' ) ) die( 'Not an entry point.' ); ?>

<? if(isset($error)): ?>
<div class="alert alert-error">
<?=@$error?>
</div>
<? endif; ?>

<form class="form-horizontal" method="post">
    <fieldset>
        <legend><?=wfMsg('voting-specialgroup-create-title')?></legend>

        <div class="control-group">
            <label class="control-label" for="name"><?=wfMsg('voting-specialgroup-create-input-name')?></label>
            <div class="controls">
                <input type="text" class="input-xlarge" id="name" name="name">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="title"><?=wfMsg('voting-specialgroup-create-input-title')?></label>
            <div class="controls">
                <input type="text" class="input-xlarge" id="title" name="title">
                <p class="help-block">
                    <?=wfMsg('voting-specialgroup-create-input-title-help')?>
                </p>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="description"><?=wfMsg('voting-specialgroup-create-input-description')?></label>
            <div class="controls">
                <input type="text" class="input-xxlarge" id="description" name="description">
                <p class="help-block">
                    <?=wfMsg('voting-specialgroup-create-input-description-help')?>
                </p>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="result_message"><?=wfMsg('voting-specialgroup-create-input-result_message')?></label>
            <div class="controls">
                <input type="text" class="input-xxlarge" id="result_message" name="result_message">
                <p class="help-block">
                    <?=wfMsg('voting-specialgroup-create-input-result_message-help')?>
                </p>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="category"><?=wfMsg('voting-specialgroup-create-input-category')?></label>
            <div class="controls">

                <div>
                <select id="category" name="category[]" class="category-select">

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

            </div>
        </div>

        <div class="control-group" style="display: none;">
            <label class="control-label" for="rule_id"><?=wfMsg('voting-specialgroup-input-rule')?></label>
            <div class="controls">
                <select id="rule_id" name="rule_id">

                    <option value="-1" selected>---</option>

                    <? foreach($rules as $rule): ?>

                        <option value="<?=$rule->getId()?>"><?=$rule->name?></option>

                    <? endforeach; ?>

                </select>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="active"><?=wfMsg('voting-specialgroup-create-input-active')?></label>
            <div class="controls">
                <select id="active" name="active">
                    <option value="1" selected>
                        <?=wfMsg('voting-specialgroup-create-input-active-1')?>
                    </option>
                    <option value="0">
                        <?=wfMsg('voting-specialgroup-create-input-active-0')?>
                    </option>
                </select>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?=wfMsg('voting-specialgroup-create-input-submit')?></button>
        </div>

    </fieldset>
</form>