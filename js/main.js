(function() {this.TP = {};}).call(this);

(function(){
	TP.config= {
		strings:{
			sampple: 'sample'
		},
		errors:{
			error:"Error - "
		}
	};
	TP.html = {
		close:'<a href="#dialog" class="di-close"><span class="icon close"></span></a>',
		menudim: '<div class="menu-dim"></div>'
	};
	TP.properties = {
		offsetleft: 0
	};
}(TP));
jQuery(function() {
    TP.modules = {};
    $.each(modules, function() {
        if (!TP.modules[this]) {
            TP.modules[this] = this;
            if (TP[TP.modules[this]]) {
                TP[TP.modules[this]].init();
            }
        }
    });
    modules.push = function() {
        for (var i = 0; i < arguments.length; i++) {
            TP["ajax-modules"].init(arguments[i]);
        }
        return Array.prototype.push.apply(this, arguments);
    };

    TP.scrolling.init();

    // Check resolution and set respective properties
    TP.resolution.init();
	$(window).resize(function(e){
		TP.resolution.init();
	});

	// Attach scroll handlers
	$(window).scroll(function(e){
		TP["menu"].toggle();
	})

	// Start Tooltip
	$('[data-toggle="tooltip"]').tooltip();

});


(function () {
});

TP.scrolling = {
	lastScrollTop: 0,
	direction: function(){
		var st = $(window).scrollTop();
		var where = '';
		if (st > TP.scrolling.lastScrollTop){
			where = 'down';
		} else {
			where = 'up';
		}

		TP.scrolling.lastScrollTop = st;
		return where;
	},
    init: function() {
		TP.scrolling.lastScrollTop = $(window).scrollTop();
    },
};

TP["resolution"] = {
	screen: '',
    init: function() {
		if($(window).width() > 480){
			TP.properties.offsetleft = 60;
			TP["resolution"].screen = 'big';
		}else{
			TP.properties.offsetleft = 0;
			TP["resolution"].screen = 'small';
		}
		return TP["resolution"].screen
    },
};

TP.header = {
	header: $('#header'),
	init: function(){

	}
}

TP['internal-map'] = {
	container: '#item-map',
	init: function(){
		var itemaplace = new Maplace({
			locations: itemMapData,
			map_div: TP['internal-map'].container,
			controls_position: google.maps.ControlPosition.RIGHT_BOTTOM,
			controls_on_map: false
			//generate_controls: false
		}).Load(); 
		//40.913125, 20.649107
	}
}
var itemMapData = [
	{
        lat: 40.901806,
        lon: 20.668934,
        title: 'Title A1',
        html: [
            '<h3>Content C2</h3>',
            '<p>Lorem Ipsum..</p>'
        ].join(''),
        zoom: 12,
        icon: 'images/pictograms/map/restaurant.png',
        animation: google.maps.Animation.DROP
	},
	{
        lat: 40.903882,
        lon: 20.657561,
        title: 'Title A2',
        html: '<h4>Content A1</h4>',
        zoom: 12,
        icon: 'images/pictograms/map/small/hotel.png',
        animation: google.maps.Animation.DROP
	},
	{
        lat: 40.901416,
        lon: 20.674041,
        title: 'Title A2',
        html: '<h4>Content A1</h4>',
        zoom: 12,
        icon: 'images/pictograms/map/small/hotel.png',
        animation: google.maps.Animation.DROP
	},
	{
        lat: 40.913125,
        lon: 20.649107,
        title: 'Title A2',
        html: '<h4>Content A1</h4>',
        zoom: 12,
        icon: 'images/pictograms/map/small/watersport.png',
        animation: google.maps.Animation.DROP
	},
	{
        lat: 40.901125,
        lon: 20.664170,
        title: 'Title A2',
        html: '<h4>Content A1</h4>',
        zoom: 12,
        icon: 'images/pictograms/map/small/art.png',
        animation: google.maps.Animation.DROP
	},
	{
        lat: 40.900768,
        lon: 20.662497,
        title: 'Title A2',
        html: '<h4>Content A1</h4>',
        zoom: 12,
        icon: 'images/pictograms/map/small/institutions.png',
        animation: google.maps.Animation.DROP
	}
];

