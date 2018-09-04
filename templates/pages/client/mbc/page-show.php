<?php $this->partial('header-html'); ?>
	<?php $this->partial('header'); ?>

		<section class="section section-mbc">
			<div class="product-area">
				<div class="inner boxfix-vert">
					<div class="margins">
						<div class="the-content">
							<div class="row row-md row-5">
								<div class="col col-md-8">
									<div class="product-content">
										<div class="unit-content">
											<div class="valign-wrapper">
												<div class="valign">
													<p class="text-muted text-center">Choose a topic from the list to get started</p>
												</div>
											</div>
										</div>
									</div>

									<div class="unit-footnotes">
										<h2 class="footnotes-title"><?php sanitized_print($product->name); ?></h2>
										<h3>About this course</h3>
										<div class="the-content footnotes-about">
											<?php sanitized_print($product->getMeta('product_footnotes')); ?>
										</div>
									</div>
								</div>
								<div class="col col-md-4">
									<aside class="product-sidebar">
										<?php if(!$product->getMeta('hide_progress')): ?>
											<div class="product-progress">
												<h1 class="section-title"><?php sanitized_print($product->name); ?> <small class="text-muted">(<?php percent_print( $product->getCompletion(1) ); ?> Complete)</small></h1>
												<div class="progress-bar" data-progress="<?php percent_print( $product->getCompletion(1) ); ?>">
													<span class="progress-portion"></span>
												</div>
											</div>
										<?php endif; ?>

										<nav class="product-menu">
											<ul class="item-list">
												<?php
													if ($modules):
														foreach ($modules as $module):
												?>
													<li class="item">
														<a id="<?php sanitized_print($module->slug); ?>" href="<?php $site->urlTo("/mbc/module/{$module->slug}.json", true); ?>" class="item-name js-mbc-fetch"><i class="fa fa-fw fa-folder"></i> <?php sanitized_print($module->name); ?> <small class="text-muted">(<?php percent_print( $module->getCompletion(1) ); ?> Complete)</small></a>
													</li>
												<?php
														endforeach;
													endif;
												?>
											</ul>
										</nav>
									</aside>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php if(!$product->getMeta('hide_discourse')): ?>
				<div class="community-area">
					<div class="inner boxfix-vert">
						<div class="margins">
							<div class="the-content">

								<div class="discourse-area">
									<a id="load-topics" href="<?php $site->urlTo('/discourse/topics/5.json', true); ?>" class="js-discourse-fetch"></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</section>

		<script type="text/template" id="partial-discourse-topics">
			<div class="discourse-new-topic">
				<a href="<?php $site->urlTo('/discourse/topics/5.json', true); ?>" class="js-discourse-fetch js-refresh-topics"></a>

				<form id="discourse-new-topic-form" action="<?php $site->urlTo('/discourse/topics/', true); ?><%= categoryId %>" method="post">
					<div class="form-group">
						<label for="topic-title" class="control-label">Start a new discussion</label>
						<input id="topic-title" name="title" type="text" class="input-block form-control" placeholder="Post a question, discussion...">
					</div>
					<div class="new-topic-extras">
						<div class="form-group">
							<textarea class="input-block form-control" name="body" id="discourse-post-textarea" rows="10" placeholder="Leave a Comment"></textarea>
						</div>
						<p class="text-right"><button type="submit" class="button button-primary">Post new discussion</button></p>
					</div>
				</form>
			</div>
			<div class="discourse-topics">
				<% _.each(topics, function(topic) { %>

					<div class="discourse-topic cf" data-id="<%= topic.id %>">
						<%
							var posterId = topic.posters[0].user_id,
								posterObj = _.find(topicsUsers, function(obj) { return obj.id == posterId; }),
								avatarTemplate = posterObj.avatar_template;
								posterAvatar = ( avatarTemplate.includes('http') ? avatarTemplate : 'https://discourse.growthinstitute.com' + avatarTemplate );
						%>

						<img src="<%= posterAvatar.replace('{size}', 100) %>" alt="" class="avatar topic-avatar">

						<h2 class="topic-name">
							<a class="js-discourse-fetch" href="<?php $site->urlTo("/discourse/topic/", true); ?><%= topic.id %>.json"><%= topic.title %></a>
						</h2>

						<div class="topic-metas">
							<div class="topic-meta topic-likes"><%= topic.post_likes ? topic.post_likes : 0 %> <span>Like<%= topic.post_likes == 1 ? '' : 's' %></span></div>
							<div class="topic-meta topic-replies"><%= topic.posts_count ? topic.posts_count : 0 %> <span>Post<%= topic.posts_count == 1 ? '' : 's' %></span></div>
							<div class="topic-meta topic-views"><%= topic.views ? topic.views : 0 %> <span>View<%= topic.views == 1 ? '' : 's' %></span></div>

							<div class="topic-meta topic-users">
								<% _.each(topic.posters, function(poster) { %>
									<%
										var posterId = poster.user_id,
										posterObj = _.find(topicsUsers, function(obj) { return obj.id == posterId; }),
										avatarTemplate = posterObj.avatar_template;
										posterAvatar = ( avatarTemplate.includes('http') ? avatarTemplate : 'https://discourse.growthinstitute.com' + avatarTemplate );
									%>

									<img class="user-avatar avatar" src="<%= posterAvatar.replace('{size}', 100) %>" alt="">
								<% }) %>
							</div>
						</div>
					</div>

				<% }) %>
			</div>
		</script>

		<script type="text/template" id="partial-discourse-topic">
			<div class="discourse-topic-single boxfix-vert">

				<a href="<?php $site->urlTo('/discourse/topic/', true); ?><%= topicId %>.json" class="js-discourse-fetch js-refresh-topic"></a>

				<p class="text-right margins">
					<a href="<?php $site->urlTo('/discourse/topics/', true); ?><%= categoryId %>.json" class="js-discourse-fetch button button-primary">Return to topics</a>
				</p>

				<h2 class="topic-title"><%= topicTitle %></h2>
				<% _.each(topicPosts, function(post) { %>
					<article class="topic-post">
						<img class="avatar post-user-avatar" src="<%= ( post.avatar_template.includes('http') ? post.avatar_template : 'https://discourse.growthinstitute.com' + post.avatar_template ).replace('{size}', 100) %>" alt="<%= post.name %>">
						<div class="post-content discourse-content">
							<h3 class="post-user-name"><%= post.name %></h3>
							<%= post.cooked %>
						</div>
						<div class="post-actions">
							<a href="#" class="post-likes" data-like-id="<%= post.id %>">
								<span class="likes-icon"><i class="fa fa-heart"></i></span>
								<span class="likes-count"><%= post.actions_summary[0].count || 0 %></span>
							</a>
						</div>
					</article>
				<% }) %>

				<div class="post-comment-area">
					<form id="discourse-new-post-form" action="<?php $site->urlTo('/discourse/post/', true); ?><%= topicId %>" method="post">
						<div class="form-group">
							<textarea class="input-block form-control" name="body" id="discourse-post-textarea" cols="30" rows="10" placeholder="Leave a Comment"></textarea>
						</div>
						<p class="text-right"><button type="submit" class="button button-primary">Leave a comment</button></p>
					</form>
				</div>
			</div>
		</script>

		<script type="text/template" id="partial-list">
			<ul class="item-list"></ul>
		</script>

		<script type="text/template" id="partial-list-item">
			<li class="item">
				<a id="<%= item.slug %>" href="<%= constants.siteUrl + 'mbc/' + (fetch == 'taxonomy' ? item.type.toLowerCase() : 'unit') + '/' + item.slug + '.json' %>" class="item-name js-mbc-fetch" data-fetch="<%= fetch %>"><i class="fa fa-fw <%= fetch == 'block' ? 'fa-block-' + item.type.toLowerCase() : 'fa-folder'  %>"></i> <%=  item.name %></a>
			</li>
		</script>

		<script type="text/template" id="partial-unit-footnotes">
			<h2 class="footnotes-title"><%= item.name %></h2>
			<% if(item.metas.footnotes) { %>
				<h3>About this lesson</h3>
				<div class="the-content footnotes-about">
					<%= item.metas.footnotes %>
				</div>
			<% } %>
		</script>

		<script type="text/template" id="partial-block-file">
			<div class="box box-unit">
				<h2>Download the following files</h2>
				<%= marked(block.metas['file_content'] || 'iframe') %>
			</div>
			<div class="unit-attachments boxfix-vert">
				<div class="margins">
					<div class="row row-sm row-10">
						<% _.each(block.metas['file_attachments'] || [], function(attachment) { %>
							<div class="col col-sm-6 col-md-3">
								<div class="attachment">
									<i class="fa fa-fw fa-cloud-download attachment-icon"></i>
									<span class="attachment-name">Checking file...</span>
									<span class="attachment-size">0 KB</span>
									<a href="#" class="link-overlay attachment-link" title="" data-block="<%= block.id %>" data-attachment="<%= attachment %>"></a>
								</div>
							</div>
						<% }); %>
					</div>
				</div>
			</div>
		</script>

	<?php $this->partial('footer'); ?>
<?php $this->partial('footer-html'); ?>