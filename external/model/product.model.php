<?php

	/**
	 * Product Class
	 *
	 * Product
	 *
	 * @version  1.0
	 * @author   Raul Vera <raul.vera@chimp.mx>
	 */
	class Product extends CROOD {

		public $id;
		public $id_parent;
		public $name;
		public $slug;
		public $codename;
		public $type;
		public $status;
		public $created;
		public $modified;

		/**
		 * Initialization callback
		 * @return nothing
		 */
		function init($args = false) {

			$now = date('Y-m-d H:i:s');

			$this->table = 					'v3_product';
			$this->table_fields = 			array('id', 'id_parent', 'name', 'slug', 'codename', 'type', 'status', 'created', 'modified');
			$this->update_fields = 			array('id_parent', 'name', 'slug', 'codename', 'type', 'status', 'modified');
			$this->singular_class_name = 	'Product';
			$this->plural_class_name = 		'Products';


			#metaModel
			$this->meta_id = 				'id_product';
			$this->meta_table = 			'v3_product_meta';

			if (! $this->id ) {

				$this->id = '';
				$this->id_parent = 0;
				$this->name = '';
				$this->slug = '';
				$this->codename = '';
				$this->type = '';
				$this->status = '';
				$this->created = $now;
				$this->modified = $now;
				$this->metas = new stdClass();
			}

			else {

				$args = $this->preInit($args);

				# Enter your logic here
				# ----------------------------------------------------------------------------------

				$this->updateChildrenCache();

				# ----------------------------------------------------------------------------------

				$args = $this->postInit($args);
			}
		}

		function updateChildrenCache($force = false) {
			$children_updated = $this->getMeta('children_updated', 0);
			# Children cache expires after 12 hours
			if ( $force || timestamp_expired($children_updated, 43200) ) {
				# Note: Here we'll assume a simple module > session > block hierarchy to
				# speed things up, if the hierarchy changes this may not work as intended
				$prd_cache = [];
				$prd_cache['taxonomy'] = [];
				$prd_cache['block'] = [];
				# Get base taxonomy
				$taxonomy = Taxonomies::getById( $this->getMeta('base_taxonomy', 0) );
				if ($taxonomy) {
					# Get modules
					$modules = $taxonomy->getChildren();
					if ($modules) {
						foreach ($modules as $module) {
							$prd_cache['taxonomy'][] = $module->id;
							$mod_cache = [];
							$mod_cache['taxonomy'] = [];
							$mod_cache['block'] = [];
							# Get sessions
							$sessions = $module->getChildren();
							if ($sessions) {
								foreach ($sessions as $session) {
									$prd_cache['taxonomy'][] = $session->id;
									$mod_cache['taxonomy'][] = $session->id;
									$ses_cache = [];
									$ses_cache['taxonomy'] = [];
									$ses_cache['block'] = [];
									# Get blocks
									$blocks = Blocks::allByIdCategory($session->id);
									if ($blocks) {
										foreach ($blocks as $block) {
											$prd_cache['block'][] = $block->id;
											$mod_cache['block'][] = $block->id;
											$ses_cache['block'][] = $block->id;
										}
									}
									$session->updateMeta('children_cache', $ses_cache);
								}
							}
							$module->updateMeta('children_cache', $mod_cache);
						}
					}
					sort( $prd_cache['taxonomy'] );
					sort( $prd_cache['block'] );
				}
				$this->updateMeta('children_cache', $prd_cache);
				$this->updateMeta('children_updated', time());
			}
		}

		function getCompletion($id_user) {
			global $site;
			$dbh = $site->getDatabase();
			$ret = false;
			$children_cache = $this->getMeta('children_cache');
			switch ($this->type) {
				case 'MBC':
					# Step 1: Check how many of the taxonomies (modules & sessions) have been clicked at least once
					$total_tax = count( $children_cache['taxonomy'] );
					$complete_tax = 0;
					try {
						$tax_ids = implode(',', $children_cache['taxonomy']);
						$sql = "SELECT COUNT(id) AS count FROM v3_event WHERE category = 'mbc' AND event IN ('module', 'session') AND param_b IN ($tax_ids) AND id_user = :id_user";
						$stmt = $dbh->prepare($sql);
						$stmt->bindValue(':id_user', $id_user);
						$stmt->execute();
						$row = $stmt->fetch();
						if ($row) {
							$complete_tax = $row->count;
						}
					} catch (PDOException $e) {
						error_log( $e->getMessage() );
					}
					# Step 2: Check how many of the blocks (steps) have been completed (that is, its value_b is equal to 100)
					$total_blk = count( $children_cache['block'] );
					$complete_blk = 0;
					try {
						$blk_ids = implode(',', $children_cache['block']);
						$sql = "SELECT COUNT(id) AS count FROM v3_event WHERE category = 'mbc' AND event = 'block' AND param_b IN ($blk_ids) AND value_b = 100 AND id_user = :id_user";
						$stmt = $dbh->prepare($sql);
						$stmt->bindValue(':id_user', $id_user);
						$stmt->execute();
						$row = $stmt->fetch();
						if ($row) {
							$complete_blk = $row->count;
						}
					} catch (PDOException $e) {
						error_log( $e->getMessage() );
					}
					# Now sum everything and get the grand total
					$total = $total_tax + $total_blk;
					$complete = $complete_tax + $complete_blk;
					$ret = $total > 0 ? ($complete / $total) * 100 : 0;
				break;
			}
			return $ret;
		}
	}

	# ==============================================================================================

	/**
	 * Products Class
	 *
	 * Products
	 *
	 * @version 1.0
	 * @author  Raul Vera <raul.vera@chimp.mx>
	 */
	class Products extends NORM {

		protected static $table = 					'v3_product';
		protected static $table_fields = 			array('id', 'id_parent', 'name', 'slug', 'codename', 'type', 'status', 'created', 'modified');
		protected static $singular_class_name = 	'Product';
		protected static $plural_class_name = 		'Products';
	}
?>