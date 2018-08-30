<?php

	class ClientController extends Controller {

		function init() {
			global $site;
			$site->enqueueScript('client');
			$this->addActionAlias('home', 'indexAction');
		}

		function indexAction() {
			global $site;
			$request = $site->getRequest();
			$response = $site->getResponse();
			#
			$site->render('page-home');
			#
			return $response->respond();
		}

		function discourseAction() {
			global $site;
			$request = $site->getRequest();
			$response = $site->getResponse();
			#
			$site->render('page-discourse');
			#
			return $response->respond();
		}
	}

?>