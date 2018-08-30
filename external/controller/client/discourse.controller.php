<?php

	class ClientDiscourseController extends Controller {

		function init() {
			global $site;
		}

		/**
		 * View topics
		 * @return nothing
		 */
		function topicsAction($category_id) {
			global $site;
			$request = $site->getRequest();
			$response = $site->getResponse();
			#
			$ret = false;
			#
			if ($request->mvc->format == 'json') {

				if ($category_id) {

					require_once $site->baseDir('/external/lib/discourse/DiscourseAPI.php');

					$api = new DiscourseAPI(
						"discourse.growthinstitute.com",
						'7b215947820d5dbc827c26da75fadfe64970e6e106b0e33c949384e1b9f8892c',
						'https'
					);

					$topics = $api->getTopicsFromCategory($category_id);
					$data = [];
					$data['type'] = 'topics';
					$data['topics'] = $topics;
					$data['category_id'] = $category_id;
					$ret = $response->ajaxRespond('success', $data);
				} else {
					$ret = $response->ajaxRespond('error');
				}

			} else {

				if($request->type == 'post') {

					$discourse_post = $request->post('body');
					$discourse_username = $request->post('username');
					$discourse_title = $request->post('title');

					if ($category_id) {

						require_once $site->baseDir('/external/lib/discourse/DiscourseAPI.php');

						$api = new DiscourseAPI(
							"discourse.growthinstitute.com",
							'7b215947820d5dbc827c26da75fadfe64970e6e106b0e33c949384e1b9f8892c',
							'https'
						);

						$topic_response = $api->createPost($discourse_post, 0, $category_id, $discourse_username, $discourse_title);
						$data = [];
						$data['message'] = $topic_response;
						$ret = $response->ajaxRespond('success', $data);
					}

				} else {

					$site->redirectTo( $site->urlTo('/error') );
					$ret = $response->respond();
				}
			}
			#
			return $ret;
		}

		/**
		 * View topic
		 * @return nothing
		 */
		function topicAction($topic_id) {
			global $site;
			$request = $site->getRequest();
			$response = $site->getResponse();
			#
			$ret = false;
			#
			if ($request->mvc->format == 'json') {

				if ($topic_id) {

					require_once $site->baseDir('/external/lib/discourse/DiscourseAPI.php');

					$api = new DiscourseAPI(
						"discourse.growthinstitute.com",
						'7b215947820d5dbc827c26da75fadfe64970e6e106b0e33c949384e1b9f8892c',
						'https'
					);

					$topic = $api->getTopic($topic_id);
					$data = [];
					$data['type'] = 'topic';
					$data['topic'] = $topic;
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

		/**
		 * Like topic post
		 * @return nothing
		 */
		function postAction($topic_id) {
			global $site;
			$request = $site->getRequest();
			$response = $site->getResponse();
			#
			$ret = false;
			#
			if($request->type == 'post') {

				$discourse_post = $request->post('discourse-post');
				$discourse_username = $request->post('username');

				if ($topic_id) {

					require_once $site->baseDir('/external/lib/discourse/DiscourseAPI.php');

					$api = new DiscourseAPI(
						"discourse.growthinstitute.com",
						'7b215947820d5dbc827c26da75fadfe64970e6e106b0e33c949384e1b9f8892c',
						'https'
					);

					$post_response = $api->createPost($discourse_post, $topic_id, 0, $discourse_username);
					$data = [];
					$data['message'] = $post_response;
					$ret = $response->ajaxRespond('success', $data);
				} else {
					$ret = $response->ajaxRespond('error');
				}
			}

			#
			return $ret;
		}

		/**
		 * Like topic post
		 * @return nothing
		 */
		function likePostAction($post_id) {
			global $site;
			$request = $site->getRequest();
			$response = $site->getResponse();
			#
			$ret = false;
			#
			if ($post_id) {

				require_once $site->baseDir('/external/lib/discourse/DiscourseAPI.php');

				$api = new DiscourseAPI(
					"discourse.growthinstitute.com",
					'7b215947820d5dbc827c26da75fadfe64970e6e106b0e33c949384e1b9f8892c',
					'https'
				);

				$topic = $api->getTopic($topic_id);
				$data = [];
				$data['topic'] = $topic;
				$ret = $response->ajaxRespond('success', $data);
			} else {
				$ret = $response->ajaxRespond('error');
			}
			#
			return $ret;
		}
	}
?>