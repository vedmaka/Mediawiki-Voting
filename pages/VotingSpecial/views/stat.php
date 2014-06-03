<?php if ( !defined( 'MEDIAWIKI' ) ) die( 'Not an entry point.' ); ?>

<fieldset xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
        <legend><?=wfMsg('voting-specialstat-title')?></legend>

<? foreach($values as $value):

    /* Fetch info */
    $group = new Voting_Model_Group($value->group_id);
    $rating = new Voting_Model_Rating($value->rating_id);
    $page = Title::newFromID($value->page_id);
    $revision = Revision::newFromId($value->revision_id);
    $votingValue = new Voting_Model_TypeValue($value->value_id);
    $user = User::newFromId($value->user_id);

    ?>

    <div class="wvw-stat-bit">
        Время: <?=$value->vote_time?><br>
        Пользователь: <a href="<?=$user->getUserPage()->getFullURL()?>"><?=$user->getName()?></a><br>
        Группа голосования: <a href="<?=$this->getActionURL('group/view', $value->group_id)?>"</a><?=$group->name?></a><br>
        Страница: <a href="<?=$page->getFullURL()?>"><?=$page->getBaseText()?></a><br>
        Голос:  <?=$votingValue->title?> (<?=$value->value?>)
    </div>

<?

    unset($group);
    unset($rating);
    unset($page);
    unset($revision);
    unset($value);
    unset($user);

endforeach; ?>

</fieldset>