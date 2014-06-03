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
 * @property string $title Type of input
 * @property string $value Name of rating
 * @property int $type_id Name of rating
 *
 */
class Voting_Model_TypeValue extends Voting_Model
{

    /* Table */
    protected static $table = 'wv_voting_types_values';

    /* Columns (except `id`)
    *  Notice: `id` column is required and has auto-increment flag.
    *  Supported types: int, string
    */
    protected $properties = array(
        'title'      => 'string',
        'value'      => 'string',
        /*
        * Type of rating input. Only affects visual representation. Values stored as integer.
        * 0 or null - default stars
        * 1 - select
        * 2 - switch
        * TODO: make it extensible such as semantic inputs
        */
        'type_id'=> 'int',
    );

}
