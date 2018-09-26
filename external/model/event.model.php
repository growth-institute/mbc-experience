<?php

	/**
	 * Event Class
	 *
	 * Event
	 *
	 * @version  1.0
	 * @author   Raul Vera <raul.vera@chimp.mx>
	 */
	class Event extends CROOD {

		public $id;
		public $id_user;
		public $event;
		public $category;
		public $instance;
		public $param_a;
		public $param_b;
		public $param_c;
		public $param_d;
		public $data;
		public $value_a;
		public $value_b;
		public $created;
		public $modified;

		/**
		 * Initialization callback
		 * @return nothing
		 */
		function init($args = false) {

			$now = date('Y-m-d H:i:s');

			$this->table = 					'v3_event';
			$this->table_fields = 			array('id', 'id_user', 'event', 'category', 'instance', 'param_a', 'param_b', 'param_c', 'param_d', 'data', 'value_a', 'value_b', 'created', 'modified');
			$this->update_fields = 			array('id_user', 'event', 'category', 'instance', 'param_a', 'param_b', 'param_c', 'param_d', 'data', 'value_a', 'value_b', 'modified');
			$this->singular_class_name = 	'Event';
			$this->plural_class_name = 		'Events';


			if (! $this->id ) {

				$this->id = '';
				$this->id_user = 0;
				$this->event = '';
				$this->category = '';
				$this->instance = '';
				$this->param_a = '';
				$this->param_b = '';
				$this->param_c = '';
				$this->param_d = '';
				$this->data = '';
				$this->value_a = '';
				$this->value_b = '';
				$this->created = $now;
				$this->modified = $now;
			}

			else {

				$args = $this->preInit($args);

				# Enter your logic here
				# ----------------------------------------------------------------------------------



				# ----------------------------------------------------------------------------------

				$args = $this->postInit($args);
			}
		}
	}

	# ==============================================================================================

	/**
	 * Events Class
	 *
	 * Events
	 *
	 * @version 1.0
	 * @author  Raul Vera <raul.vera@chimp.mx>
	 */
	class Events extends NORM {

		protected static $table = 					'v3_event';
		protected static $table_fields = 			array('id', 'id_user', 'event', 'category', 'instance', 'param_a', 'param_b', 'param_c', 'param_d', 'data', 'value_a', 'value_b', 'created', 'modified');
		protected static $singular_class_name = 	'Event';
		protected static $plural_class_name = 		'Events';

		public static function logEvent($id_user, $params) {
			global $site;
			$ret = false;
			# Get parameters
			$event = get_item($params, 'event');
			$category = get_item($params, 'category');
			$instance = get_item($params, 'instance');
			$param_a = get_item($params, 'param_a');
			$param_b = get_item($params, 'param_b');
			$param_c = get_item($params, 'param_c');
			$param_d = get_item($params, 'param_d');
			$data = get_item($params, 'data');
			$value_a = get_item($params, 'value_a');
			$value_b = get_item($params, 'value_b');
			# Check whether the event exists or not
			$conditions = "id_user = {$id_user} AND instance = '{$instance}'";
			$count = Events::count($conditions);

			log_to_file('EVENTO GUARDADO', "events-{$site->user->id}");
			log_to_file(print_r($params, 1), "events-{$site->user->id}");
			log_to_file(print_r($count, 1), "events-{$site->user->id}");

			if ($count == 0) {
				# Create new event object
				$event_obj = new Event();
				$event_obj->id_user = $id_user;
				$event_obj->event = $event;
				$event_obj->category = $category;
				$event_obj->instance = $instance;
				$event_obj->param_a = $param_a;
				$event_obj->param_b = $param_b;
				$event_obj->param_c = $param_c;
				$event_obj->param_d = $param_d;
				$event_obj->data = $data;
				$event_obj->value_a = $value_a;
				$event_obj->value_b = $value_b;
				# Save and return: and Event object on success, FALSE otherwise
				$event_obj->save();
				if ($event_obj->id) {
					$ret = $event_obj;
				}
			}
			return $ret;
		}
	}
?>