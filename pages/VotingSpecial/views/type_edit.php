<?php if ( !defined( 'MEDIAWIKI' ) ) die( 'Not an entry point.' ); ?>

<? if(isset($error)): ?>
<div class="alert alert-error">
    <?=@$error?>
</div>
<? endif; ?>

<form class="form-horizontal" method="post">
    <fieldset>
        <legend><?=wfMsg('voting-specialtype-edit-title', $type->name)?></legend>

        <div class="control-group">
            <label class="control-label" for="name"><?=wfMsg('voting-specialtype-create-input-name')?></label>
            <div class="controls">
                <input type="text" class="input-xlarge" id="name" name="name" value="<?=$type->name?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="control_id"><?=wfMsg('voting-specialtype-create-input-control-id')?></label>
            <div class="controls">
                <select class="input-xlarge" id="control_id" name="control_id">

                    <option value="0" <?=($type->control_id==0) ? 'selected' : ''?> ><?=wfMsg('voting-specialtype-create-input-control-id-0')?></option>
                    <option value="1" <?=($type->control_id==1) ? 'selected' : ''?> ><?=wfMsg('voting-specialtype-create-input-control-id-1')?></option>
                    <option value="2" <?=($type->control_id==2) ? 'selected' : ''?> ><?=wfMsg('voting-specialtype-create-input-control-id-2')?></option>
                    <option value="3" <?=($type->control_id==3) ? 'selected' : ''?> ><?=wfMsg('voting-specialtype-create-input-control-id-3')?></option>
                    <option value="4" <?=($type->control_id==4) ? 'selected' : ''?> ><?=wfMsg('voting-specialtype-create-input-control-id-4')?></option>

                </select>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="name"><?=wfMsg('voting-specialtype-create-input-values')?></label>
            <div class="controls">

            <? if(!count($typeValues)): ?>

                <div class="category-select" id="type_title_value_holder" name="type_title_value_holder[]" >

                    <input type="text" id="type_values_title" name="type_values_title[]"
                           placeholder="<?=wfMsg('voting-specialtype-create-input-values-title')?>">

                    <input type="text" id="type_values_value" name="type_values_value[]"
                           placeholder="<?=wfMsg('voting-specialtype-create-input-values-value')?>">

                </div>

            <? else: ?>

                <?
                $c = 0;
                foreach($typeValues as $typeValue): ?>

                    <div class="<?=($c>0) ? 'multilized' : 'category-select'?>" id="type_title_value_holder" name="type_title_value_holder[]" >

                        <input type="text" id="type_values_title" name="type_values_title[]"
                               placeholder="<?=wfMsg('voting-specialtype-create-input-values-title')?>" value="<?=$typeValue->title?>">

                        <input type="text" id="type_values_value" name="type_values_value[]"
                               placeholder="<?=wfMsg('voting-specialtype-create-input-values-value')?>" value="<?=$typeValue->value?>">

                        <input type="hidden" id="type_values_id" name="type_values_id[]" value="<?=$typeValue->getId()?>">

                    </div>


                <?
                $c++;
                endforeach; ?>

            <? endif; ?>

            </div>
        </div>

    </fieldset>

    <fieldset>
        <legend>Настройка отображения</legend>

        <div class="control-group">
            <label class="control-label" for="view_format" ><?=wfMsg('voting-type-create-view-format')?></label>
            <div class="controls">

                <select class="input-xlarge" name="view_format" id="view_format" >

                    <option value="0" <?=($type->view_format==0) ? 'selected' : ''?> >Число</option>
                    <option value="1" <?=($type->view_format==1) ? 'selected' : ''?> >Звезды</option>
                    <option value="2" <?=($type->view_format==2) ? 'selected' : ''?> >Шкала</option>
                    <option value="3" <?=($type->view_format==3) ? 'selected' : ''?> >Больше-Меньше</option>
                    <option value="4" <?=($type->view_format==4) ? 'selected' : ''?> >Кружочки</option>

                </select>

            </div>
        </div>


        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?=wfMsg('voting-specialgroup-edit-input-submit')?></button>
        </div>

    </fieldset>

</form>