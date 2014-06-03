<?php
/**
 * Voting rating model.
 *
 * @file Voting_Model_Rating.php
 * @ingroup Voting
 *
 * @licence GNU GPL v3 or later
 * @author Vedmaka < god.vedmaka@gmail.com >
 *
 * Declare properties from $properties array below:
 * @property int $group_id Related group id
 * @property int $name Name of rating
 * @property int $type_id Related type id
 * @property string $description Rating description
 *
 */
class Voting_Model_Rating extends Voting_Model
{

    /* Table */
    protected static $table = 'wv_voting_ratings';

    /* Columns (except `id`)
    *  Notice: `id` column is required and has auto-increment flag.
    *  Supported types: int, string
    */
    protected $properties = array(
        'group_id'  => 'int',
        'name'      => 'string',
        'type_id'   => 'int',
        'description' => 'string'
    );

}
