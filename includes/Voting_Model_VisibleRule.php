<?php
/**
 * Voting value model.
 *
 * @file Voting_Model_VisibleRule.php
 * @ingroup Voting
 *
 * @licence GNU GPL v3 or later
 * @author Vedmaka < god.vedmaka@gmail.com >
 *
 * Declare properties from $properties array below:
 * @property string $name Visible rule name
 * @property string $value Visible rule array with keys - groups, values = array of groups
 *
 */
class Voting_Model_VisibleRule extends Voting_Model
{

    /* Table */
    protected static $table = 'wv_voting_visible_rules';

    /* Columns (except `id`)
    *  Notice: `id` column is required and has auto-increment flag.
    *  Supported types: int, string
    */
    protected $properties = array(
        'name'  => 'string',
        'value' => 'string'
    );

    /**
     * Getter for value, unserialize array from string
     * @param $value
     * @return mixed
     */
    protected function _getValue( $value ) {

        return unserialize($value);

    }

    /**
     * Setter for value, serialize array to string
     * @param $value
     * @return string
     */
    protected function _setValue( $value ) {

        if(!is_array($value)) $value = array();
        return serialize($value);

    }

}
