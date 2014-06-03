<?php
/**
 * Initialization file for the Voting extension.
 *
 * @file Voting.php
 * @ingroup Voting
 *
 * @licence GNU GPL v3
 * @author Wikivote! ltd < http://wikivote.ru >
 */

global $wgWikivoteSummaryWidgetBottom,$wgWikivoteVotingPath,$wgWikivoteVotingDir,$wgVersion,$wgExtensionCredits,$wgResourceModules,$wgExtensionMessagesFiles,$wgAutoloadClasses,$wgAvailableRights,$wgGroupPermissions,$wgHooks,$wgAPIModules,$wgJobClasses,$wgSpecialPages;

if ( !defined( 'MEDIAWIKI' ) ) {
    die('Not an entry point.');
}

if ( version_compare( $wgVersion, '1.17', '<' ) ) {
    die('<b>Error:</b> This version of Voting requires MediaWiki 1.17 or above.');
}

/* Vars */
$wgWikivoteVotingDir = dirname( __FILE__ );
$wgWikivoteVotingPath = '/extensions/Voting/';

/* Preference vars */
$wgWikivoteSummaryWidgetBottom = false;

$wgExtensionCredits['extension'][] = array(
		'path' => __FILE__,
		'name' => 'Voting',
		'version' => '0.1',
		'author' => 'WikiVote!',
		'url' => 'https://www.mediawiki.org/wiki/Extension:Voting',
		'descriptionmsg' => 'voting-credits',
);

/* Resource modules */
$wgResourceModules['ext.VotingTemplateSimple.main'] = array(
		'localBasePath' => dirname( __FILE__ ) . '/',
		'remoteExtPath' => 'VotingTemplateSimple/',
		'group' => 'ext.VotingTemplateSimple',
		'scripts' => 'templateSimple.js',
		'styles' => 'templateSimple.css',
		'position' => 'top'
);

/* Resource modules */
$wgResourceModules['ext.Voting.main'] = array(
    'localBasePath' => dirname( __FILE__ ) . '/assets/',
    'remoteExtPath' => 'Voting/assets/',
    'group' => 'ext.Voting',
    'scripts' => array(),
    'styles' => array( 'Voting.css' ),
    'position' => 'top' /* Styles loaded before page, removes css lag */
);

$wgResourceModules['ext.Voting.bootstrap'] = array(
    'localBasePath' => dirname( __FILE__ ) . '/assets/',
    'remoteExtPath' => 'Voting/assets/',
    'group' => 'ext.Voting',
    'scripts' => array(),
    'styles' => array( 'Bootstrap.css' ),
    'position' => 'top' /* Styles loaded before page, removes css lag */
);

$wgResourceModules['ext.Voting.assetsjs'] = array(
    'localBasePath' => dirname( __FILE__ ) . '/assets/',
    'remoteExtPath' => 'Voting/assets/',
    'group' => 'ext.Voting',
    'scripts' => array( 'MultiInput2.js' ),
    'styles' => array(),
    'position' => 'top'
);

$wgResourceModules['ext.Voting.groupform'] = array(
    'localBasePath' => dirname( __FILE__ ) . '/assets/',
    'remoteExtPath' => 'Voting/assets/',
    'group' => 'ext.Voting',
    'scripts' => array( 'GroupForm.js' ),
    'styles' => array(),
    'messages' => array(
        'voting-js-multiinput-button-add',
        'voting-js-multiinput-button-remove'
    )
);

$wgResourceModules['ext.Voting.typeform'] = array(
    'localBasePath' => dirname( __FILE__ ) . '/assets/',
    'remoteExtPath' => 'Voting/assets/',
    'group' => 'ext.Voting',
    'scripts' => array( 'TypeForm.js' ),
    'styles' => array(),
    'messages' => array(
        'voting-js-multiinput-button-add',
        'voting-js-multiinput-button-remove'
    )
);

