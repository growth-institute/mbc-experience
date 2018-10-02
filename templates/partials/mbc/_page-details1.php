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
											<?php
												$files = glob($site->baseDir('/upload/*.{pdf}'), GLOB_BRACE);
											?>
											<?php
											if ($files):
												foreach ($files as $file):
													$file = basename($site->baseDir("/mbc-experience/upload/{$file}"));
													/*print_a($file);*/
											?>

													<div class="slide">
														<div class="embed-responsive">
															<iframe src="<?php $site->urlTo("/upload/{$file}#zoom=100", true); ?>" frameborder="0">
															</iframe>
														</div>
													</div>
												<?php endforeach; ?>
											<?php endif;?>
										</div>
										<div class="slider-navigation">
											<div class="row row-md row-sm">
												<div class="col col-sm-6">
													<a href="#" class="button button-primary button-prev">Previous Plan</a>
												</div>
												<div class="col col-sm-6">
													<p class="text-right">
														<a href="#" class="button button-primary button-next">Next Plan</a>
													</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
		</div>