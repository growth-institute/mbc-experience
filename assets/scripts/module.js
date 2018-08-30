Module = Class.extend({
	init: function(options) {
		var obj = this,
			opts = $.extend(true, {}, options);
		obj.opts = opts;
	},
	onDomReady: function($) {
		var obj = this;
	}
});