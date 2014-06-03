<?php
/**
 * Voting special page.
 *
 * @file VotingSpecial.php
 * @ingroup
 *
 * @licence GNU GPL v3 or later
 * @author Vedmaka < god.vedmaka@gmail.com >
 */

class VotingSpecial extends RoutedSpecialPage {

    /**
     * Special page constructor.
     */
    function __construct()
    {
        parent::__construct( 'Voting', 'adminvotings' );
    }

    /**
     * Execute routed special page. We override default function to set some paramenters.
     * @param String $params
     */
    public function execute( $params ) {

        global $wgOut, $wgUser;

        /* Check access */
        if (!$wgUser->isAllowed('adminvotings')) {
            $wgOut->redirect('/');
        }

        /* Add resources */
        $wgOut->addModules('ext.Voting.main');
		if( !class_exists('SkinWotm') ) {
        	$wgOut->addModules('ext.Voting.bootstrap');
		}

        /* Display description */
        $wgOut->addHTML( '<p>'.wfMsg('voting-specialdescription').'</p>' );

        /* Add menu */
        $wgOut->addHTML( $this->htmlMenuLinks() );

        /* Routing with options */
        parent::execute( $params, true, false );
    }

    /**
     * Show main page: voting groups table, statistics.
     * @param $params
     */
    protected function action_index( $params ) {

        /* Fetch data */
        $data = array();

        $data['groups'] = Voting_Model_Group::find();

        /* Display groups table */
        $this->view('index', $data );

    }

    protected function action_stat() {

        $data = array();

        $data['values'] = Voting_Model_Value::find('all', array( 'LIMIT' => 100, 'ORDER BY' => 'vote_time DESC', 'GROUP BY hash' ) );

        $this->view('stat', $data);


    }

    /**
     * Creates a new group
     * @param $params
     */
    protected function action_group_create( $params ) {

        global $wgRequest, $wgOut;

        /* Modules */
        $wgOut->addModules('ext.Voting.assetsjs');
        $wgOut->addModules('ext.Voting.groupform');

        $data = array();

        if ( $wgRequest->wasPosted() ) {

            $group = new Voting_Model_Group();

            if ( $group->validate( 'name' ) ) {

                $group->save();

                $wgOut->redirect( $this->getIndexURL() );

            }else{

                $data['error'] = wfMsg('wikivotevoting-error-input-common');
            }

        }

        /* Category list, TODO: Ajax category fetch, model category fetch */
        $data['categories'] = $this->getMWCategories();
        $data['rules'] = Voting_Model_VisibleRule::find();

        $this->view('group_create', $data);

    }

    /**
     * View group and its entities
     * @param $params
     */
    protected function action_group_view( $params ) {

        global $wgOut;

        if( isset($params[0]) ) {

            $id = intval($params[0]);

            /* Fetch group */
            $group = new Voting_Model_Group($id);
            $data['group'] = $group;

            /* Fetch ratings */
            $ratings = Voting_Model_Rating::find( array( 'group_id' => $group->getId() ) );

            /* Fetch types */
            foreach( $ratings as &$rating ) {

                $type = new Voting_Model_Type( $rating->type_id );
                $rating->type_name = $type->name;

            }

            $data['ratings'] = $ratings;

            $this->view('group_view', $data);
            return;

        }

        $wgOut->redirect( $this->getIndexURL() );

    }

    /**
     * Edit voting group
     * @param $params
     * @return mixed
     */
    protected function action_group_edit( $params ) {

        global $wgOut, $wgRequest;

        /* Modules */
        $wgOut->addModules('ext.Voting.assetsjs');
        $wgOut->addModules('ext.Voting.groupform');

        $data = array();

        if( isset($params[0]) ) {

            $id = intval($params[0]);
            $group = new Voting_Model_Group($id);

            if ( $wgRequest->wasPosted() ) {

                if ($group->validate( 'name' )) {
                    $group->save();
                    $wgOut->redirect( $this->getIndexURL() );
                }else{
                    $data['error'] = wfMsg('wikivotevoting-error-input-common');
                }

            }else{

                $data['group'] = $group;
                /* Category list, TODO: Ajax category fetch, model category fetch */
                $data['categories'] = $this->getMWCategories();
                $data['rules'] = Voting_Model_VisibleRule::find();

            }

            $this->view('group_edit', $data);
            return;

        }

        $wgOut->redirect( $this->getIndexURL() );

    }

