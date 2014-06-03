<?php
/**
 * Voting rating model.
 *
 * @file Voting_Model_Type.php
 * @ingroup Voting
 *
 * @licence GNU GPL v3 or later
 * @author Vedmaka < god.vedmaka@gmail.com >
 *
 * Declare properties from $properties array below:
 * @property int $control_id Type of input
 * @property int $name Name of rating
 *
 */
class Voting_Model_Type extends Voting_Model
{

    /* Table */
    protected static $table = 'wv_voting_types';

    /* Columns (except `id`)
    *  Notice: `id` column is required and has auto-increment flag.
    *  Supported types: int, string
    */
    protected $properties = array(
        'name'      => 'string',
        /*
        * Type of rating input. Only affects visual representation. Values stored as integer.
        * 0 or null - default stars
        * 1 - select
        * 2 - switch
        * 3 - checkboxes
        * TODO: make it extensible such as semantic inputs
        */
        'control_id'=> 'int',
        /*
         * 0 - Raw numbers
         * 1 - Stars
         * 2 - Bar
         */
        'view_format'=> 'int'
    );

}
