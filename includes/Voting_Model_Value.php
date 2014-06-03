<?php
/**
 * Voting value model.
 *
 * @file Voting_Model_Value.php
 * @ingroup Voting
 *
 * @licence GNU GPL v3 or later
 * @author Vedmaka < god.vedmaka@gmail.com >
 *
 * Declare properties from $properties array below:
 * @property int $rating_id Related rating id
 * @property int $value Voting value
 * @property int $user_id Voted user id
 * @property int $vote_time Voting time timestamp. Current timestamp by default
 * @property int $page_id Page id
 * @property int $revision_id Revision id
 * @property int $group_id Group id
 * @property int $value_id Voting value id
 *
 */
class Voting_Model_Value extends Voting_Model
{

    /* Table */
    protected static $table = 'wv_voting_values';

    /* Columns (except `id`)
    *  Notice: `id` column is required and has auto-increment flag.
    *  Supported types: int, string
    */
    protected $properties = array(
        'rating_id'  => 'int',
        'value'      => 'int',
        'user_id'    => 'int',
        'vote_time'  => 'timestamp',
        'page_id'    => 'int',
        'revision_id'=> 'int',
        'group_id'   => 'int',
        'value_id'   => 'int',
        'hash'       => 'string'
    );

}
