<?php

	/**
	 * Block Class
	 *
	 * Block
	 *
	 * @version  1.0
	 * @author   Raul Vera <raul.vera@chimp.mx>
	 */
	class Block extends CROOD {

		public $id;
		public $name;
		public $codename;
		public $slug;
		public $type;
		public $status;
		public $completion;
		public $created;
		public $modified;

		/**
		 * Initialization callback
		 * @return nothing
		 */
		function init($args = false) {

			$now = date('Y-m-d H:i:s');

			$this->table = 					'v3_block';
			$this->table_fields = 			array('id', 'name', 'codename', 'slug', 'type', 'status', 'completion', 'created', 'modified');
			$this->update_fields = 			array('name', 'codename', 'slug', 'type', 'status', 'completion', 'modified');
			$this->singular_class_name = 	'Block';
			$this->plural_class_name = 		'Blocks';


			#metaModel
			$this->meta_id = 				'id_block';
			$this->meta_table = 			'v3_block_meta';

			if (! $this->id ) {

				$this->id = '';
				$this->name = '';
				$this->codename = '';
				$this->slug = '';
				$this->type = '';
				$this->status = '';
				$this->completion = '';
				$this->created = $now;
				$this->modified = $now;
				$this->metas = new stdClass();
			}

			else {

				$args = $this->preInit($args);

				# Enter your logic here
				# ----------------------------------------------------------------------------------



				# ----------------------------------------------------------------------------------

				$args = $this->postInit($args);
			}
		}

		function isComplete($id_user) {
			global $site;
			$dbh = $site->getDatabase();
			$ret = false;
			if ($this->completion) {
				# Uses an specific ruleset for completion
				$ret = true;
			} else {
				# Completion rules depend on the step type

				$params = array();
				$params['conditions'] = "event = 'block' AND id_user = {$id_user} AND param_b = {$this->id} AND value_b = 100";
				$event = Events::get($params);

				if($event) {
					$ret = true;
				}
			}
			return $ret;
		}
	}

	# ==============================================================================================

	/**
	 * Blocks Class
	 *
	 * Blocks
	 *
	 * @version 1.0
	 * @author  Raul Vera <raul.vera@chimp.mx>
	 */
	class Blocks extends NORM {

		protected static $table = 					'v3_block';
		protected static $table_fields = 			array('id', 'name', 'codename', 'slug', 'type', 'status', 'completion', 'created', 'modified');
		protected static $singular_class_name = 	'Block';
		protected static $plural_class_name = 		'Blocks';
	}
?>