<?php
	/**
	 * functions.inc.php
	 * Add your additional initialization routines here
	 */

	# Include additional Hummingbird dependencies
	include $site->baseDir('/external/utilities.inc.php');
	include $site->baseDir('/external/routes.inc.php');
	include $site->baseDir('/external/hooks.inc.php');
	include $site->baseDir('/external/endpoint.inc.php');
	include $site->baseDir('/external/controller.inc.php');
	include $site->baseDir('/external/model.inc.php');
	include $site->baseDir('/external/norm.inc.php');
	include $site->baseDir('/external/crood.inc.php');
	include $site->baseDir('/external/oppai.inc.php');
	include $site->baseDir('/external/tokenizr.inc.php');
	include $site->baseDir('/external/upload.inc.php');
	include $site->baseDir('/external/pagination.inc.php');
	include $site->baseDir('/external/module.inc.php');

	# Include Google Fonts
	$fonts = array(
		'Open Sans' => array(400, '400italic', 700, '700italic')
	);
	$site->registerStyle('google-fonts', get_google_fonts($fonts), true );
	$site->registerStyle('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', true );
	$site->registerStyle('reset', 'reset.css', false );
	$site->registerStyle('plugins', 'plugins/plugins.css', false );
	$site->registerStyle('simplemde', 'plugins/video-js.css', false );
	$site->registerStyle('videojs', 'http://vjs.zencdn.net/6.4.0/video-js.css', true );
	$site->registerStyle('print', 'print.css', false, array(), array('media' => 'print') );
	$site->registerStyle('site', 'site.less', false, array('reset', 'google-fonts', 'font-awesome', 'plugins', 'simplemde', 'videojs') );
	$site->enqueueStyle('site');
	$site->enqueueStyle('print');

	$site->registerScript('jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js', true);
	$site->registerScript('jquery.form', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js', true);
	$site->registerScript('underscore', 'https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js', true);
	$site->registerScript('marked', 'https://cdnjs.cloudflare.com/ajax/libs/marked/0.3.6/marked.min.js', true);
	$site->registerScript('simplemde', 'https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js', true);
	$site->registerScript('videojs', 'http://vjs.zencdn.net/6.4.0/video.js', true);
	$site->registerScript('videojs-vimeo', 'videojs-vimeo.js', false);

	$site->registerScript('class', 'class.js', false, array('jquery', 'underscore'));
	$site->registerScript('plugins', 'plugins.js', false, array('jquery'));
	$site->registerScript('app', 'app.js', false, array('class'));
	$site->registerScript('module', 'module.js', false, array('class'));

	$site->registerScript('client', 'client.js', false, array('app', 'module', 'plugins', 'marked', 'simplemde', 'jquery.form', 'videojs', 'videojs-vimeo'));

	# General meta tags
	$site->addMeta('UTF-8', '', 'charset');
	$site->addMeta('viewport', 'width=device-width, initial-scale=1');
	$site->addMeta('keywords', '');

	# OpenGraph meta tags
	$site->addMeta('og:title', $site->getPageTitle(), 'property');
	$site->addMeta('og:site_name', $site->getSiteTitle(), 'property');
	$site->addMeta('og:description', $site->getSiteTitle(), 'property');
	$site->addMeta('og:image', $site->img('branding/site-share.png', false), 'property');
	$site->addMeta('og:type', 'website', 'property');
	$site->addMeta('og:url', $site->urlTo('/'), 'property');

	//$site->addPage('files', 'page-file-download');

	$site->removePage('home');
	$site->getRouter()->removeRoute('/:page');

	# Dependencies
	include $site->baseDir('/external/lib/Parsedown.php');
	include $site->baseDir('/external/lib/PasswordHash.php');
	include $site->baseDir('/external/lib/Random.php');

	# Controllers
	include $site->baseDir('/external/controller/client.controller.php');
	include $site->baseDir('/external/controller/client/mbc.controller.php');
	include $site->baseDir('/external/controller/client/discourse.controller.php');

	# Models
	include $site->baseDir('/external/model/attachment.model.php');
	include $site->baseDir('/external/model/block.model.php');
	include $site->baseDir('/external/model/event.model.php');
	include $site->baseDir('/external/model/product.model.php');
	include $site->baseDir('/external/model/taxonomy.model.php');
	include $site->baseDir('/external/model/user.model.php');

	# Endpoints
	include $site->baseDir('/external/endpoint/app.endpoint.php');

	# Modules
	include $site->baseDir('/external/module/surveygizmo.module.php');

	//$site->user = null;

	# Restore user session (check for Users module first)
	if ( class_exists('Users') ) {
		Users::init();
		Users::checkLogin();
		$site->user = Users::getCurrentUser();
		// $locale = $site->user ? $site->user->getMeta('locale') : null;
		// if ($locale) {
		// 	$i18n->setLocale($locale);
		// }
	} else {
		$site->user = null;
	}

	# Session management
	recover_session();

?>