$wgResourceModules['ext.Voting.widget'] = array(
    'localBasePath' => dirname( __FILE__ ) . '/assets/',
    'remoteExtPath' => 'Voting/assets/',
    'group' => 'ext.Voting',
    'scripts' => array( 'jquery.raty.min.js', 'Widget.js' ),
    'styles' => array( 'Widget.css' ),
    'messages' => array(
        'voting-js-select-control-null',
        'voting-js-view-format-yesno-no',
        'voting-js-view-format-yesno-yes'
    ),
    'dependencies' => array( 'jquery.ui.progressbar' )
);

/* Message Files */
$wgExtensionMessagesFiles['Voting'] = dirname( __FILE__ ) . '/Voting.i18n.php';

/* Autoload classes */
$wgAutoloadClasses['VotingSummaryJob'] = dirname( __FILE__ ) . '/includes/VotingSummaryJob.php';
$wgAutoloadClasses['Voting'] = dirname( __FILE__ ) . '/Voting.class.php';
$wgAutoloadClasses['VotingWidget'] = dirname( __FILE__ ) . '/includes/VotingWidget.php';
$wgAutoloadClasses['VotingApi'] = dirname( __FILE__ ) . '/includes/VotingApi.php';
$wgAutoloadClasses['VotingExceptionHandler'] = dirname( __FILE__ ) . '/includes/VotingExceptionHandler.php';

/* Pages classes */
$wgAutoloadClasses['VotingSpecial'] = dirname( __FILE__ ) . '/pages/VotingSpecial/VotingSpecial.php';

/* Special pages */
$wgSpecialPages['Voting'] = 'VotingSpecial';

/* Routing */
$wgAutoloadClasses['RoutedSpecialPage'] = dirname( __FILE__ ) . '/includes/RoutedSpecialPage.php';

/* DB Abstraction models */
$wgAutoloadClasses['Voting_Model'] = dirname( __FILE__ ) . '/includes/Voting_Model.php';
$wgAutoloadClasses['Voting_Model_Group'] = dirname( __FILE__ ) . '/includes/Voting_Model_Group.php';
$wgAutoloadClasses['Voting_Model_Rating'] = dirname( __FILE__ ) . '/includes/Voting_Model_Rating.php';
$wgAutoloadClasses['Voting_Model_Value'] = dirname( __FILE__ ) . '/includes/Voting_Model_Value.php';
$wgAutoloadClasses['Voting_Model_Type'] = dirname( __FILE__ ) . '/includes/Voting_Model_Type.php';
$wgAutoloadClasses['Voting_Model_TypeValue'] = dirname( __FILE__ ) . '/includes/Voting_Model_TypeValue.php';
$wgAutoloadClasses['Voting_Model_VisibleRule'] = dirname( __FILE__ ) . '/includes/Voting_Model_VisibleRule.php';
$wgAutoloadClasses['Voting_Model_Summary'] = dirname( __FILE__ ) . '/includes/Voting_Model_Summary.php';
$wgAutoloadClasses['Voting_Model_Comment'] = dirname( __FILE__ ) . '/includes/Voting_Model_Comment.php';

$wgAutoloadClasses['VotingHooks'] = dirname( __FILE__ ) . '/Voting.hooks.php';

/* Rights */
$wgAvailableRights[] = 'adminvotings';

/* Permissions */
$wgGroupPermissions['*']['adminvotings'] = false;
$wgGroupPermissions['sysop']['adminvotings'] = true;

/* Hooks */
$wgHooks['LoadExtensionSchemaUpdates'][] = 'VotingHooks::onLoadExtensionSchemaUpdates';
$wgHooks['BeforePageDisplay'][] = 'VotingHooks::onBeforePageDisplay';
$wgHooks['SkinAfterContent'][] = 'VotingHooks::onSkinAfterContent';
$wgHooks['OutputPageBeforeHTML'][] = 'VotingHooks::onOutputPageBeforeHTML';
$wgHooks['WotmSkinBuildMenuItems'][] = 'VotingHooks::onWotmSkinBuildMenuItems';

/* S13N */
$wgHooks['SMWStore::updateDataBefore'][] = 'VotingHooks::s13n';
$wgHooks['SMWSubobjectUpdate'][] = 'VotingHooks::onSMWSubobjectUpdate';

/* Api */
$wgAPIModules['voting'] = 'VotingApi';

/* JOBS */
$wgJobClasses['VotingSummary'] = 'VotingSummaryJob';