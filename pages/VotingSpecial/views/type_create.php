<?php if ( !defined( 'MEDIAWIKI' ) ) die( 'Not an entry point.' ); ?>

<? if(isset($error)): ?>
<div class="alert alert-error">
    <?=@$error?>
</div>
<? endif; ?>

<form class="form-horizontal" method="post">
    <fieldset>
        <legend><?=wfMsg('voting-specialtype-create-title')?></legend>

        <div class="control-group">
            <label class="control-label" for="name"><?=wfMsg('voting-specialtype-create-input-name')?></label>
            <div class="controls">
                <input type="text" class="input-xlarge" id="name" name="name">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="control_id"><?=wfMsg('voting-specialtype-create-input-control-id')?></label>
            <div class="controls">
                <select class="input-xlarge" id="control_id" name="control_id">

                    <option value="0" selected ><?=wfMsg('voting-specialtype-create-input-control-id-0')?></option>
                    <option value="1"><?=wfMsg('voting-specialtype-create-input-control-id-1')?></option>
                    <option value="2"><?=wfMsg('voting-specialtype-create-input-control-id-2')?></option>
                    <option value="3"><?=wfMsg('voting-specialtype-create-input-control-id-3')?></option>
                    <option value="4"><?=wfMsg('voting-specialtype-create-input-control-id-4')?></option>

                </select>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="name"><?=wfMsg('voting-specialtype-create-input-values')?></label>
            <div class="controls">

                <div class="category-select" id="type_title_value_holder" name="type_title_value_holder[]" >

                    <input type="text" id="type_values_title" name="type_values_title[]"
                           placeholder="<?=wfMsg('voting-specialtype-create-input-values-title')?>">

                    <input type="text" id="type_values_value" name="type_values_value[]"
                           placeholder="<?=wfMsg('voting-specialtype-create-input-values-value')?>">

                </div>

            </div>
        </div>

    </fieldset>

    <fieldset>
        <legend><?=wfMsg('voting-specialtype-type-display-title')?></legend>

        <div class="control-group">
            <label class="control-label" for="view_format"><?=wfMsg('voting-type-create-view-format')?></label>
            <div class="controls">

                <select class="input-xlarge" name="view_format" id="view_format">

                    <option value="0" selected ><?=wfMsg('voting-type-create-0')?></option>
                    <option value="1"><?=wfMsg('voting-type-create-1')?></option>
                    <option value="2"><?=wfMsg('voting-type-create-2')?></option>
                    <option value="3"><?=wfMsg('voting-type-create-3')?></option>

                </select>

            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?=wfMsg('voting-specialgroup-create-input-submit')?></button>
        </div>

    </fieldset>
</form>