    /**
     * Delete voting group
     * @param int $params group id
     */
    protected function action_group_delete( $params ) {

        global $wgOut;

        if( isset($params[0]) ) {

            $id = intval($params[0]);

            $group = new Voting_Model_Group($id);

            if ($group)
                $group->delete();

        }

        $wgOut->redirect( $this->getIndexURL() );

    }

    /**
     * Delete rating entity from database
     * @param $params
     */
    protected function action_rating_delete( $params ) {

        global $wgOut;

        if( isset($params[0]) ) {

            $id = intval($params[0]);

            $rating = new Voting_Model_Rating($id);

            if ($rating) {

                $gid = $rating->group_id;
                $rating->delete();
                $wgOut->redirect( $this->getActionURL('group/view', $gid ) );
                return;

            }

        }

        $wgOut->redirect( $this->getIndexURL() );

    }

    /**
     * Edit rating page
     * @param $params
     * @return mixed
     */
    protected function action_rating_edit( $params ) {

        global $wgOut, $wgRequest;

        /* Modules */
        $wgOut->addModules('ext.Voting.assetsjs');

        $data = array();

        if( isset($params[0]) ) {

            $id = intval($params[0]);
            $rating = new Voting_Model_Rating($id);

            if ( $wgRequest->wasPosted() ) {

                if ($rating->validate()) {
                    $rating->save();
                    $wgOut->redirect( $this->getActionURL('group/view', $rating->group_id ));
                    return;
                }else{
                    $data['error'] = wfMsg('wikivotevoting-error-input-common');
                }

            }else{

                $data['rating'] = $rating;
                $data['groups'] = Voting_Model_Group::find();
                /* Load widget types */
                $data['widgetTypes'] = Voting_Model_Type::find();

            }



            $this->view('rating_edit', $data);
            return;

        }

        $wgOut->redirect( $this->getIndexURL() );

    }

    /**
     * Creates new rating
     * @param $params
     */
    protected function action_rating_create( $params ) {

        global $wgRequest, $wgOut;

        /* Modules */
        $wgOut->addModules('ext.Voting.assetsjs');

        $id = null;
        $data = array();

        /* Pass group id */
        if ( isset($params[0]) ) {
            $id = intval($params[0]);
            $data['group_id'] = $id;
        }

        if ( $wgRequest->wasPosted() ) {

            $rating = new Voting_Model_Rating();

            if ($rating->validate( 'name' ) ) {

                $rating->save();

                $wgOut->redirect( $this->getActionURL('group/view', $id ));
                return;

            }else{

                $data['error'] = wfMsg('wikivotevoting-error-input-common');
            }

        }

        $data['groups'] = Voting_Model_Group::find();
        /* Load widget types */
        $data['widgetTypes'] = Voting_Model_Type::find();

        $this->view('rating_create', $data);

    }

    /**
     * Show visible rules
     * @param $params
     */
    protected function action_rule_view( $params ) {

        $data = array();
        $data['rules'] = Voting_Model_VisibleRule::find();

        $this->view('rule_view', $data);

    }

    /**
     * Creates new rule
     * @param $params
     */
    protected function action_rule_create( $params ) {

        global $wgRequest, $wgOut, $wgGroupPermissions;

        /* Modules */
        $wgOut->addModules('ext.Voting.assetsjs');

        $data = array();

        if ( $wgRequest->wasPosted() ) {

            $rule = new Voting_Model_VisibleRule();

            if ( $rule->validate( 'name' ) ) {

                $rule->save();

                $wgOut->redirect( $this->getActionURL('rule/view') );

            }else{

                $data['error'] = wfMsg('wikivotevoting-error-input-common');
            }

        }

        $data['wikiGroups'] = array_keys($wgGroupPermissions);

        $this->view('rule_create', $data);

    }

