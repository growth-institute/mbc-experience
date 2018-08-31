<?php

	class ClientMbcController extends Controller {

		function init() {
			global $site;
			$site->enqueueScript('client');
		}

		function indexAction() {
			global $site;
			$request = $site->getRequest();
			$response = $site->getResponse();
			# Nothing to do here, raise a 404
			$site->redirectTo( $site->urlTo('/error') );
			#
			return $response->respond();
		}

		function showAction($id) {
			global $site;
			$request = $site->getRequest();
			$response = $site->getResponse();
			#
			$product = Products::getBySlug($id);
			if ($product && $product->type == 'MBC' && $product->status == 'Published') {
				# Fetch taxonomies
				$base_taxonomy_id = $product->getMeta('base_taxonomy');
				$base_taxonomy = Taxonomies::getById($base_taxonomy_id);
				$modules = $base_taxonomy ? $base_taxonomy->getChildren() : null;
				# Save event
				$params = [];
				$params['category'] = 'mbc';
				$params['event'] = 'view';
				$params['instance'] = "{$site->sid}_mbc_view_{$product->id}";
				$params['param_a'] = $site->sid;
				$params['param_b'] = $product->id;
				Events::logEvent(1, $params);
				# Render template
				$data = [];
				$data['product'] = $product;
				$data['modules'] = $modules;
				$site->render('client/mbc/page-show', $data);
			} else {
				$site->redirectTo( $site->urlTo('/error') );
			}
			#
			return $response->respond();
		}
		function landingAction($id) {
			global $site;
			$request = $site->getRequest();
			$response = $site->getResponse();
			#
			$site->render('client/mbc/landing-page');
			#
			return $response->respond();
		}
		function detailAction($id) {
			global $site;
			$request = $site->getRequest();
			$response = $site->getResponse();
			#
			$site->render('client/mbc/details-page');
			#
			return $response->respond();
		}
		function moduleAction($id) {
			global $site;
			$request = $site->getRequest();
			$response = $site->getResponse();
			#
			$ret = false;
			#
			if ($request->mvc->format == 'json') {
				$params = [];
				$params['pdoargs'] = ['fetch_metas'];
				$taxonomy = Taxonomies::getBySlug($id, $params);
				if ($taxonomy && $taxonomy->type == 'Module') {
					#
					$taxonomy->children = $taxonomy->getChildren();
					# Save event
					$params = [];
					$params['category'] = 'mbc';
					$params['event'] = 'module';
					$params['instance'] = "{$site->sid}_mbc_module_{$taxonomy->id}";
					$params['param_a'] = $site->sid;
					$params['param_b'] = $taxonomy->id;
					Events::logEvent(1, $params);
					#
					$data = [];
					$data['module_completion'] = $taxonomy->getCompletion(1); #TBD: TBD_SET_USER
					$data['taxonomy'] = $taxonomy;
					$data['fetch'] = 'taxonomy';
					$ret = $response->ajaxRespond('success', $data);
				} else {
					$ret = $response->ajaxRespond('error');
				}
			} else {
				$site->redirectTo( $site->urlTo('/error') );
				$ret = $response->respond();
			}
			#
			return $ret;
		}

		function sessionAction($id) {
			global $site;
			$request = $site->getRequest();
			$response = $site->getResponse();
			#
			$ret = false;
			#
			if ($request->mvc->format == 'json') {
				$params = [];
				$params['pdoargs'] = ['fetch_metas'];
				$taxonomy = Taxonomies::getBySlug($id, $params);
				if ($taxonomy && $taxonomy->type == 'Session') {
					#
					$parent_taxonomy = Taxonomies::getById($taxonomy->id_parent);
					#
					$taxonomy->children = Blocks::allByIdCategory($taxonomy->id);
					# Save event
					$params = [];
					$params['category'] = 'mbc';
					$params['event'] = 'session';
					$params['instance'] = "{$site->sid}_mbc_session_{$taxonomy->id}";
					$params['param_a'] = $site->sid;
					$params['param_b'] = $taxonomy->id;
					Events::logEvent(1, $params);
					#
					$data = [];
					$data['taxonomy'] = $taxonomy;
					$data['module_completion'] = $parent_taxonomy->getCompletion(1); #TBD: TBD_SET_USER
					$data['fetch'] = 'block';
					$ret = $response->ajaxRespond('success', $data);
				} else {
					$ret = $response->ajaxRespond('error');
				}
			} else {
				$site->redirectTo( $site->urlTo('/error') );
				$ret = $response->respond();
			}
			#
			return $ret;
		}

		function unitAction($id) {
			global $site;
			$request = $site->getRequest();
			$response = $site->getResponse();
			#
			$ret = false;
			#
			if ($request->mvc->format == 'json') {
				$params = [];
				$params['pdoargs'] = ['fetch_metas'];
				$block = Blocks::getBySlug($id, $params);
				if ($block) {
					# Save event
					$params = [];
					$params['category'] = 'mbc';
					$params['event'] = 'block';
					$params['instance'] = "{$site->sid}_mbc_block_{$block->id}";
					$params['param_a'] = $site->sid;
					$params['param_b'] = $block->id;
					$params['value_b'] = 0;
					#
					switch ($block->type) {
						case 'Video':
						break;
						case 'File':
							$params['value_a'] = count( get_item($block->metas, 'file_attachments', []) );
						break;
						case 'Post':
						case 'Iframe':
							$params['value_b'] = 100;
						break;
						case 'Live Session':
						break;
					}
					#
					$event_params = [];
					$event_params['conditions'] = "instance = '{$site->sid}_mbc_block_{$block->id}' AND id_user = 1";
					$event = Events::get($event_params); #TBD: TBD_SET_USER2
					#
					if($event && $event->value_b != $params['value_b']) {
						$event->value_b = $params['value_b'];
						$event->save();
					} else {
						Events::logEvent(1, $params);
					}
					#
					$data = [];
					$data['block'] = $block;
					$data['fetch'] = null;
					$data['complete'] = $block->isComplete(1); #TBD: TBD_SET_USER
					$ret = $response->ajaxRespond('success', $data);
				} else {
					$ret = $response->ajaxRespond('error');
				}
			} else {
				$site->redirectTo( $site->urlTo('/error') );
				$ret = $response->respond();
			}
			#
			return $ret;
		}

		function attachmentAction($id) {
			global $site;
			$request = $site->getRequest();
			$response = $site->getResponse();
			#
			$ret = false;
			#
			$block = Blocks::getById($id);
			if ($block) {
				switch ($request->type) {
					case 'get':
						$token = $request->get('token');
						$id_attachment = Tokenizr::getData($token);
						$attachment = Attachments::getById($id_attachment);
						if ($attachment) {
							$response->setHeader('Content-Type', 'application/octet-stream');
							$response->setHeader('Content-Length', filesize( $attachment->getPath() ));
							$response->setHeader('Content-Transfer-Encoding', 'Binary');
							$response->setHeader('Content-disposition', 'attachment; filename="'.$attachment->attachment.'"');
							$response->setBody( readfile( $attachment->getPath() ) );
							//
							$params = [];
							$params['category'] = 'mbc';
							$params['event'] = 'attachment';
							$params['instance'] = "mbc_attachment_{$block->id}_{$attachment->id}";
							$params['param_a'] = $block->id;
							$params['param_b'] = $attachment->id;
							Events::logEvent(1, $params);
							//
							$conditions = "event = 'attachment' AND category = 'mbc' AND param_a = {$block->id}";
							$downloaded = Events::count($conditions);
							$instance = "{$site->sid}_mbc_block_{$block->id}";
							$event = Events::getByInstance($instance);
							$completion = false;
							if ($event) {
								if ($downloaded >= $event->value_a) {
									$event->value_b = 100;
									$event->save();
								}
							}
							//
							$ret = $response->respond();
						}
					break;
					case 'post':
						$result = 'error';
						$data = [];
						//
						$id_attachment = $request->post('attachment');
						$attachment = Attachments::getById($id_attachment);
						if ($attachment) {
							$result = 'success';
							$token = Tokenizr::getToken($attachment->id);
							$attachment->size = number_format(filesize( $attachment->getPath() ) / 1024, 2);
							$attachment->url = $site->urlTo("/mbc/attachment/{$block->id}?token={$token}", false);
							$whitelist = ['id'];
							$data['block'] = sanitized_object($block, $whitelist);
							$whitelist = ['id', 'attachment', 'url', 'size'];
							$data['attachment'] = sanitized_object($attachment, $whitelist);
							//
							$ret = $response->ajaxRespond($result, $data);
						}
					break;
				}
			}
			#
			return $ret;
		}

		function videoProgressAction($id) {
			global $site;
			$request = $site->getRequest();
			$response = $site->getResponse();
			#
			$ret = false;
			#
			if($request->type == 'post') {

				$video_duration = $request->post('video_duration');
				$position = $request->post('position');
				$percent = $video_duration ? $position * 100 / $video_duration : 0;
				$completion = $percent >= 90;

				if($video_duration && $position) {

					$event_params = [];
					$event_params['conditions'] = "instance = '{$site->sid}_mbc_block_{$id}' AND id_user = 1"; #TBD: TBD_SET_USER2
					$event = Events::get($event_params);
					#
					if($event) {

						if($event->value_a < $position) {

							$event->value_a = $position;
							if($completion) {
								$event->value_b = 100;
							}
							$event->save();
						}

					} else {

						$params = [];
						$params['category'] = 'mbc';
						$params['event'] = 'block';
						$params['instance'] = "{$site->sid}_mbc_block_{$id}";
						$params['param_a'] = $site->sid;
						$params['param_b'] = $id;
						$params['value_b'] = $completion ? 100 : 0;

						Events::logEvent(1, $params);
					}

					$data = [];
					$data['completion'] = $completion;
					$ret = $response->ajaxRespond('success', $data);
				}
			} else {

				$ret = $response->ajaxRespond('error');
			}

			return $ret;
		}
	}
?>