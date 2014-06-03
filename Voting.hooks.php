<?php
/**
 * Hooks class declaration for mediawiki extension Voting
 *
 * @file Voting.hooks.php
 * @ingroup Voting
 */

class VotingHooks {

    public static function onOutputPageBeforeHTML( &$out, &$text ) {

		global $wgWikivoteSummaryWidgetBottom;

		if( $wgWikivoteSummaryWidgetBottom === false ) {

			/* Check exist */
			$title = $out->getTitle();
			if( $title->exists() ) {
				/* Add summary widget */
				$out->addHtml( Voting::getSummaryWidget() );
			}

		}

        return true;
    }

    /**
     * @static
     * @param WikiPage $article
     * @param $row
     * @return bool
     */
    public static function onBeforePageDisplay( OutputPage &$out, Skin &$skin ) {

        /* Check exist */
        $title = $out->getTitle();
        if( $title->exists() ) {
            /* Add modules */
            $out->addModules('ext.Voting.widget');
        }

        return true;
    }

    /**
     * Add widget after page content
     * @static
     * @param $data
     * @param Skin $skin
     * @return bool
     */
    public static function onSkinAfterContent(&$data, Skin $skin) {

        global $wgOut, $wgWikivoteSummaryWidgetBottom;

        /* Check exist */
        $title = $wgOut->getTitle();
        if( $title->exists() ) {

			/* Add summary widget bottom if $wgWikivoteSummaryWidgetBottom set TRUE */
			if ($wgWikivoteSummaryWidgetBottom === true) {
				$data .= Voting::getSummaryWidget();
			}

            /* Add voting widget */
            $data .= Voting::getWidget();
        }

        return true;
    }

	/**
	 * Push properties values to smwData
	 * @param $store SMWStore
	 * @param $data SMWSemanticData
	 * @return bool
	 */
	public static function s13n( SMWStore $store, SMWSemanticData $data )
	{

		/** @var Article $wgArticle */
		global $wgUser, $wgArticle;

		$subject = $data->getSubject();
		$title = Title::makeTitle( $subject->getNamespace(), $subject->getDBkey() );
		$wikipage = WikiPage::factory( $title );

		// return if $title or $wikipage is null
		if ( is_null( $title ) || is_null( $wikipage ) || !$wgArticle ) {
			return true;
		}

		if ( $title->getNamespace() != NS_MAIN ) {
			return true;
		}

		$pageId = $wgArticle->getContext()->getWikiPage()->getId();
		$groupsId = Voting::getPageGroupsId( true );

		foreach ( $groupsId as $groupId ) {
			$summary = Voting::getSummary( $pageId, $groupId );
			foreach( $summary as $summItem ) {
				//Summary integer code
				self::fakePropertyAdd( $data,
					'Voting group '.$groupId.' code '.$summItem['title'],
					$summItem['summary']
				);
				//Summary text value
				$summaryValueIndex = array_search( $summItem['summary'], $summItem['values'] );
				self::fakePropertyAdd( $data,
					'Voting group '.$groupId.' text '.$summItem['title'],
					$summItem['titles'][ $summaryValueIndex ]
				);
			}
		}

		return true;
	}

	/**
	 * ACTUAL
	 * Called when SMW Subject data updates begin
	 * array format: property=value, property=value
	 * @param $sioIndex int sioindex
	 * @param $data SMWDataItem
	 * @internal param array $params
	 * @return bool
	 */
	public static function onSMWSubobjectUpdate( $sioIndex, $data )
	{
		return true;
	}

	/**
	 * Install fake property to smwStore flow
	 * @param SMWSemanticData $data
	 * @param $label
	 * @param $values
	 * @internal param $store
	 * @internal param $value
	 * @return bool
	 */
	private static function fakePropertyAdd( SMWSemanticData $data, $label, $values )
	{

		if ( !is_array( $values ) ) $values = array( $values );

		$propertyName = $label;

		$propertyDv = SMWPropertyValue::makeUserProperty( $propertyName );
		$propertyDi = $propertyDv->getDataItem();

		foreach ( $values as $value ) {

			$propertyValue = $value;

			//TODO: update to smw 1.9 namespaces
			$propertyOv = SMWDataValueFactory::newPropertyObjectValue(
				$propertyDi,
				$propertyValue,
				$propertyName,
				$data->getSubject()
			);

			$data->addPropertyObjectValue( $propertyDi, $propertyOv->getDataItem() );
		}

		return true;
	}



    /**
     * Hook runs on update.php script executed. Creates tables schema in mysql db.
     *
     * @static
     * @param null $updater
     * @return bool
     */
    public static function onLoadExtensionSchemaUpdates( MysqlUpdater $updater = null ) {

        global $wgWikivoteVotingDir;

        $db = $updater->getDB();

        $updater->addExtensionUpdate( array(
            'addTable',
            'wv_voting_groups',
            $wgWikivoteVotingDir . '/schema/wv_voting_groups.sql',
            true
        ) );

        $updater->addExtensionUpdate( array(
            'addTable',
            'wv_voting_ratings',
            $wgWikivoteVotingDir . '/schema/wv_voting_ratings.sql',
            true
        ) );

        $updater->addExtensionUpdate( array(
            'addTable',
            'wv_voting_values',
            $wgWikivoteVotingDir . '/schema/wv_voting_values.sql',
            true
        ) );

        $updater->addExtensionUpdate( array(
            'addTable',
            'wv_voting_types',
            $wgWikivoteVotingDir . '/schema/wv_voting_types.sql',
            true
        ) );

        $updater->addExtensionUpdate( array(
            'addTable',
            'wv_voting_types_values',
            $wgWikivoteVotingDir . '/schema/wv_voting_types_values.sql',
            true
        ) );

        $updater->addExtensionUpdate( array(
            'addTable',
            'wv_voting_page_summary',
            $wgWikivoteVotingDir . '/schema/wv_voting_page_summary.sql',
            true
        ) );

        $updater->addExtensionUpdate( array(
            'addTable',
            'wv_voting_visible_rules',
            $wgWikivoteVotingDir . '/schema/wv_voting_visible_rules.sql',
            true
        ) );

        $updater->addExtensionUpdate( array(
            'addTable',
            'wv_voting_comments',
            $wgWikivoteVotingDir . '/schema/wv_voting_comments.sql',
            true
        ) );

		$updater->addExtensionUpdate( array(
			'modifyField',
			'wv_voting_comments',
			'comment',
			$wgWikivoteVotingDir . '/schema/wv_voting_comments_comment_length.sql',
			true
		) );

        return true;
    }

	public static function onWotmSkinBuildMenuItems( &$items ) {
		$item = array(
			'title' => 'Voting',
			'items' => array(
				array(
					'title' => 'Управление',
					'href' => SpecialPageFactory::getPage('Voting')->getTitle()->getFullURL(),
					'icon' => 'ok',
					'tooltip' => 'Панель управления Voting'
				)
			)
		);
		$items[] = $item;
		return true;
	}

}