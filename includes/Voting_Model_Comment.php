<?php
/**
 * Voting value model.
 *
 * @file Voting_Model_Comment.php
 * @ingroup Voting
 *
 * @licence GNU GPL v3 or later
 * @author Vedmaka < god.vedmaka@gmail.com >
 *
 * Declare properties from $properties array below:
 * @property int $user_id Related rating id
 * @property int $page_id Related page id
 * @property int $group_id Related group id
 * @property string $hash Voting value
 * @property string $comment Voted user id
 *
 */
class Voting_Model_Comment extends Voting_Model
{

    /* Table */
    protected static $table = 'wv_voting_comments';

    /* Columns (except `id`)
    *  Notice: `id` column is required and has auto-increment flag.
    *  Supported types: int, string
    */
    protected $properties = array(
        'user_id'  => 'int',
        'page_id'  => 'int',
        'group_id' => 'int',
        'hash'      => 'string',
        'comment'    => 'string',
    );

}
