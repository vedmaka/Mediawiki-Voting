<?php
/**
 * Class declaration for mediawiki extension Voting
 *
 * @file Voting.class.php
 * @ingroup Voting
 */

class Voting
{

    /**
     * Fetch ratings list by group id
     * @static
     * @param $group_id
     */
    public static function fetchUserVotes( $group_id, $page_id, $revision_id, $user_id )
    {

        $votes = Voting_Model_Value::find( array(
            'group_id' => $group_id,
            'page_id' => $page_id,
            'revision_id' => $revision_id,
            'user_id' => $user_id
        ) );

        return $votes;

    }

    public static function fetchVotes( $group_id = null, $page_id, $revision_id, $group = false )
    {

        if ( $group_id === null ) {
            $votes = Voting_Model_Value::find( array(
                'page_id' => $page_id,
                'revision_id' => $revision_id,
            ) );
        } else {
            $votes = Voting_Model_Value::find( array(
                'group_id' => $group_id,
                'page_id' => $page_id,
                'revision_id' => $revision_id,
            ) );
        }

        if ( $group ) {
            // Group by hash
            //TODO: very slow
            $groupedVotes = array();
            foreach ( $votes as $vote ) {

                $groupedVotes[$vote->hash][] = $vote;

            }
            return $groupedVotes;
        }

        return $votes;

    }

    /**
     * Store ratings in db
     * @static
     * @param $group_id
     * @param $page_id
     * @param $revision_id
     * @param $user_id
     * @param $ratings
     * @param $votes
     * @return string
     */
    public static function storeRatings( $group_id, $page_id, $revision_id, $user_id, $ratings, $votes, $isUpdate = false, $comment = '' )
    {


        /* Check for anon
            TODO: handle it right way
        */
        $anon = User::newFromId( $user_id );
        if ( $anon->isAnon() ) return 'error, anonymous cant vote';

        $ratings = explode( ',', $ratings );
        $votes = explode( ',', $votes );

        /* Check if user already voted */
        if ( Voting::isUserVoted( $group_id, $page_id, $revision_id, $user_id ) ) {
            //return 'error, user already voted';
            $isUpdate = true;
        }

        /* Check if there is something wrong in passed arrays */
        if ( count( $ratings ) != count( $votes ) ) {
            return 'error, wrong arrays';
        }

        /* Check if passed data right */
        $group = new Voting_Model_Group($group_id);
        if ( $group->error ) {
            return 'error, no such group';
        }

        /* Check if page exists */
        if ( !Title::newFromID( $page_id )->exists() ) {
            return 'error, page not exist';
        }

        /* Check if revision exists and revision is current?
           TODO: decide, if we can vote only on current active revision or not ?
        */
        $article = Article::newFromID( $page_id );
        $history = new HistoryPage($article);
        $revs = $history->fetchRevisions( 100, 0, 0 );

        $in_array = false;
        foreach ( $revs as $row ) {
            if ( intval( $revision_id ) == $row->rev_id ) {
                $in_array = true;
            }
        }
        if ( !$in_array ) {
            return 'error, there are no such revision';
        }

        /* If revision_id = current revision */
        if ( intval( $revision_id ) != WikiPage::newFromID( $page_id )->getRevision()->getId() ) {
            return 'error, revision passed is not current page revision';
        }

        /* All checks passed, store values */

        $voteActionHash = uniqid();

        for ( $i = 0; $i < count( $ratings ); $i++ ) {

            $rating_id = intval( $ratings[$i] );
            $typeValue_id = intval( $votes[$i] );

            $rating = new Voting_Model_Rating($rating_id);
            if ( $rating->error ) return 'error, there is no rating entity with such id';

            /* Check if passed value related to passed rating */
            $typeValues = Voting_Model_TypeValue::find( array( 'type_id' => $rating->type_id ) );
            $in_array = false;
            foreach ( $typeValues as $tv ) {
                if ( $tv->getId() == $typeValue_id ) {
                    $in_array = true;
                }
            }
            if ( !$in_array ) {
                return 'error, this typeValue id is not related to passed rating';
            }

            /* Fetch passed typeValue */
            $typeValue = new Voting_Model_TypeValue($typeValue_id);
            if ( $typeValue->error ) return 'error, there is no typevalue entity with such id';

            if ( $isUpdate ) {

                /* Update exisiting voting value */
                $votingValue = Voting_Model_Value::find( array(
                    'user_id' => $user_id,
                    'page_id' => $page_id,
                    'rating_id' => $rating_id,
                    'group_id' => $group_id
                ) );

	            if( count($votingValue) ) {
		            $votingValue = $votingValue[0];
	            }else{
		            /* Create new voting value */
		            $votingValue = new Voting_Model_Value();
	            }

            } else {
                /* Create new voting value */
                $votingValue = new Voting_Model_Value();
            }

            $votingValue->rating_id = $rating->getId();
            $votingValue->value = $typeValue->value;
            $votingValue->user_id = $user_id;
            $votingValue->page_id = $page_id;
            $votingValue->revision_id = $revision_id;
            $votingValue->group_id = $group_id;
            $votingValue->value_id = $typeValue->getId();
            $votingValue->vote_time = time();

            $votingValue->hash = $voteActionHash;

            $votingValue->save();

            //Let other extensions see voting value saved
            // $VotingValue - Voting_Value model
            // $voteActionHash - Action hash
            wfRunHooks( 'wvVotingValueSave', array( $votingValue, $voteActionHash ) );

        }

        // Store comment
        if ( $comment != '' ) {
            if ( $isUpdate ) {
                $mComment = Voting_Model_Comment::find( array(
                    'user_id' => $user_id,
                    'page_id' => $page_id,
                    'group_id' => $group_id
                ) );
                if ( !$mComment ) {
                    $mComment = new Voting_Model_Comment();
                } else {
                    $mComment = $mComment[0];
                }
            } else {
                $mComment = new Voting_Model_Comment();
            }
            $mComment->comment = htmlspecialchars( $comment );
            $mComment->hash = $voteActionHash;
            $mComment->user_id = $user_id;
            $mComment->page_id = $page_id;
            $mComment->group_id = $group_id;

            wfRunHooks( 'wvVotingCommentSave', array( $mComment, $voteActionHash ) );

            $mComment->save();
        }

		//Push rc
		if ( class_exists( 'CustomVoting' ) ) {
			$rc_action = 'wv_vote';
			if ( $isUpdate ) {
				$rc_action = 'wv_change';
			}
			CustomVoting::pushRCEvent(
				Title::newFromID( $page_id ),
				$rc_action,
				wfMessage( 'voting-log-action-' . $rc_action )->text(),
				wfMessage( 'voting-log-comment', $comment )->text(),
				User::newFromId( $user_id )
			);
		}

        /* Create job */
        self::addVotingJob( Title::newFromID( $page_id ) );

        return $group->result_message;

    }

