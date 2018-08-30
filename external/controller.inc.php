<?php

	/**
	 * Controller class
	 *
	 * A simple wrapper for controllers.
	 * You must override the init() method.
	 */
	abstract class Controller {

		protected $aliases;

		/**
		 * Constructor
		 */
		function __construct() {
			$this->aliases = array();
			$this->init();
		}

		/**
		 * Initialization callback, must be overriden in your extended classes
		 */
		abstract function init();

		function addActionAlias($action, $handler) {
			$this->aliases[$action] = $handler;
		}

		function getAliasedAction($action) {
			return isset( $this->aliases[$action] ) ? $this->aliases[$action] : false;
		}
	}

?>