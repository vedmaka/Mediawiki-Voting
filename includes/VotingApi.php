<?php
/**
 * Wikivote voting api
 *
 * @file VotingApi.php
 * @ingroup
 *
 * @licence GNU GPL v3 or later
 * @author Vedmaka < god.vedmaka@gmail.com >
 */
class VotingApi extends ApiBase
{

    /**
     * Constructor
     * @param ApiMain $query
     * @param string $moduleName
     */
    public function __construct( $query, $moduleName ) {
        parent::__construct( $query, $moduleName );
    }

    public function execute() {

        global $wgUser, $wgOut;

        $params = $this->extractRequestParams();

        $data = array();
        $formattedData = array(
            'status' => 'error',
            'data' => array()
        );

        $do = $params['do'];
        $group_id = $params['group_id'];
        $page_id = $params['page_id'];
        $revision_id = $params['revision_id'];
        $votes = $params['votes'];
        $ratings = $params['ratings'];

        //Comments
        $comment = $params['comment'];

        switch($do) {

            /* Fetch ratings */
            case 'fetch':

                /*if ( Voting::isUserVoted( $group_id, $page_id, $revision_id, $wgUser->getId() ) ) {

                    $formattedData['status'] = 'already_voted';

                }else{

                    $data = Voting::fetchRatings($group_id, $wgUser->getId() );

                    foreach ( $data as $value ) {
                        $formattedData['data'][] = array(
                            'name' => $value->name,
                            'type_id' => $value->type_id,
                            'group_id' => $value->group_id
                        );
                    }
                    $formattedData['status'] = 'ok';

                }*/

            break;

            /* Store ratings */
            case 'store':


                $status = Voting::storeRatings( $group_id, $page_id, $revision_id, $wgUser->getId(), $ratings, $votes, false, $comment );

                if ($status != 'error') {
                    $mStat = 'success';
                }

                $formattedData['status'] = $mStat;
                $formattedData['data'] = array(
                    'message' => $status
                );

            break;

        }

        // Set top-level elements.
        $result = $this->getResult();
        #$result->setIndexedTagName( $formattedData, 'p' );
        $result->addValue( null, $this->getModuleName(), $formattedData );

    }

    /**
     * Allowed params
     * @return array|bool
     */
    protected function getAllowedParams() {
        return array (
            'group_id' => array(
                ApiBase::PARAM_TYPE => 'integer'
            ),
            'do' => array(
                ApiBase::PARAM_TYPE => 'string'
            ),
            'ratings' => array(
                ApiBase::PARAM_TYPE => 'string'
            ),
            'votes' => array(
                ApiBase::PARAM_TYPE => 'string'
            ),
            'page_id' => array(
                ApiBase::PARAM_TYPE => 'integer'
            ),
            'revision_id' => array(
                ApiBase::PARAM_TYPE => 'integer'
            ),
            'comment' => array(
                ApiBase::PARAM_TYPE => 'string'
            )
        );
    }

    /**
     * Params description
     * @return array|bool
     */
    protected function getParamDescription() {
        return array (
            'do' => 'Action',
            'group_id' => 'GroupID',
            'ratings' => 'Ratings'
        );
    }

    /**
     * Description
     * @return mixed|string
     */
    protected function getDescription() {
        return 'VotingApi';
    }

    /**
     * Examples
     * @return array|bool|string
     */
    protected function getExamples() {
        return array (
            'api.php?action=wikivotevoting&do=fetch&page_id=4&revision_id=4&group_id=4',
            'api.php?action=wikivotevoting&do=store&page_id=12&group_id=4&ratings=0,2,3,1'
        );
    }

    /**
     * Version
     * @return string
     */
    public function getVersion() {
        return __CLASS__ ;
    }

}