    public static function addVotingJob( Title $title )
    {
        $job = new VotingSummaryJob($title, array());
        if( class_exists('JobQueueGroup') ) {
            JobQueueGroup::singleton()->push( $job );
        }else{
            $job->insert();
        }
    }

    /**
     * Check user voted this group on this page with that revision or not
     * @static
     * @param $group_id
     * @param $page_id
     * @param $revision_id
     * @param null $user_id
     * @return bool
     */
    public static function isUserVoted( $group_id, $page_id, $revision_id, $user_id = null )
    {

        global $wgUser;

        if ( $user_id == null ) $user_id = $wgUser->getId();

        $ratings = Voting_Model_Rating::find( array( 'group_id' => $group_id ) );
        $votes = Voting_Model_Value::find( array(
            'page_id' => $page_id,
            'revision_id' => $revision_id,
            'user_id' => $user_id,
            'group_id' => $group_id
        ) );

        if ( count( $votes ) ) return true;

        return false;

    }

    /**
     * Returns widget for pages
     * @static
     * @return string
     */
    public static function getWidget()
    {

	    /** @var $wgTitle Title */
        global $wgUser, $wgOut, $wgTitle;

	    $wgArticle = Article::newFromID($wgTitle->getArticleID());

        /* Check namespace */
		if ( $wgOut->getTitle()->getNamespace() != NS_MAIN ) return '';

		/* Check action */
		if( $wgOut->getRequest()->getVal('action') && $wgOut->getRequest()->getVal('action') != 'view' ) return '';

	    if( !$wgArticle ) { return ''; }

        $pageId = $wgArticle->getContext()->getWikiPage()->getId();
        $revisionId = $wgArticle->getContext()->getWikiPage()->getRevision()->getId();
        $user_id = $wgUser->getId();

        /* Check for anonymous */
        if ( $wgUser->isAnon() ) return '';

        /* Fast check-in */
        $ids = Voting::getPageGroupsId();
        if ( !count( $ids ) ) return '';

        /* Cache */
        $wgOut->enableClientCache( false );

        /* We on our way in */

        $groups = Voting_Model_Group::find( array( 'id' => $ids, 'active' => true ) );
        if ( !count( $groups ) ) return '';

        $widget = '';

        foreach ( $groups as $group ) {

            if ( !$group->active ) continue;

            $ratings = Voting_Model_Rating::find( array( 'group_id' => $group->getId() ) );
            if ( !count( $ratings ) ) continue;

            /* User check-in */
            if ( Voting::isUserVoted( $group->getId(), $pageId, $revisionId, $wgUser->getId() ) ) {

                /* If user voted we should show his votes & revote action */

                $comment = Voting_Model_Comment::find( array(
                    'page_id' => $pageId,
                    'group_id' => $group->getId(),
                    'user_id' => $wgUser->getId()
                ) );

                if ( $comment ) {
                    $comment = $comment[0];
                    $comment = $comment->comment;
                } else {
                    $comment = '';
                }

                /* Fetch user votes */
                $userVotes = Voting::fetchUserVotes( $group->getId(), $pageId, $revisionId, $user_id );
                $ratings_values_ids = array();
                foreach ( $userVotes as $userVote ) {

                    $ratings_values_ids[$userVote->rating_id] = $userVote->value_id;

                }

                $widget .= VotingWidget::getWidgetHtml( $group->getId(), $ratings, $pageId, $revisionId, $ratings_values_ids, $comment );

            } else {

                /* User not voted, show blank widget */
                $widget .= VotingWidget::getWidgetHtml( $group->getId(), $ratings, $pageId, $revisionId );

            }

        }

        return $widget;

    }

