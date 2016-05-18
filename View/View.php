<?php

namespace MKWeb\ImgDB\View;

use MKWeb\ImgDB\Network\Request;
use MKWeb\ImgDB\Network\Response;

class View {

	/**
	 * contains the path to the template file
	 * @var string
	 */
	protected $template;

	/**
	 *	contains variables wich are assigned by controllers
	 * @var array
	 */
	protected $vars = array();

	/**
	 * contains body of response
	 * @var string
	 */
	protected $body = null;

	/**
	 * content of template file
	 * @var string
	 */
	protected $_content;

	/**
	 * current request object
	 * @var Request
	 */
	protected $request;

	/**
	 * current response object
	 * @var Response
	 */
	protected $response;

	public function __construct(Request $request, Response $response) {
		$this->request = $request;
		$this->response = $response;
	}

	/**
	 * renders the template in to the layout.php file
	 * and returns it to the controller
	 *
	 * @param  String $template path to template file
	 * @return String			html body string
	 */
	public function render($template) {

		$this->template = $template;
		ob_start();
		$this->_content = file_exists($this->template) ? file_get_contents($this->template) : file_get_contents('View/template/404.php');
		include_once('View/layout/layout.php');
		$this->body = ob_get_clean();
		return $this->body;
	}

	/**
	 * assigns variables from Controlleractions to the view
	 * @param String $name name of variable
	 * @param String $value value of the variable
	 */
	public function assign($name, $value) {
		$this->vars[$name] = $value;
	}

	/**
	 * magic getter method for the view class
	 * @param string $name variable to get
	 * @return mixed|null
	 */
	public function __get($name) {
		return isset($this->vars[$name]) ? $this->vars[$name] : null;
	}

	/**
	 * runs the code of the template file
	 */
	protected function _content() {
		eval('?>'.$this->_content);
	}

}

 ?>
