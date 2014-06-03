<?php

class VotingSummaryJob extends Job
{
    public function __construct( $title, $params )
    {
        // Replace synchroniseThreadArticleData with an identifier for your job.
        parent::__construct( 'wikivoteVotingSummary', $title, $params );
    }

    /**
     * Execute the job
     *
     * @return bool
     */
    public function run()
    {
        // Load data from $this->params and $this->title
        $article = new Article($this->title, 0);

        //This can be rewrited via WikivoteORM
        $this->oldWaySummary();

        return true;
    }

    private function oldWaySummary()
    {

        $pageId = $this->title->getArticleID();
        $dbr = wfGetDB( DB_MASTER );

        $dbr->query( 'DELETE FROM wv_voting_page_summary WHERE page_id = ' . $pageId );

        /* Summary */
        $summary = array();

        //without revision
        $rVotes = $dbr->query( 'SELECT rating_id,group_id,user_id,value FROM wv_voting_values WHERE page_id = ' . $pageId );

        while ( $rowVote = $dbr->fetchRow( $rVotes ) ) {

            if ( isset($summary[$rowVote['group_id']][$rowVote['rating_id']]) ) {
                $summary[$rowVote['group_id']][$rowVote['rating_id']]['summary'] += $rowVote['value'];
                $summary[$rowVote['group_id']][$rowVote['rating_id']]['count'] += 1;
            } else {
                $summary[$rowVote['group_id']][$rowVote['rating_id']]['summary'] = $rowVote['value'];
                $summary[$rowVote['group_id']][$rowVote['rating_id']]['count'] = 1;
            }

        }

        foreach ( $summary as $groupId => $arrRating ) {

            foreach ( $arrRating as $ratingId => $arrValues ) {

                $sumRuleValue = $arrValues['summary'] / $arrValues['count'];

                $rTitle = $dbr->query( 'SELECT name FROM wv_voting_ratings WHERE id = ' . $ratingId );
                $title = $dbr->fetchRow( $rTitle );
                $title = $title['name'];

                //Save summary
                $dbr->query( "INSERT INTO wv_voting_page_summary VALUES(null, $pageId, $groupId, $ratingId, '*', $sumRuleValue, '$title')" );

            }

        }

        unset($summary);
    }
}