ModuleMBC = Module.extend({
	templates: {},
	discourseUser: null,
	sidebarHeight: function() {

		$('.product-sidebar .product-menu').height( ($('.product-area .unit-content').height() + $('.product-area .unit-footnotes').outerHeight() + 10) - $('.product-sidebar .product-progress').outerHeight() );
	},
	onDomReady: function($) {
		var obj = this;

		obj.templates.list = client.compileTemplate('#partial-list');
		obj.templates.listItem = client.compileTemplate('#partial-list-item');
		obj.templates.unitFootnotes = client.compileTemplate('#partial-unit-footnotes');

		obj.templates.discourseTopics = client.compileTemplate('#partial-discourse-topics');
		obj.templates.discourseTopic = client.compileTemplate('#partial-discourse-topic');

		obj.templates.blockFile = client.compileTemplate('#partial-block-file');

		obj.sidebarHeight();
		$(window).on('resize', function() {
			obj.sidebarHeight();
		});

		$('.progress-bar[data-progress]').each(function(index, el) {

			var el = $(this),
				progress = el.data('progress'),
				progressPortion = el.find('.progress-portion');

			progressPortion.animate({ width: progress });
		});

		$.ajax({
			url: 'https://discourse.growthinstitute.com/session/current.json',
			type: 'GET',
			dataType: 'json',
			xhrFields: { withCredentials: true },
			success: function(data) {

				console.log(data);
				obj.discourseUser = data.current_user;
			}
		});

		$('.mbc-show').on('click', '.js-mbc-fetch', function(e) {
			e.preventDefault();
			var el = $(this),
				li = el.closest('li'),
				href = el.attr('href');
			li.addClass('selected').siblings('li').removeClass('selected');
			client.ajaxCall({
				url: href,
				success: function(data) {
					if (data) {
						var list = li.children('.item-list'),
							container = $('.unit-content');
						if (! list.length ) {
							list = $( obj.templates.list() );
							li.append(list);
						}
						list.empty();
						if (!! data.taxonomy ) {
							// Is a taxonomy
							console.log('Taxonomy');
							_.each(data.taxonomy.children, function(item) {
								list.append( obj.templates.listItem({ fetch: data.fetch, item: item }) );
							});
							var content = data.taxonomy.metas['content_text'] || false;
							if(content) {
								container.empty();
								wrapper = $('<div class="margins"></div>');
								container.html( wrapper );
								wrapper.html( marked(content) );
								$('.unit-footnotes').html( obj.templates.unitFootnotes({ item: data.taxonomy }) );
							}
						} else if (!! data.block ) {
							// Is a learning unit
							console.log('Block');
							container.empty();
							container.append('<h2>'+ data.block.name +'</h2>');
							$('.unit-footnotes').html( obj.templates.unitFootnotes({ item: data.block }) );

							switch (data.block.type) {
								case 'Video':
									obj.setVideoBlock(container, data.block);
								break;
								case 'File':
									obj.setFileBlock(container, data.block);
								break;
								case 'Iframe':
									obj.setIframeBlock(container, data.block);
								break;
								case 'Survey':
									obj.setSurveyBlock(container, data.block);
								break;
								case 'Live Session':
									obj.setLiveSessionBlock(container, data.block);
								break;
							}
						}

						obj.sidebarHeight();
					}
				},
				complete: function() {
					//
				}
			});
		});

		$('.mbc-show').on('click', '.js-discourse-fetch', function(event) {
			event.preventDefault();
			var el = $(this),
				discourseArea = $('.discourse-area'),
				href = el.attr('href');
			client.ajaxCall({
				url: href,
				success: function(data) {
					if (data) {

						switch(data.type) {

							case 'topics':
								discourseArea.html( obj.templates.discourseTopics({
									topicsUsers: data.topics.apiresult.users,
									topics: data.topics.apiresult.topic_list.topics,
									categoryId: data.category_id
								}) );

								$('#topic-title').on('focus', function(event) {
									$('.new-topic-extras').show();
								});

								$('#topic-title').on('blur', function(event) {
									var el = $(this),
										val = el.val();
									if(!val) $('.new-topic-extras').hide();
								});

								$('#discourse-new-topic-form').ajaxForm({
									data: { username: obj.discourseUser.username },
									success: function(response, statusText, xhr, $form) {

										if(response.data.message.apiresult.errors) {

											//Return the error
											console.log(response.data.message.apiresult.errors);

										} else {

											$('.js-refresh-topics').trigger('click');
										}

									}
								});

							break;
							case 'topic':
								discourseArea.html( obj.templates.discourseTopic({
									topicPosts: data.topic.apiresult.post_stream.posts,
									topicTitle: data.topic.apiresult.fancy_title,
									categoryId: data.topic.apiresult.category_id,
									topicId: data.topic.apiresult.id,
								}) );


								$('#discourse-new-post-form').ajaxForm({
									data: { username: obj.discourseUser.username },
									success: function(responseText, statusText, xhr, $form) {
										$('.js-refresh-topic').trigger('click');
									}
								});

							break;
						}

						new SimpleMDE({
							promptURLs: true,
							element: document.getElementById('discourse-post-textarea'),
							spellChecker: false,
						});
					}
				},
				complete: function() {
					//
				}
			});
		});

		$('#load-topics').trigger('click');
	},
	setVideoBlock: function(container, block) {

		var obj = this,
			type = block.metas['video_type'] || 'embed';

		switch(type) {
			case 'videojs':
				var videoLink = block.metas['video_link'],
					track = '<track kind="captions" src="https://growthinstitute.com/upload/multiplicadores55089c1a7a140.vtt" srclang="es" label="Español" default>'
				container.html('<video controls id="block-video" class="vjs-default-skin video-js">' + track + '</video>');

				var player = videojs('block-video', {
					'sources': [{ 'src': videoLink }],
					'playbackRates': [ 0.25, 0.5, 1, 2 ]
				});

				player.ready(function() {

					console.log('Video Started');

					setInterval(function() {

						client.ajaxCall({
							url: constants.siteUrl + 'mbc/video-progress/' + block.id,
							type: 'post',
							data: { position: player.currentTime(), video_duration: block.metas['video_duration'] },
							success: function(data) {
							},
							complete: function() {
							}
						});

					}, 15000);
				});

			break;

			case 'embed':
				var embed = block.metas['video_embed'] || '',
					wrapper = $('<div class="embed-responsive"></div>');
				container.html( wrapper );
				wrapper.html( embed );
			break;
		}
	},
	setFileBlock: function(container, block) {
		var obj = this;
		container.html( obj.templates.blockFile({ block: block }) );
		obj.checkAttachments();
	},
	setIframeBlock: function(container, block) {
		var obj = this,
			type = block.metas['iframe_type'] || 'iframe',
			url = block.metas['iframe_url'] || false,
			wrapper = $('<div class="embed-responsive"></div>');

		if(url) {

			container.html( wrapper );
			wrapper.html('<iframe src="' + url + '" frameborder="0"></iframe>');
		}
	},
	setSurveyBlock: function(container, block) {
		var obj = this,
			provider = block.metas['survey_provider'],
			url = block.metas['survey_url'] || false;

		if(provider == 'surveygizmo') {

			var wrapper = $('<div class="embed-responsive"></div>');
			container.html( wrapper );
			wrapper.html('<iframe src="' + url + '?uid=1&amp;sid=' + constants.sid + '&amp;bid=' + block.id + '" frameborder="0"></iframe>');
		}
	},
	setLiveSessionBlock: function(container, block) {
		var obj = this;
		console.log('TBD: Set Live Session block content');
	},
	checkAttachments: function() {
		var obj = this;
		$('[data-attachment]').each(function() {
			var el = $(this),
				attachment = el.data('attachment'),
				block = el.data('block');
			client.ajaxCall({
				url: constants.siteUrl + '/mbc/attachment/' + block,
				type: 'post',
				data: {
					attachment: attachment
				},
				success: function(data) {
					if (data.attachment) {
						var item = el.closest('.attachment');
						item.find('.attachment-name').text(data.attachment.attachment);
						item.find('.attachment-size').text(data.attachment.size + ' KB');
						item.find('.attachment-link').attr('title', data.attachment.attachment).attr('href', data.attachment.url);
					}
				}
			});
		});
	}
});