<?php

	class Request {

		/**
		 * HTTP method used to make the current request (get, post, etc.)
		 * @var string
		 */
		public $type;

		/**
		 * Request parts (controller, action, id and extra fragments)
		 * @var string
		 */
		public $parts;

		/**
		 * Constructor
		 */
		function __construct() {
			$this->type = strtolower( isset( $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'] ) ? $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'] : $_SERVER['REQUEST_METHOD'] );
			$this->parts = array();
		}

		/**
		 * Check whether the current request is secure (HTTPS) or not
		 * @return boolean True if the request was made via HTTPS, False otherwise
		 */
		function isSecure() {
			global $site;
			return $site->isSecureRequest();
		}

		/**
		 * Check whether the current request was made via AJAX or not
		 * @return boolean True if the request was made via AJAX, False otherwise
		 */
		function isAjax() {
			global $site;
			return $site->isAjaxRequest();
		}

		/**
		 * Check whether the current request was made via POST or not
		 * @return boolean True if the request was made via POST, False otherwise
		 */
		function isPost() {
			return !!$_POST;
		}

		/**
		 * Get a variable from the $_REQUEST superglobal
		 * @param  string $name    Variable name
		 * @param  string $default Default value to return if the variable is not set
		 * @return mixed           Variable value or $default
		 */
		function param($name, $default = '') {
			return isset( $_REQUEST[$name] ) ? $_REQUEST[$name] : $default;
		}

		/**
		 * Get a variable from the $_GET superglobal
		 * @param  string $name    Variable name
		 * @param  string $default Default value to return if the variable is not set
		 * @return mixed           Variable value or $default
		 */
		function get($name, $default = '') {
			return isset( $_GET[$name] ) ? $_GET[$name] : $default;
		}

		/**
		 * Get a variable from the $_POST superglobal
		 * @param  string $name    Variable name
		 * @param  string $default Default value to return if the variable is not set
		 * @return mixed           Variable value or $default
		 */
		function post($name, $default = '') {
			return isset( $_POST[$name] ) ? $_POST[$name] : $default;
		}

		/**
		 * Get a variable from the $_SESSION superglobal
		 * @param  string $name    Variable name
		 * @param  string $default Default value to return if the variable is not set
		 * @return mixed           Variable value or $default
		 */
		function session($name, $default = '') {
			return isset( $_SESSION[$name] ) ? $_SESSION[$name] : $default;
		}

		/**
		 * Get a file from the $_FILES superglobal
		 * @param  string $name File key
		 * @return mixed        Array with file properties or Null
		 */
		function files($name) {
			return isset( $_FILES[$name] ) ? $_FILES[$name] : null;
		}

		/**
		 * Get a variable from the $_SERVER superglobal
		 * @param  string $name    Variable name
		 * @param  string $default Default value to return if the variable is not set
		 * @return mixed           Variable value or $default
		 */
		function server($name, $default = '') {
			return isset( $_SERVER[$name] ) ? $_SERVER[$name] : $default;
		}
	}

?>