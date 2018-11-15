<?php $this->partial('header-html'); ?>
	<?php $this->partial('header'); ?>

		<section class="section section-course-info">
			<?php $this->partial('mbc/navigation', ['product' => $product, 'title' => 'Access Plans', 'url' => $site->urlTo("/mbc/{$product->slug}/details") ]); ?>

			<div class="block block-content">
				<div class="inner boxfix-vert">
					<div class="margins-horz">
						<div class="row row-md">
							<div class="col col-12 col-md-12">
								<div class="metabox">
									<div class="metabox-header">
										<span>THIS MONTH - EVOLVED ENTERPRISE WITH YANIK SILVER</span>
									</div>
									<div class="metabox-body">
										<div class="row row-md">
											<div class="col col-6 col-md-6 show-mobile">
												<img class="img-responsive" src="<?php $site->img('template/mbc/suc-banner-w1-m2.png'); ?>" alt="Growth Institute">
											</div>
											<div class="col col-6 col-md-6">
												<div class="the-content">
													<h2>EXECUTION / LEARN</h2>
													<p>We’ve broken up Yanik’s seminar into a micro-learning format that teaches you how to highlight and build consensus around your core impact, and create a company with a greater purpose than profits. Watch or listen - however you think you’ll learn best - and make notes as you go along to help shape your implementation plan next week.</p>
												</div>
											</div>
											<div class="col col-6 col-md-6 hide-mobile">
												<a class="active" href="<?php $site->urlTo("/mbc/{$product->slug}/course#scaling-up-club-founding-members-engage", true); ?>">
													<img class="img-responsive" src="<?php $site->img('template/mbc/suc-banner-w1-m2.png'); ?>" alt="Growth Institute">
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="block block-content">
				<div class="inner boxfix-vert">
					<div class="margins-horz">
						<div class="row row-md">
							<div class="col col-6 col-md-6">
								<div class="metabox">
									<div class="metabox-header">
										<span>Weeks</span>
									</div>
									<div class="metabox-body body-simple">
										<div class="item-list">
											<a href="<?php $site->urlTo("/mbc/scaling-up-club-yanik-silver-evolved-enterprise/course#scaling-up-club-yanik-silver-evolved-enterprise-learn", true); ?>">
												<div class="item item-module">
													<div class="item-name">
														WEEK 1 - LEARN
													</div>
												</div>
											</a>

											<a class="active" href="<?php $site->urlTo("/mbc/scaling-up-club-yanik-silver-evolved-enterprise/course#scaling-up-club-yanik-silver-evolved-enterprise-plan", true); ?>">
												<div class="item item-module activeli">
													<div class="item-name">
														WEEK 2 - PLAN
													</div>
												</div>
											</a>

											<a href="<?php $site->urlTo("/mbc/scaling-up-club-yanik-silver-evolved-enterprise/course#scaling-up-club-yanik-silver-evolved-enterprise", true); ?>">
												<div class="item item-module">
													<div class="item-name">
														WEEK 3 - ENGAGE
													</div>
												</div>
											</a>

											<a href="<?php $site->urlTo("/mbc/scaling-up-yanik-silver-evolved-enterprise/course#scaling-up-club-yanik-silver-evolved-enterprise-implement", true); ?>">
												<div class="item item-module">
													<div class="item-name">
														WEEK 4 - IMPLEMENT
													</div>
												</div>
											</a>
										</div>
									</div>
								</div>
							</div>
							<div class="col col-6 col-md-6">
							<div class="month">
								<ul>
									<!-- <li class="prev">&#10094;</li>
									<li class="next">&#10095;</li> -->
									<li>
									EXECUTION MONTH<br>
									<span style="font-size:18px">YANIK SILVER: EVOLVED ENTERPRISE</span>
									</li>
								</ul>
							</div>

								<ul class="weekdays">
								<li></li>
								<li>Mo</li>
								<li>Tu</li>
								<li>We</li>
								<li>Th</li>
								<li>Fr</li>
								<li>Sa</li>
								<li>Su</li>
								</ul>

								<ul class="days">
								<li></li>
								<li></li>
								<li>30</li>
								<li>31</li>
								<li>1</li>
								<li>2</li>
								<li>3</li>
								<li>4</li>
								<li>Week 1</li>
								<li>5</li>
								<li>6</li>
								<li>7</li>
								<li>8</li>
								<li>9</li>
								<li>10</li>
								<li>11</li>
								<a class="active" href="<?php $site->urlTo("/mbc/{$product->slug}/course#scaling-up-club-yanik-silver-evolved-enterprise-plan", true); ?>">
									<li class="active">Week 2</li>
									<li class="active">12</li>
									<li class="active">13</li>
									<li class="active">14</li>
									<li class="active">15</li>
									<li class="active">16</li>
									<li class="active">17</li>
									<li class="active">18</li>
								</a>
								<li>Week 3</li>
								<li>19T</li>
								<li>20</li>
								<li>21</li>
								<li>22</li>
								<li>23</li>
								<li>24</li>
								<li>25</li>
								<!-- <a class="active" href="<?php $site->urlTo("/mbc/{$product->slug}/course#scaling-up-club-kaizen-back-to-the-basics-implement", true); ?>"> -->
									<li>Week 4</li>
									<li>26</li>
									<li>27</li>
									<li>28</li>
									<li>29</li>
									<li>30</li>
									<li></li>
									<li></li>
									<li></li>
								<!-- </a> -->
								</ul>
								<!-- <img class="img-responsive margin-bottom" src="<?php $site->img('template/mbc/suc-calendar-w3.png'); ?>" alt="Growth Institute"> -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="block block-content">
				<div class="inner boxfix-vert">
					<div class="margins-horz">
						<div class="row row-md">
							<div class="col col-12 col-md-12">
								<div class="metabox">
									<div class="metabox-header">
										<span>HOW THIS WORKS</span>
									</div>
									<div class="metabox-body">
										<div class="row row-md">
											<div class="col col-12 col-md-12">
												<div class="the-content">
													<h3>SUC - PLAN</h3>
													<p>The Scaling Up Club is being re-engineered to focus on guided implementation. We want to help you navigate the 4 stages of growth via the 6 core competencies needed to scale. Each month you will be taken through a process of learning and applying new concepts, broken down into 4 separate weeks of activity:</p>
													<ul>
														<li>Learn (watch or listen to the seminar).</li>
														<li>Plan (create your implementation plan using our template).</li>
														<li>Engage (attend a live webinar with the thought leader for tailored tips).</li>
														<li>Implement (participate in community discussions about how you’re going to use these concepts in your company).</li>
													</ul>
													<p>This month’s core competency is Leadership.</p>
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
			<div class="block block-faq">
				<div class="inner boxfix-vert">
					<div class="margins">
						<h2 class="block-title">Frequently asked questions</h2>

						<div class="list-questions">

							<div class="question">
								<h4 class="js-question question-title">What is a beta program? <span class="question-button button-right"><i class="fa fa-angle-right"></i></span><span class="question-button button-down"><i class="fa fa-angle-down"></i></span></h4>
								<div class="question-answer">
									<p>The beta program is an early access period for a select group of users, prior to the main launch at the end of the year. It gives us a chance to run some experiments on the usability and efficacy of the new Success Path, and provides our founding members with discounted access for life in return for their help in the early days.</p>
								</div>
							</div>

							<div class="question">
								<h4 class="js-question question-title">What is my role as a founding member? <span class="question-button button-right"><i class="fa fa-angle-right"></i></span><span class="question-button button-down"><i class="fa fa-angle-down"></i></span></h4>
								<div class="question-answer">
									<p>As part of the beta program, we’re relying on our members to provide feedback on the ease of use, results of implementation and things that just don’t feel right. We’ll be changing the experience where we see feedback trends emerge to provide a better platform for everyone. You’re also helping us build a community that we hope will eventually include tens of thousands of business leaders from around the world.</p>
								</div>
							</div>

							<div class="question">
								<h4 class="js-question question-title">What are the 4 Stages of Growth? <span class="question-button button-right"><i class="fa fa-angle-right"></i></span><span class="question-button button-down"><i class="fa fa-angle-down"></i></span></h4>
								<div class="question-answer">
									<p>The 4 stages are Start Up, Grow Up, Scale Up and Industry Domination. Every company goes through these stages!</p>
								</div>
							</div>

							<div class="question">
								<h4 class="js-question question-title">What are the 6 core competencies needed to scale? <span class="question-button button-right"><i class="fa fa-angle-right"></i></span><span class="question-button button-down"><i class="fa fa-angle-down"></i></span></h4>
								<div class="question-answer">
									<p>The 6 core competencies are Leadership, Strategy, Execution, Sales, Marketing, and Culture.</p>
								</div>
							</div>

							<div class="question">
								<h4 class="js-question question-title">Can I access a library of all the seminars? <span class="question-button button-right"><i class="fa fa-angle-right"></i></span><span class="question-button button-down"><i class="fa fa-angle-down"></i></span></h4>
								<div class="question-answer">
									<p>Yes. We’ll be moving everything onto a new platform in the coming months, but for now, beta members will have access to the existing Scaling Up Club library through their Growth Institute account. Please note, rather than being broken down into the micro-learning format, most of these will still be full length On-Demand Seminars and will not have an audio version accessible. You can access the library of On-Demand Seminars by clicking the tab “products” on the menu above and selecting “On-Demand Seminars”.</p>
								</div>
							</div>


							<div class="question">
								<h4 class="js-question question-title">Are all the steps mandatory? <span class="question-button button-right"><i class="fa fa-angle-right"></i></span><span class="question-button button-down"><i class="fa fa-angle-down"></i></span></h4>
								<div class="question-answer">
									<p>Nothing is mandatory, but you’ll get out what you put in. If you can’t complete a week’s activity you will still get access to all the remaining content for that month. You can always access implementation plan templates in the future and there will be a recording available of the live webinar for those who can’t make it on the day. We highly encourage you to keep the pace of the group and complete each step during the designated week.</p>
								</div>
							</div>

							<div class="question">
								<h4 class="js-question question-title">Who can I contact if I have problems or feedback? <span class="question-button button-right"><i class="fa fa-angle-right"></i></span><span class="question-button button-down"><i class="fa fa-angle-down"></i></span></h4>
								<div class="question-answer">
									<p>Feel free to email the Scaling Up Club Product Owner, Rowan Stanek, with any questions or comments. His email is <a href="mailto:rowan@growthinstitute.com">rowan@growthinstitute.com</a>. You can also contact us in the “Support” channel, inside our community chat in Slack.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</section>
	<?php $this->partial('footer'); ?>
<?php $this->partial('footer-html'); ?>