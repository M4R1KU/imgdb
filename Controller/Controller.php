<?php

namespace MKWeb\ImgDB\Controller;
use MKWeb\ImgDB\Network\Request;
use MKWeb\ImgDB\Network\Response;
use MKWeb\ImgDB\View\View;

/**
 * Major Controller class
 *
 * The Controller handles the actual request
 * and renders the response
 *
 * The Controller should have multiple subclasses with diffrent Controlleractions
 *
 * if the url /login/add is requested then it calls the add mehtod of the index controller
 *
 * with the redirect method it is possible to redirect within the controller action
 *
 * @author Mario Kunz
 *
 */
    class Controller {

        /**
         * template name of the request
         * @var String
         */
        private $template;

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

        /**
         * view Object
         * @var View
         */
        protected $view;

        /**
         * says if response should render or not
         * @var boolean
         */
        public $autorender = true;


        /**
         * contains all site url's where the user is allowed to go if he's not loggedin
         * @var array
         */
        private $allowedsites = array('/login/index',
                                      '/index/index',
                                      '/index/',
                                      '/index',
                                      '/');


        /**
         * controller Constructor
         * @param Request  $request  current request
         * @param Response $response response to send back
         */
        public function __construct(Request $request, Response $response) {
            $this->request = $request;
            $this->response = $response;
            $this->template = $this->_setTemplate($this->request->params['action']);
            $this->view = new View($request, $response);

            /**
             * checks if the user is logged in and when he's not
             * it will redirect it to the login page except for the sites in the allowedsites array
             */
            if (!isset($this->request->session['user_id'])) {
                if (!in_array($this->request->uri, $this->allowedsites)) {
                    header('Location: ' . ROOT . '/login/index');
                }
            } else {
                if (!preg_match('/\/login.*(?=logout).*/', $this->request->uri) && $this->request->uri !== '/index/index') {
                    header('Location: ' . ROOT . '/index/index');
                }
            }
        }

        /**
         * returns string of the template file path
         * @param $template
         * @return mixed path if file exists else false
         */
        protected function _setTemplate($template) {
            $cont = ucfirst($this->request->params['controller']);
            $action = $template;

            $path = "View/template/{$cont}/{$action}.php";
            if (!file_exists($path)) {
                return false;
            }
            return $path;
        }

        /**
         * invokes the controller action
         * @return mixed Respnse object or false if no action is defined
         */
        public function invokeAction() {
            if (isset($this->request->params['action'])) {
                return call_user_func(array($this, $this->request->params['action']));
            }
            return false;
        }

        /**
         * renders the view and sets the body of the response objec
         * @return Response object
         */
        public function render() {
            $this->response->body($this->view->render($this->template));
            $this->response->sendHeaders();
            return $this->response;
        }


        /**
         * redirects to the page with the given url
         *
         * declaration example: redirect(ROOT. '/login/index');
         *
         * @param  String $url url to redirect
         * @return Response response object with Location header
         */
        public function redirect($url) {
            $this->autorender = false;

            $response = $this->response;
            if (!$response->location()) {
                $response->location($url);
            }
            return $response;

        }

        /**
         * magic set method
         * @param String $name instance variable to set
         * @param mixed $value value for the instance variable
         */
        public function __set($name, $value) {
            $this->{$name} = $value;
        }

        /**
         * magic get method
         * @param  String $name name of variable to get
         * @return mixed       value of the instance variable
         */
        public function __get($name) {
            if (isset($this->$name)) {
                return $this->$name;
            }
            return null;
        }

    }
 ?>