    public static function getSummaryWidget()
    {

        global $wgUser, $wgTitle;

	    $wgArticle = Article::newFromID($wgTitle->getArticleID());

        if ( $wgArticle == null || $wgUser == null ) return '';

        $userId = $wgUser->getId();
        $userGroups = $wgUser->getAllGroups();
        $pageId = $wgArticle->getContext()->getWikiPage()->getId();

        $widget = '';

        $groupsId = Voting::getPageGroupsId( true );

        foreach ( $groupsId as $groupId ) {

            $widget .= VotingWidget::getSummaryWidgetHtml( $pageId, $groupId );

        }

        return $widget;

    }

    static function getCategoryChildren( $category_name, $get_categories, $levels )
    {
        if ( $levels == 0 ) {
            return array();
        }
        $pages = array();
        $subcategories = array();
        $dbr = wfGetDB( DB_SLAVE );
        extract( $dbr->tableNames( 'page', 'categorylinks' ) );
        $cat_ns = NS_CATEGORY;
        $query_category = str_replace( ' ', '_', $category_name );
        $query_category = str_replace( "'", "\'", $query_category );
        $sql = "SELECT p.page_title, p.page_namespace FROM $categorylinks cl
	JOIN $page p on cl.cl_from = p.page_id
	WHERE cl.cl_to = '$query_category'\n";
        if ( $get_categories )
            $sql .= "AND p.page_namespace = $cat_ns\n";
        $sql .= "ORDER BY cl.cl_sortkey";
        $res = $dbr->query( $sql );
        while ( $row = $dbr->fetchRow( $res ) ) {
            if ( $get_categories ) {
                $subcategories[] = $row[0];
                $pages[] = $row[0];
            } else {
                if ( $row[1] == $cat_ns )
                    $subcategories[] = $row[0];
                else
                    $pages[] = $row[0];
            }
        }
        $dbr->freeResult( $res );
        foreach ( $subcategories as $subcategory ) {
            $pages = array_merge( $pages, Voting::getCategoryChildren( $subcategory, $get_categories, $levels - 1 ) );
        }
        return $pages;
    }

