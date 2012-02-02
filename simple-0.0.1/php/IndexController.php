<?php
/** 
  * rawphpy 0.0.1
  *
  * A Framework approach for rapid prototyping websites based
  * on a simple structure definition in XML and PHP
  *
**/
class IndexController {
	protected $config;
	public $view;
	static public $URI = REQUEST_URI;
	//static private $Routing = array( array('page', /*'action',*/'param'),  

	/**
	  * 0. Get base vars and config: this -> config;
	  * 1. Get model aka XML-file and navigation: $this -> _model;
	  * 2. Get environment by XML-element, config etc. -> ???
	  * 3. view, action, render?! (pre, post, etc?)
	  *
	**/
	/**  [/view]/page[/-param1/-param2] Commony action/param
	 * Defaultaction: index, render(HTML)
	 * array('view','page','param'),
	 * array('page','action'),
	 * array('page'),
	 * );
     *
	 *static private $ActionParam = array('test' => array('overview' => 0 // page/overview/[0-n]
	), );
	 */

	protected $_model;
	
	
	function __construct() {
		$this -> config = $this -> configuration = $this -> _setConfig();
		$this -> navigation = $this -> getNavigation();
		$this -> page = $this -> _model -> getCurrent();
  		$this -> page_id = $this -> page -> getAttribute('id');
		$this -> view = $this -> configuration = $this -> _setView();
		

		#show($this->page);

	}

	public function getNavigation() {
		$this -> _getModel();
	}
	
	protected function _getModel () {
		/** setModel, **/

		if (null === $this->_model) {
			
			require_once 'NavigationElement.php';
			$xmldata = file_get_contents(BASE_PATH .'/cfg/'. $this -> config['xml']['navigation-pub']);
    	    $this->_model = Model_NavigationElement::_new($xmldata, $URI);
       		
			echo self::$URI;
			
			$this->_model->init(self::$URI);
			

			
        }
        return $this->_model;
	}
	protected function _do ($action = 'render') {
		/** setRouting, setContent, setRender **/
	}

	protected function _render($view = 'default') {
		/** getNavigation, getContent, Output **/
	}

	protected function _getRouting() {
		#forwead
	}

	protected function _setParam() {
		return $param;
	}

	protected function _setPage() {
		return $page;
	}

	protected function _setView() {
		foreach ($this -> config['view'] as $view) {
			// define view mode
		}
		return $this -> config['view']['default'];
	}

	protected function _setURL() {

	}

	protected function _setConfig() {
		require_once BASE_PATH . '/cfg/config.php';
		return $config;
	}

}
