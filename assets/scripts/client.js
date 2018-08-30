ClientApp = App.extend({
	init: function(options) {
		var obj = this;
		obj.parent(options);
		// Register modules
		obj.registerModule('mbc', 'ModuleMBC');
	},
	onDomReady: function($) {
		var obj = this;
		obj.parent($);
	}
});

var client = new ClientApp();