    /**
     * Edit rule page
     * @param $params
     */
    protected function action_rule_edit( $params ) {

        global $wgOut, $wgRequest, $wgGroupPermissions;

        $data = array();

        if( isset($params[0]) ) {

            $id = intval($params[0]);

            $rule = new Voting_Model_VisibleRule($id);

            if( $wgRequest->wasPosted() ) {

                if( $rule->validate('name') ) {

                    $rule->save();
                    $wgOut->redirect( $this->getActionURL('rule/view') );
                    return;

                }

            }

        }else{

            $wgOut->redirect( $this->getIndexURL() );
            return;

        }

        $data = array();
        $data['wikiGroups'] = array_keys($wgGroupPermissions);
        $data['rule'] = $rule;

        $this->view('rule_edit', $data);

    }

    /**
     * Display type list table
     * @param $params
     */
    protected function action_type_view( $params ) {

        $data = array();
        $data['widgetTypes'] = Voting_Model_Type::find();

        $this->view('type_view', $data);

    }

    /**
     * Display type edit page
     * @param $params
     */
    protected function action_type_edit( $params ) {

        global $wgOut, $wgRequest;

        /* Modules */
        $wgOut->addModules('ext.Voting.assetsjs');
        $wgOut->addModules('ext.Voting.typeform');

        $data = array();

        if( isset($params[0]) ) {

            $id = intval($params[0]);

            $widgetType = new Voting_Model_Type($id);
            $typeValues = Voting_Model_TypeValue::find( array( 'type_id' => $id ) );

            if ( $wgRequest->wasPosted() ) {

                $tValues = array();
                $tValues['titles'] = $wgRequest->getArray('type_values_title');
                $tValues['values'] = $wgRequest->getArray('type_values_value');
                $tValues['ids'] = $wgRequest->getArray('type_values_id');



                if ( $widgetType->validate( 'name' ) && !empty($tValues['titles']) && !empty($tValues['values']) ) {

                    /* Save type */
                    $widgetType->save();

                    /* Drop all values */
                    foreach( $typeValues as $tv ) {
                        print "Is in array ".$tv->getId();
                        if (!in_array( $tv->getId(), $tValues['ids'] )) {
                            $tv->delete();
                        }
                    }

                    var_dump($tValues);

                    /* Save new values */
                    for($i=0; $i<count($tValues['titles']); $i++) {

                        $title = $tValues['titles'][$i];
                        $value = $tValues['values'][$i];

                        var_dump($tValues['ids'][$i]);

                        if( isset( $tValues['ids'][$i] ) && !empty( $tValues['ids'][$i] ) && ($tValues['ids'][$i] != '') ) {
                            print "UPD";
                            //Updating value
                            $typeValue = new Voting_Model_TypeValue( $tValues['ids'][$i] );
                        }else{
                            print "NEW";
                            $typeValue = new Voting_Model_TypeValue();
                        }

                        $typeValue->title = $title;
                        $typeValue->value = $value;
                        $typeValue->type_id = $widgetType->getId();
                        $typeValue->save();

                    }

                    //die();

                    $wgOut->redirect( $this->getActionURL('type/view') );

                }else{
                    $data['error'] = wfMsg('wikivotevoting-error-input-common');
                }

            }

            $data['type'] = $widgetType;
            $data['typeValues'] = $typeValues;

            $this->view( 'type_edit', $data );
            return;

        }

        $wgOut->redirect( $this->getIndexURL() );

    }

