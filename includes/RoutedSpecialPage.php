<?php
/**
 * Routed special page provides additional routing mechanism for developer.
 *
 * @file RoutedSpecialPage.php
 * @ingroup
 *
 * @licence GNU GPL v3 or later
 * @author Vedmaka < god.vedmaka@gmail.com >
 */
class RoutedSpecialPage extends SpecialPage
{

	/**
	 * Routing point. Notice: If overrided, should be placed bottom of overriding function.
	 *
	 * @param String $params
	 * @param bool $setHeaders
	 * @param bool $disableOutput
	 *
	 * @throws Exception
	 */
    public function execute( $params, $setHeaders = false, $disableOutput = false ) {

        global $wgOut;

        if ($setHeaders) $this->setHeaders();
        if ($disableOutput) $wgOut->disable();

        /* No params - execute `action_index` function */
        if (empty($params)) {
            if ( !(int)method_exists($this,'action_index') ) {
                throw new Exception('RoutedSpecialPage requires action_index function to be set.');
            }
            $this->action_index( $params );
            return;
        }

        /* Get path array */
        $route = explode( '/', $params );
        $call = 'action';

        /* Get functions */
        if (isset($route[0])) {
            $call .= '_'.$route[0];
            unset($route[0]);
        }
        if (isset($route[1])) {
            $call .= '_'.$route[1];
            unset($route[1]);
        }

        $params = array();
        foreach( $route as $step ) {
            $params[] = $step;
        }

        /* Remove trailing slash */
        if($call[strlen($call)-1]=='_') {
            $call = substr($call,0,strlen($call)-1);

        }

        /* Run method */
        if ( !(int)method_exists($this, $call) ) {
            $wgOut->redirect( Title::makeTitleSafe(NS_SPECIAL, $this->mName)->getFullURL() );
            return;
        }else{
            $this->$call( $params );
        }

    }


    /**
     * Return url to routed page entry point
     * @return String
     */
    protected function getIndexURL() {
        return $this->getTitle()->getFullURL();
    }

    /**
     * Return action url
     * @param string $action
     * @param string|array $params
     * @return string
     */
    protected function getActionURL( $action, $params = null ) {
        if (!is_array($params)) $params = array( $params );
        return $this->getTitle()->getFullURL() .'/'. (($action[0]=='/') ? substr($action,1) : $action)
            . ( count($params) ? '/'.implode('/', $params) : '' );
    }

    /**
     * Return inherited class file name
     * @return string
     */
    protected function getFullFile()
    {
        $c = new ReflectionClass($this);
        return $c->getFileName();
    }


	/**
	 * Forge view
	 * @param $viewName
	 * @param array $data
	 * @throws Exception
	 */
    protected function view( $viewName, $data = array() ) {

        global $wgOut;

		/* Replace bad characters */
		$viewName = preg_replace('/[^a-zA-Z\-_\.]/','',$viewName);

        /* Find view */
        $viewFile = dirname( $this->getFullFile() ).'/views/'.$viewName.'.php';

        if (!file_exists($viewFile)) {
			throw new Exception('Wikivote RoutedSpecialPage: there is no view at '.$viewFile);
		}

        /* TODO: Dynamic i18n loading
        $langFile = dirname( $this->getFullFile() ).'/i18n/'.$viewName.'.php';


            if (file_exists($langFile)) {

            $extDir = preg_split('#\\\\|/#', $langFile);
            $extName = $extDir[array_search('extensions', $extDir)+1];

            global $wgExtensionMessagesFiles;
            $wgExtensionMessagesFiles['VotingSpecial'] = $langFile;
        }*/

        /* Load view */
        extract($data, EXTR_REFS);

        // Capture the view output
        ob_start();

        try
        {
            // Load the view within the current scope
            include $viewFile;
        }
        catch (\Exception $e)
        {
            // Delete the output buffer
            ob_end_clean();

            // Re-throw the exception
            throw $e;
        }

        // Get the captured output and close the buffer
        $ret = ob_get_clean();

        $wgOut->addHtml( $ret );

    }

}
