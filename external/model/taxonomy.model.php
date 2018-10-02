<?php

	/**
	 * Taxonomy Class
	 *
	 * Taxonomy
	 *
	 * @version  1.0
	 * @author   Raul Vera <raul.vera@chimp.mx>
	 */
	class Taxonomy extends CROOD {

		public $id;
		public $id_parent;
		public $name;
		public $codename;
		public $slug;
		public $type;

		/**
		 * Initialization callback
		 * @return nothing
		 */
		function init($args = false) {

			$now = date('Y-m-d H:i:s');

			$this->table = 					'v3_taxonomy';
			$this->table_fields = 			array('id', 'id_parent', 'name', 'codename', 'slug', 'type');
			$this->update_fields = 			array('id_parent', 'name', 'codename', 'slug', 'type');
			$this->singular_class_name = 	'Taxonomy';
			$this->plural_class_name = 		'Taxonomies';

			#metaModel
			$this->meta_id = 				'id_taxonomy';
			$this->meta_table = 			'v3_taxonomy_meta';


			if (! $this->id ) {

				$this->id = '';
				$this->id_parent = 0;
				$this->name = '';
				$this->codename = '';
				$this->slug = '';
				$this->type = '';
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

		function getParent() {
			global $site;
			$ret = false;
			if ($this->id_parent) {
				$ret = Taxonomies::getById($this->id_parent);
			}
			return $ret;
		}

		function getChildren() {
			global $site;
			$ret = Taxonomies::AllByIdParent($this->id);
			return $ret;
		}

		function getCompletion($id_user) {
			global $site;
			$dbh = $site->getDatabase();
			$ret = false;
			$children_cache = $this->getMeta('children_cache');
			# Step 1: Check how many of the taxonomies (modules & sessions) have been clicked at least once
			$children_cache_taxonomy = isset($children_cache['taxonomy']) ? $children_cache['taxonomy'] : false;
			$children_cache_block = isset($children_cache['block']) ? $children_cache['block'] : false;
			$total_tax = $children_cache_taxonomy ? count( $children_cache_taxonomy ) : 0;

			$complete_tax = 0;
			try {
				$tax_ids = implode(',', $children_cache_taxonomy);
				$sql = "SELECT COUNT(count) AS count, SUM(count) AS sum FROM (
							SELECT COUNT(id) AS count FROM v3_event WHERE category = 'mbc' AND event IN ('module', 'session') AND param_b IN ($tax_ids) AND id_user = :id_user
						) foo";
				$stmt = $dbh->prepare($sql);
				$stmt->bindValue(':id_user', $id_user);
				$stmt->execute();
				$row = $stmt->fetch();
				if ($row) {
					$complete_tax = $row->sum > 0 ? $row->count : 0;
				}
			} catch (PDOException $e) {
				error_log( $e->getMessage() );
			}
			# Step 2: Check how many of the blocks (steps) have been completed (that is, its value_b is equal to 100)
			$total_blk = count( $children_cache_block );
			$complete_blk = 0;
			try {
				$blk_ids = implode(',', $children_cache_block);
				$sql = "SELECT COUNT(count) AS count, SUM(count) AS sum FROM (
							SELECT COUNT(id) AS count FROM v3_event WHERE category = 'mbc' AND event = 'block' AND param_b IN ($blk_ids) AND value_b = 100 AND id_user = :id_user
						) foo";
				$stmt = $dbh->prepare($sql);
				$stmt->bindValue(':id_user', $id_user);
				$stmt->execute();
				$row = $stmt->fetch();
				if ($row) {
					$complete_blk = $row->sum > 0 ? $row->count : 0;
				}
			} catch (PDOException $e) {
				error_log( $e->getMessage() );
			}

			# Now sum everything and get the grand total
			$total = $total_tax + $total_blk;
			$complete = $complete_tax + $complete_blk;
			$ret = $total > 0 ? ($complete / $total) * 100 : 0;
			return $ret;
		}
	}

	# ==============================================================================================

	/**
	 * Taxonomies Class
	 *
	 * Taxonomies
	 *
	 * @version 1.0
	 * @author  Raul Vera <raul.vera@chimp.mx>
	 */
	class Taxonomies extends NORM {

		protected static $table = 					'v3_taxonomy';
		protected static $table_fields = 			array('id', 'id_parent', 'name', 'codename', 'slug', 'type');
		protected static $singular_class_name = 	'Taxonomy';
		protected static $plural_class_name = 		'Taxonomies';
	}
?>