    /**
     * Delete type
     * @param $params
     */
    protected function action_type_delete( $params ) {

        global $wgOut;

        if( isset($params[0]) ) {

            $id = intval($params[0]);

            $type = new Voting_Model_Type($id);

            if ($type) {

                $type->delete();

                $typeValues = Voting_Model_TypeValue::find( array( 'type_id' => $type->getId() ) );
                foreach( $typeValues as $typeValue ) {
                    $typeValue->delete();
                }

                $wgOut->redirect( $this->getActionURL('type/view' ) );
                return;

            }

        }

        $wgOut->redirect( $this->getIndexURL() );

    }

    /**
     * Type creating page
     * @param $params
     */
    protected function action_type_create( $params ) {

        global $wgOut, $wgRequest;

        $data = array();

        /* Modules */
        $wgOut->addModules('ext.Voting.assetsjs');
        $wgOut->addModules('ext.Voting.typeform');

        if ( $wgRequest->wasPosted() ) {

            $widgetType = new Voting_Model_Type();

            $typeValues = array();
            $typeValues['titles'] = $wgRequest->getArray('type_values_title');
            $typeValues['values'] = $wgRequest->getArray('type_values_value');

            if ( $widgetType->validate( 'name' ) && !empty($typeValues['titles']) && !empty($typeValues['values']) ) {

                /* Save type */
                $id = $widgetType->save();

                /* Fetch titles and values */
                for($i=0; $i<count($typeValues['titles']); $i++) {

                    $title = $typeValues['titles'][$i];
                    $value = $typeValues['values'][$i];

                    $typeValue = new Voting_Model_TypeValue();
                    $typeValue->title = $title;
                    $typeValue->value = $value;
                    $typeValue->type_id = $id;
                    $typeValue->save();

                }

                $wgOut->redirect( $this->getActionURL('type/view') );
                return;

            }else{
                $data['error'] = wfMsg('wikivotevoting-error-input-common');
            }

        }

        $this->view('type_create', $data);

    }

    /**
     * Html with top menu links
     * @return string
     */
    private function htmlMenuLinks() {

        $html = '';

        $html .= Html::openElement('div', array( 'class'=>'wv-menu-links' ) );

            $html .= Html::openElement('ul');

                /* Show all */
                $html .= Html::openElement('li');

                    $html .= Html::element('a', array(
                            'href' => $this->getIndexURL(),
                            'class' => 'btn'
                        ),
                        wfMsg('voting-speciallink-index') );

                $html .= Html::closeElement('li');

                /* Create group */
                $html .= Html::openElement('li');

                    $html .= Html::element('a', array(
                        'href' => $this->getActionURL('group/create'),
                        'class' => 'btn'
                        ),
                        wfMsg('voting-speciallink-create-group') );

                $html .= Html::closeElement('li');

                /* Create widget type */
                $html .= Html::openElement('li');

                $html .= Html::element('a', array(
                        'href' => $this->getActionURL('type/view'),
                        'class' => 'btn'
                    ),
                    wfMsg('voting-speciallink-view-widget-type') );

                $html .= Html::closeElement('li');

                /* View statistics */
                $html .= Html::openElement('li');

                $html .= Html::element('a', array(
                        'href' => $this->getActionURL('stat'),
                        'class' => 'btn'
                    ),
                    wfMsg('voting-speciallink-stat') );

                $html .= Html::closeElement('li');

                /* Rules view
                $html .= Html::openElement('li');

                $html .= Html::element('a', array(
                        'href' => $this->getActionURL('rule/view'),
                        'class' => 'btn'
                    ),
                    wfMsg('voting-speciallink-rules') );

                $html .= Html::closeElement('li'); */

            $html .= Html::closeElement('ul');

        $html .= Html::closeElement('div');

        return $html;

    }

    /**
     * TEMPORARY
     * Returns categories id and names from mediawiki DB
     * @return array
     */
    private function getMWCategories() {

        $dbr = wfGetDB( DB_SLAVE );

        $collection = $dbr->select('category',
            array('cat_id', 'cat_title')
        );

        $result = array();
        foreach( $collection as $category ) {
            $result[$category->cat_id] = $category->cat_title;
        }

        return $result;

    }

}