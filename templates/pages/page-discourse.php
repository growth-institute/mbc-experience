<?php $this->partial('header-html'); ?>
	<?php $this->partial('header'); ?>

		<section class="section section-home">
			<div class="inner boxfix-vert">
				<div class="margins">

					<?php

						require_once $site->baseDir('/external/lib/discourse/DiscourseAPI.php');

						$api = new DiscourseAPI(
							"discourse.growthinstitute.com",
							'7b215947820d5dbc827c26da75fadfe64970e6e106b0e33c949384e1b9f8892c',
							'https'
						);

						$discourse_category = 'All-the-topics-regarding-On-Demand-Seminars';
						$topics = $api->getTopicsFromCategory($discourse_category);

						if($topics->http_code == 200) {

							print_a($topics->apiresult->topic_list);
						}
					?>

				</div>
			</div>
		</section>

	<?php $this->partial('footer'); ?>
<?php $this->partial('footer-html'); ?>