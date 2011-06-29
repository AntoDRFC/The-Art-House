<?php
class Weblynx_Controllers_Base extends Zend_Controller_Action
{
	/**
	 * DB connection
	 */
	protected $db;

	/**
	 * DataMappers
	 */
	protected $dbMapper;
	
	/**
	 * Config Object
	 */
	protected $config;

	/**
	 * User object
	 */
	protected $user = null;
	
	/*
	 * Shorthand of $this->getRequest();
	 */
    protected $req;
    
    /**
	 * SESSION object
	 */
	protected $session;

	/**
	 * Perform generic init for controllers
	 *
	 *  - Sets up config+view objects
	 *  - creates navigation structure
	 *
	 */
	public function init()
	{		
                // set the current path
		$currentPath = rtrim($this->getRequest()->getPathInfo(), '/');
		if(!$currentPath){
			$currentPath = '/';
		}		                
                
		/*if(str_replace('/', '', $currentPath) == 'admin') {
		  $this->_redirect('/admin/login.php');                                 
		} */                                

		// setup config object
		$this->config = Zend_Registry::get('config');

		// setup db
		$this->db  = Zend_Db::factory($this->config->database->weblynx);                
                $this->dbMapper = new Weblynx_DataMappers_General($this->db);
                
                //var_dump($this->db->query('SELECT * FROM artists'));
                
                
		// if were in development mode, send unrouted requests to a holding page		
		if($this->config->development->mode == 'development') {
    		if($currentPath == '/') {
                $this->_redirect('/index.html');
			}
		}

        // setup the session
        Zend_Session::start();
        $this->session = new Zend_Session_Namespace();
        
		// setup the view
		$this->view = new Zend_View();
		$this->view->setScriptPath($this->config->paths->base . DIRECTORY_SEPARATOR . 'templates');

		$this->view->currentPath = $currentPath;
		$this->view->headJs = array();
		$this->view->js     = array();
		$this->view->css    = array();
		
		// set the current controller and action into to view
		$this->view->controller    = $this->getRequest()->getControllerName();
		$this->view->currentaction = $this->getRequest()->getActionName();
		        
        // create a shorthand verison of the $this->getRequest();
        $this->req = $this->getRequest();
        
        $navType = $this->config->settings->nav;
        
                // lets get the nav built up and sent to the view if were not in the admin panel
        if($this->view->controller != 'pagebuilder') {
            $currentpage = $this->req->getParam('currentpage', 'index');
            $useStrpos   = false;
            
            // is this page a subpage?
            $pageinfo = $this->dbMapper->getPageByPermalink($currentpage);
            if($pageinfo['parent'] != 0) {
                $parentInfo = $this->dbMapper->getPage($pageinfo['parent']);
                
                $currentpage = $parentInfo['permalink'];
            }
            
            // is this page not a CMS page but a plugin?
            if($this->view->controller != 'index') {
                $currentpage = $_SERVER['REQUEST_URI'];
                $useStrpos   = true;
            }
            
            if($navType == 'dynamic') {
                $nav = $this->buildNavigation(false, $currentpage, $useStrpos);
                $this->view->nav = $nav;
            } else {
                $this->view->currentPage = $currentpage;
                $this->view->nav = $this->view->render('nav.phtml');
            }
        }
        
        // was a form posted on the page thats errored?
        if(isset($this->session->formdata)) {
            $formdata = $this->session->formdata;
            unset($this->session->formdata);
            
            $this->view->formdata = $formdata;
        }
	}
    
		/**
	 * Build the navigation structure
	 */
    public function buildNavigation($parentonly = true, $currentpage, $strpos = false) {
        $parent    = $parentonly ? 0 : false;
        $published = 1;
                
        $pages = $this->dbMapper->getPages($parent, $published);
        
        $nav = '';
        foreach($pages as $page) {
            if(!$strpos) {
                $class = ($page['permalink'] == $currentpage) ? ' class="current"' : '';
            } else {
                $class = (strpos($currentpage, $page['permalink']) !== false) ? ' class="current"' : '';
            }
            
            if($page['permalink'] == 'index') {
                $nav .= sprintf('<li%s><a href="/">%s</a></li>', $class, $page['menu_text']);
            } else {
                $prependView = $page['type'] == 'page' ? '/view/' : '';
                $nav .= sprintf('<li%s><a href="%s%s">%s</a></li>', $class, $prependView, $page['permalink'], $page['menu_text']);
            }
        }
        
        return $nav;

    }
    
	/**
	 * Render the $template view
	 *
	 */
	public function renderView($template = "main.phtml")
	{
        // if there were errors, then these session variables have data (send it to the view)
        //$this->view->formErrors = Smart::ifsetor($_SESSION['formErrors'], null);
        //$this->view->prevPost   = Smart::ifsetor($_SESSION['prevPost'], null);
        
        // if we dont have an header, grab the default
        if(!isset($this->view->pageHeader)) {
            $header = $this->dbMapper->getPagesHeader();
            $this->view->pageHeader  = $header['picture'];
            $this->view->pageCaption = $header['caption'];
        }
        
        // Get all our stuff into the template
        $this->getResponse()->appendBody($this->view->render($template));

        // clear the session vars after rendering
        unset($_SESSION['prevPost']);
        unset($_SESSION['formErrors']);
	}

	/**
	 * Generate and set a CSRF token (in the session data)
	 *
	 * @return string The token
	 */
	public function createCsrfToken()
	{
		$token = md5(uniqid(rand(), TRUE));
		$time  = time();

		$_SESSION['csrf_tokens'][$token] = $time;

		return $token;
	}

	/**
	 * Check a $toCheck CSRF token against the value stored in the session
	 *
	 * @param  $toCheck
	 * @return boolean Whether the CSRF passed or not
	 */
	public function checkCsrfToken($toCheck, $maxAge = 10800)
	{
		$tokens = isset($_SESSION['csrf_tokens']) ? $_SESSION['csrf_tokens'] : array();

		if(isset($tokens[$toCheck])){

			// one-time use
			unset($_SESSION['csrf_tokens'][$toCheck]);

			$time = $tokens[$toCheck];
			$age = time() - $time;

			if(($age < $maxAge)){
				return true;
			}else{
				return false;
			}
		}
		return false;
	}

	/**
	 * Checks if the user is logged in or not
	 *
	 * @return boolean
	 */
	public function isLoggedIn()
	{
		// if the session variable is set, assume that user
		if(isset($_SESSION) && $_SESSION['user_id']){
			$this->user = $_SESSION;
			return true;
		}else{
			return false;
		}
	}

	/**
	 * turns a mysql result set into a valid key=>value array set ready for makeOptions
	 *
	 * @return array
	 */
	public function mysqlValuesToOptions($data, $key, $value) {
		$return = array();

		foreach($data as $option) {
			$return[$option[$key]] = $option[$value];
		}

		return $return;
	}
}