TP.lightbox = {
	init: function(selector){
		var items = selector && selector instanceof jQuery ? selector.find(".lightbox-item") : $(".lightbox-item");
		var itemselector = '.lightbox-item';
		var lightboxgallery = items.imageLightbox({
			onStart:		function() { TP.lightbox.overlayOn(); TP.lightbox.closeButtonOn( lightboxgallery ); TP.lightbox.navigationOn( lightboxgallery, itemselector ); },
			onEnd:			function() { TP.lightbox.overlayOff(); TP.lightbox.closeButtonOff(); TP.lightbox.navigationOff(); TP.lightbox.activityIndicatorOff(); },
			onLoadStart: 	function() { TP.lightbox.activityIndicatorOn(); },
			onLoadEnd:	 	function() { TP.lightbox.activityIndicatorOff(); TP.lightbox.navigationUpdate( itemselector );}
		})
	},
	// ACTIVITY INDICATOR
	activityIndicatorOn: function(){
		$( '<div id="imagelightbox-loading"><div></div></div>' ).appendTo( 'body' );
	},
	activityIndicatorOff: function(){
		$( '#imagelightbox-loading' ).remove();
	},
	// OVERLAY
	overlayOn: function(){
		$( '<div id="imagelightbox-overlay"></div>' ).appendTo( 'body' );
	},
	overlayOff: function(){
		$( '#imagelightbox-overlay' ).remove();
	},
	// CLOSE BUTTON
	closeButtonOn: function( instance ){
		$( '<button type="button" id="imagelightbox-close" title="Close"></button>' ).appendTo( 'body' ).on( 'click touchend', function(){ $( this ).remove(); instance.quitImageLightbox(); return false; });
	},
	closeButtonOff: function(){
		$( '#imagelightbox-close' ).remove();
	},
	// NAVIGATION
	navigationOn: function( instance, selector ){
		var images = $( selector );
		if( images.length )
		{
			var nav = $( '<div id="imagelightbox-nav"></div>' );
			for( var i = 0; i < images.length; i++ )
				nav.append( '<button type="button"></button>' );

			nav.appendTo( 'body' );
			nav.on( 'click touchend', function(){ return false; });

			var navItems = nav.find( 'button' );
			navItems.on( 'click touchend', function()
			{
				var $this = $( this );
				if( images.eq( $this.index() ).attr( 'href' ) != $( '#imagelightbox' ).attr( 'src' ) )
					instance.switchImageLightbox( $this.index() );

				navItems.removeClass( 'active' );
				navItems.eq( $this.index() ).addClass( 'active' );

				return false;
			})
			.on( 'touchend', function(){ return false; });
		}
	},
	navigationUpdate: function( selector ){
		var items = $( '#imagelightbox-nav button' );
		items.removeClass( 'active' );
		items.eq( $( selector ).filter( '[href="' + $( '#imagelightbox' ).attr( 'src' ) + '"]' ).index( selector ) ).addClass( 'active' );
	},
	navigationOff: function(){
		$( '#imagelightbox-nav' ).remove();
	}
}

TP.menu = {
	menu: $('#menu'),
	mainMenu: $('#main-menu'),
	menuDim: $('#menu-dim'),
	categories: $('#categories'),
    init: function() {
        TP.menu.mainMenu.find('a').each(function(index, element){
        	var item = $(element);
        	item.on('click', TP.menu.click);
        });
        TP.menu.menuDim.click(function(e){
        	TP.menu.mainMenu.find('a.active').trigger('click');
        	TP.menu.menuDim.fadeOut('fast');
        })
        TP.menu.menuDim.on('mousewheel', function(e){
        	e.preventDefault();
        })
        TP.menu.menuDim.on('scroll', function(e){
        	e.preventDefault();
        })
        /*console.log(TP.menu.menu);
        console.log(TP.menu.mainMenu);
        console.log(TP.menu.menuDim);*/
    },
    click: function(e){
    	e.preventDefault();
    	var trigger = $(e.currentTarget);
    	var target = $(trigger.attr('href'));
    	//console.log(target.data('offsetleft'));
    	if(!trigger.hasClass('active')){
	    	target.data('offsetleft', target.css('left'))
	    	target.animate({
	    		left: TP.properties.offsetleft+'px'
	    	}, 'fast', function(){
	    		trigger.addClass('active');
	    	})
	    	TP.menu.menuDim.fadeIn('fast');
    	}else{
	    	target.animate({
	    		left: target.data('offsetleft')
	    	}, 'fast', function(){
	    		trigger.removeClass('active');
	    	})
	    	TP.menu.menuDim.fadeOut('fast');
    	}
    },
    toggle: function(){
    	if(TP["resolution"].screen == 'small'){
    		var position = TP.menu.menu.position();
    		//console.log(position.left);
    		if(TP.scrolling.direction() == 'up'){
    			TP.menu.animate(true);
    		}else{
    			TP.menu.animate(false)
    		}
    	}else{
    		
    	}
    },
    animate: function(showmenu){

    	var menuleftpos		= showmenu == true ? '0px' : '-40px';
    	var headerleftpos	= showmenu == true ? '40px' : '0px';

    	if(!showmenu){
    		//leftpos 		= '-40px';
    		//headerleftpos	= '0px';
    	}

    	TP.menu.menu.animate(
    		{
    			left : menuleftpos
    		},
    		{
    			duration: 'fast',
    			queue : false,
    		}
    	)

    	TP.header.header.animate(
    		{
    			left : headerleftpos
    		},
    		{
    			duration: 'fast',
    			queue : false,
    		}
    	)
    }
};