//the product viewer popup

var mioPopup = {

	$back : $('#viewer-blackout'),

	$pop  : $('#viewer-pop'),

	$frame : $('#product-frame'),

	$loader: $('#loader-overlay'),

	init: function(){

		var obj = this;

		

		//bind the close

		obj.$back.click(function(){

			obj.close();	

		});



		//bind to the frame load

		//obj.$frame.load(function(){obj.loadComplete.call(obj);});



		//remove the default click

		$('.preview-link').click(function(){obj.load($(this).attr('href'));return false;});

	},

	close : function(){

		this.$back.hide();

		this.$frame.attr('scrolling','no');

		this.$pop.slideUp(600,function(){$('body').css('overflow','auto');});

	},

	open : function(){

		var obj = this;

		$('body').css('overflow','hidden');

		this.$back.show();

		this.$pop.slideDown(600,function(){obj.$frame.attr('scrolling','auto');});

	},

	load : function(url){

		this.$loader.show();

		this.$frame.attr('src',url);

		this.open();

	},

	loadComplete : function(){

		this.$loader.fadeOut();

	}

}

mioPopup.init();
