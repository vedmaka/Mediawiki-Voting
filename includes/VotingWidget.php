<?php
/**
 * Voting widget for Voting
 *
 * @file VotingWidget.php
 * @ingroup
 *
 * @licence GNU GPL v3 or later
 * @author Vedmaka < god.vedmaka@gmail.com >
 */
class VotingWidget
{


    /**
     * Render widget html code
     * @static
     * @param $group_id
     * @param $ratings
     * @return string
     */
    public static function getWidgetHtml( $group_id, $ratings, $page_id, $revision_id, $ratings_values_ids = null, $comment = '' ) {

        global $wgUser;

        $widget = '';

        /* Simple mode */
        $isSimple = false;
        if( count($ratings) == 1 ) $isSimple = true;

        $group = new Voting_Model_Group($group_id);
        if(!$group) return '';

            $widget .= '<div id="voting-widget-'.$group_id.'"
                        class="wikivote-voting-widget '.(($isSimple) ? 'widget-simple' : '').'"
                        style="display: none;"
                        voting-group="'.$group_id.'"
                        page="'.$page_id.'"
                        revision="'.$revision_id.'"
                        ">

                    <div class="wvw-shadow"></div>';

                    if( $wgUser->isAllowed('adminvotings') ) {
                        $widget .= '
                        <div class="wvw-adminvotings-edit">
                            <a href="'
                                .Title::newFromText('Voting', NS_SPECIAL)->getFullURL().'/group/edit/'.$group_id
                                .'">
                                <div class="wvw-adminvotings-link"></div>
                            </a>
                        </div>
                        ';
                    }

        if($group->title != '') {
        $widget .= '<div class="wvw-title">
                        '.$group->title.'
                        <div class="wvw-subtitle">
                            '.$group->description.'
                        </div>
                    </div>';
        }

        $widget .= '<div class="result-message">'.$group->result_message.'</div>

                    <div class="ratings">';

                    foreach( $ratings as $rating ) {

                        $type = new Voting_Model_Type($rating->type_id);

                        $values = Voting_Model_TypeValue::find( array('type_id' => $type->getId() ) );

                        $inlineValues = array();
                        $inlineTitles = array();

                        foreach( $values as $value ){
                            $inlineTitles[] = $value->title;
                            /* We pass value id to script, not values for security reason */
                            $inlineValues[] = $value->getId();
                        }

                        $widget .= '<div class="wvw-ratings-block">

                            <div class="wvw-rate">';

                            if($rating->name != '') {
                                $widget .= '<div class="wvw-name">'.$rating->name.'</div> ';
                            }
                            if($rating->description != '') {
                                $widget .= '<div class="www-desc">'.$rating->description.'</div>';
                            }

                        $widget .= '<div class="wvw-value">

                                    <!-- Widget voting div -->
                                    ';

                        $widget .= '<div class="wikivote-voting-control"
                                    rating="'.$rating->getId().'"
                                    titles="'.implode(',', $inlineTitles).'"
                                    values="'.implode(',', $inlineValues ).'"
                                    score="-1"';

                        /* Pass votes */
                        if( $ratings_values_ids != null ) {

                            $widget .= ' stored_score="'.$ratings_values_ids[$rating->getId()].'" ';

                        }

                        $widget .= 'control="'.$type->control_id.'"></div>';


                        $widget .= '
                                </div>

                            </div>

                        </div>';

                    }

        /*Comment*/
        $widget .= '<div class="wv-voting-comments-block">
            <label for="wv-comment-'.$group_id.'">Ваш комментарий: </label>
            <input maxlength="512" type="text" name="comment" id="wv-comment-'.$group_id.'" value="'.$comment.'" />
        </div>';

                    $widget .= '<button class="btn-large wvw-submit" disabled >'.wfMsg('wikivotevoting-widget-send-votes').'</button>

                </div>

                ';

        /*History*/
        $widget .= VotingWidget::getVotesHistoryList( $group_id, $page_id, $revision_id );

        $widget .=  '</div>';

        return $widget;

    }

