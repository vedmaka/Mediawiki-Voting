<?php
/**
 * Voting group model.
 *
 * @file Voting_Model_Group.php
 * @ingroup Voting
 *
 * @licence GNU GPL v3 or later
 * @author Vedmaka < god.vedmaka@gmail.com >
 *
 * Declare properties from $properties array below:
 * @property string $name Name of voting group
 * @property array $category Category which group applied
 * @property bool $active Group state
 * @property string $title Widget title
 * @property string $description Widget description
 * @property string $result_message Result message
 *
 */
class Voting_Model_Group extends Voting_Model
{

    /* Table */
    protected static $table = 'wv_voting_groups';

    /* Columns (except `id`)
    *  Notice: `id` column is required and has auto-increment flag.
    *  Supported types: int, string
    */
    protected $properties = array(
        'name'      => 'string',
        'category'  => 'string',
        'active'    => 'int',
        'title'     => 'string',
        'description'   => 'string',
        'result_message' => 'string',
        'rule_id'   => 'int'
    );

    /**
     * Override category set. Converts categories array to string
     * @param string|array $value
     * @return string
     */
    protected function _setCategory( $value )
    {
        /* Array of categories passed */
        if (is_array($value)) {
            return implode(',', $value);
        }

        return $value;
    }

    /**
     * Override category get. Returns categories string as array
     * @param $value
     * @return array
     */
    protected function _getCategory( $value ) {

        return explode(',', $value);

    }
}
