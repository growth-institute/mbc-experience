App = Class.extend({
	module: null,
	modules: null,
	init: function(options) {
		var obj = this,
			opts = $.extend(true, {}, options);
		obj.opts = opts;
		obj.modules = {};
		jQuery(document).ready(function($) {
			obj.onDomReady($);
		});
	},
	registerModule: function(slug, className) {
		var obj = this;
		this.modules[slug] = className;
	},
	unregisterModule: function(slug, className) {
		var obj = this;
		delete this.modules[slug];
	},
	onDomReady: function($) {
		var obj = this;
		// Try to autoload module
		if ( !!obj.modules[constants.mvc.controller] ) {
			var name = constants.mvc.controller;
			var path = constants.siteUrl + 'assets/scripts/modules/' + name + '.module.js';
			var script = document.createElement('script');
			script.type = 'text/javascript';
			script.src = path;
			script.onload = function() {
				var fn = window[ obj.modules[name] ];
				if (!! fn ) {
					try {
						obj.module = new fn();
						obj.module.onDomReady($);
					} catch (err) {
						throw('Failed module initialization ' + name);
					}
				}
			};
			script.onerror = function() {
				throw('Failed to load module '+ name +' at ' + path);
			};
			$('body')[0].appendChild(script);
		}
	},
	errorString: function(str) {
		return str;
	},
	compileTemplate: function(selector) {
		return _.template( $(selector).html() || '<div class="text-muted">Template <em>'+ selector +'</em> not found</div>' );
	},
	ajaxCall: function(options) {
		var obj = this,
			opts = _.defaults(options, {
				data: {},
				success: false,
				error: false,
				complete: false,
				type: 'get',
				url: '/',
				errorMsg: obj.errorString('ERR_GENERIC')
			});
		$.ajax({
			url: opts.url,
			type: opts.type,
			data: opts.data,
			dataType: 'json',
			success: function(response) {
				if (opts.complete) {
					opts.complete(response);
				}
				if (response && response.result == 'success') {
					if (opts.success) {
						opts.success(response.data);
					}
				} else {
					if (opts.error) {
						opts.error(obj.errorString(response.message) || opts.errorMsg);
					} else {
						$.alert(obj.errorString(response.message) || opts.errorMsg);
					}
				}
			}
		});
	}
});