    public static function getSummaryWidgetHtml( $page_id, $group_id ) {

        global $wgUser, $wgOut;

        $userRoles = $roles = $wgUser->getAllGroups();
        $userRoles[] = 'user';
        $userRoles[] = '*';

        $widget = '';

        /* Fetch group ratings */
        $group = new Voting_Model_Group($group_id);
        $ratings = Voting_Model_Rating::find( array( 'group_id' => $group_id ) );
        if(!count($ratings)) return '';

        $widget .= '<div class="wikivote-summary-widget">

                        <div class="wikivote-summary-widget-title">
                        '.$group->title.'
                        </div>';

        $atLeastOnce = false;

        foreach( $ratings as $rating ) {

            //TODO: we how summary for first found group ?

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

            $widget .= '    <div class="wikivote-summary-rating">

                                <div class="wikivote-summary-rating-title">
                                '.$summary->title.'
                                </div>

                                <div class="wikivote-summary-rating-value"
                                view_format="'.$ratingType->view_format.'"
                                titles="'.implode(',',$inlineTitles).'"
                                values="'.implode(',',$inlineValues).'"
                                >
                                '.$summary->summary.'
                                </div>

                            </div>';

        }

        if(!$atLeastOnce) return '';

        $widget .= '</div>';

        return $widget;

    }

    //TODO: for now i place logic here, but its bad decision!!!
    /**
     * Returns history element
     * @param $group_id
     * @param $page_id
     * @param $revision_id
     * @return string
     */
    function getVotesHistoryList( $group_id, $page_id, $revision_id ) {

        $html = '';

        $html .= '<div class="wv-voting-history">';

            $html .= '<div class="title-history">История голосований</div>';

            // Fetch data for all group votings
            $Values = Voting::fetchVotes( $group_id, $page_id, $revision_id, true );

            foreach( $Values as $valueGroup ) {

                if(!count($valueGroup)) continue;

                $sample = $valueGroup[0];

                // Process data
                $user = User::newFromId($sample->user_id);
                $userName = $user->getName();
                $userPage = $user->getUserPage()->getFullURL();

                $time = $sample->vote_time;
                //setlocale(LC_ALL, 'rus_RUS');
                $time = date("j F, H:i", strtotime($time));

                // Fetch comment
                $comment = Voting_Model_Comment::find(
                    array(
                        'group_id' => $group_id,
                        'user_id' => $sample->user_id,
                        'page_id' => $page_id,
                        'hash' => $sample->hash
                    ));

                $html .= '<div class="wv-history-block">';

                    // Time
                    $html .= '<div class="info-time-panel">'.$time.'</div>';

                    // Info block
                    $html .= '<div class="info-panel">';
                        $html .= '<img src="/extensions/Voting/assets/userx.png" />&nbsp;';
                        $html .= '<a href="'.$userPage.'">'.$userName.'</a>';

                    if($comment) {
                        $comment = $comment[0];
                        $html .= '<span>'.$comment->comment.'</span>';
                    }

                    $html .= '</div>';

                foreach( $valueGroup as $value ) {

                    //Values:
                    $rating = new Voting_Model_Rating($value->rating_id);
                    $type = new Voting_Model_Type($rating->type_id);
                    $value = Voting_Model_TypeValue::find( array('type_id' => $type->getId(), 'id' => $value->value_id ) );

					if(count($value)) {

						$value = $value[0];

						$html .= '<div class="value-block">';

							$html .= '<span class="value-block-title">'.$rating->name.'</span> &nbsp;—';
							$html .= '<span class="value-block-value">'.$value->title.'</span>';

						$html .= '</div>';

					}

                }

                $html .= '</div>';

            }

        $html .= '</div>';

        return $html;

    }

}
