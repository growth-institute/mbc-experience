<?php

	class SurveyGizmo extends Module {

		function __construct() {}

		static function surveyWebhook() {
			global $site;
			$request = $site->getRequest();

			$response = $request->post('response');
			log_to_file(print_r($response, 1), 'SurveyGizmo');

			if($response) {

				if(isset($response['url_variables'])) {

					$uid = isset($response['url_variables']['uid']) ? $response['url_variables']['uid']['value'] : false;
					$sid = isset($response['url_variables']['sid']) ? $response['url_variables']['sid']['value'] : false;
					$bid = isset($response['url_variables']['bid']) ? $response['url_variables']['bid']['value'] : false;

					if($uid && $sid && $bid) {

						log_to_file("{$sid}_mbc_block_{$bid}", 'surveyGizmo');

						$event_params = [];
						$event_params['conditions'] = "instance = '{$sid}_mbc_block_{$bid}' AND id_user = {$uid}";
						$event = Events::get($event_params);

						log_to_file(print_r($event, 1), 'surveyGizmo');

						if($event) {

							$event->data = json_encode($response['survey_data']);
							$event->value_b = 100;
							$event->save();
						}
					}
				}
			}
			return true;
		}
	}

	$site->getRouter()->addRoute('/surveygizmo/webhook', 'SurveyGizmo::surveyWebhook', true);
?>