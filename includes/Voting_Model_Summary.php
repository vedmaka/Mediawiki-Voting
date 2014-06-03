<?php
/**
 * Voting rating model.
 *
 * @file Voting_Model_Summary.php
 * @ingroup Voting
 *
 * @licence GNU GPL v3 or later
 * @author Vedmaka < god.vedmaka@gmail.com >
 *
 * Declare properties from $properties array below:
 * @property int $page_id Page id
 * @property int $group_id Group id
 * @property int $rating_id Rating id
 * @property string $rule_key Visibility for mw group
 * @property int $summary Summary
 * @property string $title Title of widget
 *
 */
class Voting_Model_Summary extends Voting_Model
{

    /* Table */
    protected static $table = 'wv_voting_page_summary';

    /* Columns (except `id`)
    *  Notice: `id` column is required and has auto-increment flag.
    *  Supported types: int, string
    */
    protected $properties = array(
        'page_id'      => 'int',
        'group_id'      => 'int',
        'rating_id'      => 'int',
        'rule_key'      => 'string',
        'summary'      => 'int',
        'title'      => 'string',
    );

}
