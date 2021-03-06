		<div class="action-bar">
			<div class="inner">
				<div class="margins-horz">
					<div class="row row-md">
						<div class="col col-6 col-md-6">
							<h2 class="bar-title">
								<a href="<?php $site->urlTo("/mbc/{$product->slug}", true); ?>" class="action-button button-back"><i class="fa fa-fw fa-home"></i></a>
								<?php $title_product = $product->getMeta('title_product'); ?>
								<span><?php echo $title_product; ?></span>
							</h2>
						</div>
						<div class="col col-6 col-md-6">
							<div class="bar-buttons">
								<span>
									Slack chat <a target='blank' href="https://join.slack.com/t/scalingupclub-beta/shared_invite/enQtNDI3Nzc0NTQyMTI5LTljNjYyN2E5N2VmNGYyNjY4ZGRlZmNlYzhmMTRhNWFmZTM3OWI1YWNmYmZlMjc4ODY1MmJkOTJmMzY0ZjQxODA" class=""><img class="" src="<?php $site->img('template/mbc/slack.ico');?>" alt="Growth Institute"></a>
									<a href="<?php echo $url; ?>" class="button button-primary" title="access_plans"><i class="fa fa-fw fa-sign-out"></i><span class="hide-mobile-inline"><?php echo $title; ?></span></a>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>