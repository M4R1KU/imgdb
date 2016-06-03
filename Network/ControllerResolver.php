<?php

namespace MKWeb\ImgDB\Network;
use MKWeb\ImgDB\Controller\Controller;

/**
 * With the CommandResolver class you can get
 * an instance of the requested Controlle
 * @property Request request
 * @author Mario Kunz
 *
 */


class ControllerResolver {

	private $defaultcontroller;
	private $path = 'Controller/';

	public function __construct($defaultcontroller) {
		$this->defaultcontroller = $defaultcontroller;
	}

	/**
	 * Returns an instance of the Controlle given trough the request object
	 *
	 * if no controller is set it takes the default Controller
	 * @param Request $request
	 * @param Response $response
	 * @return boolean <Controller, unknown>
	 */
	public function getController(Request $request, Response $response) {
		if (isset($request->params['controller'])) {
			$cont = "MKWeb\\ImgDB\\Controller\\" . ucfirst($request->params['controller']) . 'Controller';
		} else {
			$cont = $this->loadController($this->defaultcontroller);
		}

		$c = new $cont($request, $response);
		if (!($c instanceof Controller)) {
			return false;
		}
		return $c;
	}

	/**
	 * loads the given Controller from the filesystem and detects the Controllerclass
	 * @param string $controller
	 * @return string|void
	 */
	protected function loadController($controller) {

		if (!empty($controller)) {
			$class = "MKWeb\\ImgDB\\Controller\\" . ucfirst($controller) . "Controller";
			$file = $this->path . ucfirst($controller) . 'Controller.php';
			/*if (!file_exists($file)) {
				if (empty($this->defaultcontroller)) {
					return null;
				}
				$file = "{$this->path}{$this->defaultcontroller}Controller.php";
			}
			include_once($file);*/
			if (!class_exists($class, true)) {
				$this->request->params['action'] = 'Index';
				$this->request->params['passed']['error'] = '404';
				return "MKWeb\\ImgDB\\Controller\\ErrorController";
			}
			return $class;


		}


	}


}


 ?>
