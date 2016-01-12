<?php

	/**
	 * ==============================
	 * Router
	 * ==============================
	 */

	class Router {

		public $domain;
		private $routes;

		function __construct($domain){
			if(explode('.',$_SERVER['HTTP_HOST'])[0] == 'www'){
				$this -> domain = "http://www.$domain";
			}else{
				$this -> domain = "http://$domain";
			}
			$this -> routes = array();
	    }

		/**
		* Get URL Route.
		*
		* Decomposes the current URL into an array
		* to act as a router
		*
		* @access public
		* @return void
		*/
		public function getRoute(){
			$basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
	    	$url = substr($_SERVER['REQUEST_URI'], strlen($basepath));
	    	if(strstr($url, '?')){
		    	 $url = substr($url, 0, strpos($url, '?'));
			}
	    	$url = '/' . trim($url, '/');
	    	$url = str_replace("index.php", "", $url);
	    	return $url;
		}

		public function getBaseUrl(){
			return $this -> domain;
		}

		public function getFullUrl(){
			return $this -> getBaseUrl() . $this -> getRoute();
		}

		public function registerRoute($route, $view){
			$this -> routes[$route] = $view;
		}

		public function getRoutes(){
			return $this -> routes;
		}

		public function match(){
			return array_key_exists($this -> getRoute(), $this -> routes) || array_key_exists($this -> getRoute() . "/", $this -> routes);
		}

		public function getView(){
			return $this -> routes[$this -> getRoute()];
		}

		function __destruct() {

	    }

	}
?>