<?php

namespace MKWeb\ImgDB\Network;

class Request
{

	/**
	 * uri without base
	 * @var string
	 */
    public $uri;

    /**
     * base uri wich is not used for the request to the controller
     * @var string
     */
    public $base;

    /**
     * current uri with controller and action
     * @var string
     */
    public $current;

    /**
     * holds all variables in the $_POST array
     * @var array
     */
    public $post;

    /**
     * holds all variables in the $_GET array
     * @var array
     */
    public $query;

    /**
     * holds all variables in the $_SESSION array
     * @var array
     */
    public $session;


    public $params = array(
        'controller' => null,
        'action' => null,
        'passed' => array()
    );

    /**
     * Request constructor.
     */
    public function __construct($config)
    {
        $this->_setConfig($config);

		$this->_setParams();
    }


    /**
     * returns a Request Object with the properties of the global variables
     * @return Request Object
     */
    public static function createRequest()
    {
		$base = static::_base();

        $config = array(
            'query' => $_GET,
            'post' => $_POST,
			'base' => $base,
			'webroot' => $base . '/',
            'session' => $_SESSION
        );


        $config['url'] = static::_url($config);
        return new static($config);

    }


	/**
	 * returns an uri string created with the config from above
	 * @param array $config
	 * @return mixed|string
	 */
    protected static function _url($config)
    {

        if (empty($_SERVER['REQUEST_URI']) || $_SERVER['REQUEST_URI'] === '/') {
            return '/';
        }
		$uri = strpos($config['base'], $_SERVER['REQUEST_URI']) !== false ? $_SERVER['REQUEST_URI'] : str_replace($config['base'], '', $_SERVER['REQUEST_URI']);
        if (strpos($uri, '?') !== false) {
            $tmp = explode('?', $uri);
			$uri = $tmp[0];
        }
        return $uri;
    }

    /**
     * returns the base uri of this project
     * (same as ROOT constant)
     */
	protected static function _base() {

		$root = ROOT;
		if (!empty($root)) {
			return ROOT;
		}
		return '/' . basename(dirname(__DIR__));

	}

	/**
	 * sets the config on the current Request object
	 * @param array $config
	 */
    protected function _setConfig($config) {

		$this->uri = $config['url'];
		$this->base = $config['base'];
		$this->current = $this->base . $this->uri;
        $this->session = $config['session'];

    }

    /**
     * sets the params in the params array
     *
     * splits the uri in the necessary parts
     */
    protected function _setParams() {


		$uriparts = trim(str_replace($this->base . '/', '', $_SERVER['REQUEST_URI']));

        if (strpos($uriparts, '?')) {
            $uriparts = substr_replace($uriparts, '', strpos($uriparts, '?'));
        }
		if ($uriparts !== '') {
			$uriparts = explode('/', $uriparts);
		}

		if (isset($uriparts[0]) && $uriparts[0] !== '') {
			$this->params['controller'] = $uriparts[0];
		}
		if (isset($uriparts[1]) && $uriparts[1] !== '') {
			$this->params['action'] = $uriparts[1];
		}
		if (empty($uriparts[0])) {
			$this->params['controller'] ='index';
		}
		if (empty($uriparts[1])) {
			$this->params['action'] = 'index';
		}

		$this->params['passed'] = array_merge($_GET, $_POST);

    }

}

?>
