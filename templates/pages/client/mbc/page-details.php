<?php $this->partial('header-html'); ?>
	<?php $this->partial('header'); ?>

		<section class="section section-course-details">
			<?php $this->partial('mbc/navigation', ['product' => $product, 'title' => 'Dashboard', 'url' => $site->urlTo("/mbc/{$product->slug}/") ]); ?>

			<?php
			$plans_template = $product->getMeta('plans_template');
			//print_a($plans_template);
			if ($plans_template == 'page-details1') {

				$this->partial('mbc/page-details1');

			} else if($plans_template == 'page-details2') {

				$this->partial('mbc/page-details2');
			}
			?>

		</section>

	<?php $this->partial('footer'); ?>
<?php $this->partial('footer-html'); ?>