<?php $this->partial('header-html'); ?>
	<?php $this->partial('header'); ?>

		<section class="section section-course-details">
			<?php $this->partial('mbc/navigation', ['product' => $product, 'title' => 'Dashboard', 'url' => $site->urlTo("/mbc/{$product->slug}/") ]); ?>

			<div class="block block-faq">
				<div class="inner boxfix-vert">
					<div class="margins">
						<h2 class="block-title">Implementation Plans</h2>
						<div class="block-introduction">
							<p>This is where your community implementation plans will be kept for future reference, along with links to the seminars themselves. Whenever you finish your implementation plan and allow it to be shared with the community, you’ll be able to see it here, alongside with the rest of the members’ plans.</p>
						</div>

						<div class="list-questions">

							<div class="question">
								<h4 class="js-question question-title"> September 2018 - Modern Leadership with Erik Qualman <span class="question-button button-right"><i class="fa fa-angle-right"></i></span><span class="question-button button-down"><i class="fa fa-angle-down"></i></span></h4>
								<div class="question-answer">
									<p>This first week is all about learning a few simple concepts that will make you a more effective leader in the digital age.</p>
								</div>
							</div>


							<div class="question">
								<h4 class="js-question question-title"> Seminar <span class="question-button button-right"><i class="fa fa-angle-right"></i></span><span class="question-button button-down"><i class="fa fa-angle-down"></i></span></h4>
								<div class="question-answer">
									<p>See the Seminar <a href="<?php $site->urlTo("/mbc/{$product->slug}", true); ?>" class="button button-primary">here<i class="fa fa-fw fa-angle-right button-right"></i></a></p>
								</div>
							</div>
							<div class="question">
								<h4 class="js-question question-title">Implementation Plans <span class="question-button button-right"><i class="fa fa-angle-right"></i></span><span class="question-button button-down"><i class="fa fa-angle-down"></i></span></h4>
								<div class="question-answer">

									<div class="implementation-plans">
										<div class="slider">
											<div class="slide">
												Intro
											</div>
											<div class="slide">
												<div class="embed-responsive">
													<iframe src="<?php $site->urlTo('/upload/Pago Mamá Agosto.pdf#zoom=100', true); ?>" frameborder="0"></iframe>
												</div>
											</div>
											<div class="slide">
												<div class="embed-responsive">
													<iframe src="<?php $site->urlTo('/upload/Pago Shai Septiembre 2018 (2).pdf#zoom=100', true); ?>" frameborder="0"></iframe>
												</div>
											</div>
										</div>
										<div class="slider-navigation">
											<a href="#" class="button button-prev">Previous Plan</a>
											<a href="#" class="button button-next">Next Plan</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

	<?php $this->partial('footer'); ?>
<?php $this->partial('footer-html'); ?>