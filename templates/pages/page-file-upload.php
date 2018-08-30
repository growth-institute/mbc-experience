<?php $this->partial('header-html'); ?>
	<?php $this->partial('header'); ?>

		<section class="section section-home">
			<div class="inner boxfix-vert">
				<div class="margins">
					<div class="the-content">
						<h1 class="section-title">File</h1>
						<h3>Please upload the file.</h3>
						<p>Enjoy it!</p>
						<form action="" method="post" enctype="multipart/form-data">
							<input type="file" name="attachment">
							<button type="submit" class="button"> Upload </button>
						</form>
					</div>
				</div>
			</div>
		</section>

	<?php $this->partial('footer'); ?>
<?php $this->partial('footer-html'); ?>