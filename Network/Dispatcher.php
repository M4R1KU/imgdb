<?php

namespace MKWeb\ImgDB\Network;
use MKWeb\ImgDB\Controller\Controller;


/**
 * dispatches the Request from the user
 *
 * @author Mario Kunz
 *
 */
class Dispatcher {

	public function __construct() {
	}

	/**
	 * calls an action of the requested controller
	 *
	 * a controller contains diffrent actions wich can be invoked trough the url
	 * the default action's name is "index"
	 * @param Request $request
	 * @param Response $response
	 */
	public function dispatch(Request $request, Response $response) {

		$cr = new ControllerResolver('Index');
		$controller = $cr->getController($request, $response);
		if (!$controller) header('Location: ' . ROOT . '/Error/Index?error=403');
		$response = $this->_invoke($controller);
		print $response->body();
	}

	/**
	 * invokes the controllers action via the invokeAction method in the controller class
	 * @param  Controller $controller current controller
	 * @return Response                 response object created by the controller
	 */
	protected function _invoke(Controller $controller) {
		$response = $controller->invokeAction();
		if (!$response && $controller->autorender) {
			$response = $controller->render();
		} else {
			 $response = $controller->response->send();
		}
		return $response;

	}


}