    static function getTopLevelCategories()
    {
        $categories = array();
        $dbr = wfGetDB( DB_SLAVE );
        extract( $dbr->tableNames( 'page', 'categorylinks', 'page_props' ) );
        $cat_ns = NS_CATEGORY;
        $sql = "SELECT page_title FROM $page p LEFT OUTER JOIN $categorylinks cl ON p.page_id = cl.cl_from WHERE p.page_namespace = $cat_ns AND cl.cl_to IS NULL";
        $res = $dbr->query( $sql );
        if ( $dbr->numRows( $res ) > 0 ) {
            while ( $row = $dbr->fetchRow( $res ) ) {
                $categories[] = str_replace( '_', ' ', $row[0] );
            }
        }
        $dbr->freeResult( $res );

        // get 'hide' and 'show' categories
        $hidden_cats = $shown_cats = array();
        $sql2 = "SELECT p.page_title, pp.pp_propname FROM $page p JOIN $page_props pp ON p.page_id = pp.pp_page WHERE p.page_namespace = $cat_ns AND (pp.pp_propname = 'hidefromdrilldown' OR pp.pp_propname = 'showindrilldown') AND pp.pp_value = 'y'";
        $res2 = $dbr->query( $sql2 );
        if ( $dbr->numRows( $res2 ) > 0 ) {
            while ( $row = $dbr->fetchRow( $res2 ) ) {
                if ( $row[1] == 'hidefromdrilldown' )
                    $hidden_cats[] = str_replace( '_', ' ', $row[0] );
                else
                    $shown_cats[] = str_replace( '_', ' ', $row[0] );
            }
        }
        $dbr->freeResult( $res2 );
        $categories = array_merge( $categories, $shown_cats );
        foreach ( $hidden_cats as $hidden_cat ) {
            foreach ( $categories as $i => $cat ) {
                if ( $cat == $hidden_cat ) {
                    unset($categories[$i]);
                }
            }
        }
        sort( $categories );
        return $categories;
    }

    public static function getPageGroupsId()
    {

        global $wgOut;

        $category = $wgOut->getCategories();
		//There can be situation when categories is not loaded yet
		if( !count($category) ) {
			$tree = $wgOut->getTitle()->getParentCategoryTree();
			foreach($tree as $cName => $cValue) {
				$category[] = str_replace('_',' ',mb_substr( $cName, mb_strpos($cName,':')+1, strlen($cName) ));
			}
		}


        /* Get subcategories of category, very bad, need rework */
        $topcats = Voting::getTopLevelCategories();

        foreach ( $topcats as $cat ) {
            $subcats = Voting::getCategoryChildren( $cat, true, 2 );
            foreach ( $category as $ourcat ) {
                if ( in_array( str_replace(' ','_',$ourcat), $subcats ) ) {
                    //Subcategory YEP
                    $category[] = $cat;
                }
            }
        }

        if ( !count( $category ) ) return array();

        /* Slow check-in */
        $conds = array();

        $dbr = wfGetDB( DB_SLAVE );

        $cond = ' category ' . $dbr->buildLike( $dbr->anyString(), $category[0], $dbr->anyString() );

        for ( $i = 1; $i < count( $category ); $i++ ) {
            $cond .= ' OR category ' . $dbr->buildLike( $dbr->anyString(), $category[$i], $dbr->anyString() );
        }

        $r = $dbr->select( 'wv_voting_groups',
            'id',
            $cond,
            __METHOD__
        );
        if ( !$dbr->affectedRows() ) return array();

        $ids = array();
        while ( $z = $r->fetchObject() ) $ids[] = $z->id;

        return $ids;

    }

	public static function getSummary( $page_id, $group_id = null ) {

		global $wgUser;

		$userRoles = $wgUser->getAllGroups();
		$userRoles[] = 'user';
		$userRoles[] = '*';

		$result = array();

		/* Fetch group ratings */
		$group = new Voting_Model_Group($group_id);
		$ratings = Voting_Model_Rating::find( array( 'group_id' => $group_id ) );

		if(!count($ratings)) return '';

		$atLeastOnce = false;

		foreach( $ratings as $rating ) {

			$issetRole = false;

			foreach( $userRoles as $role ) {

				$summary = Voting_Model_Summary::find( array(
					'rule_key' => $role,
					'rating_id'=> $rating->getId(),
					'group_id' => $group_id,
					'page_id' => $page_id
				));
				if(count($summary) != 0) {
					$issetRole = true;
					$atLeastOnce = true;
					break;
				}

			}

			if(!$issetRole) continue;

			/* We got summary, show it */
			$summary = $summary[0];

			/* Rating type view format */
			$ratingType = new Voting_Model_Type($rating->type_id);
			$ratingTitles = Voting_Model_TypeValue::find( array( 'type_id'=>$rating->type_id ) );

			$inlineTitles = array();
			$inlineValues = array();

			foreach( $ratingTitles as $value ){
				$inlineTitles[] = $value->title;
				$inlineValues[] = $value->value;
			}

			$result[] = array(
				'title' => $summary->title,
				'view_format' => $ratingType->view_format,
				'rating_type_id' => $ratingType->getId(),
				'titles' => $inlineTitles,
				'values' => $inlineValues,
				'summary' => $summary->summary
			);

		}

		if(!$atLeastOnce) return array();

		return $result;
	}

}