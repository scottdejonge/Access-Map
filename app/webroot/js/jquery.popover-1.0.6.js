/**
 * jQuery.popover plugin v1.0.6
 * By Davey IJzermans
 * See http://wp.me/p12l3P-gT for details
 * http://daveyyzermans.nl/
 * 
 * Released under MIT License.
 */

;(function($) {
	//define some default plugin options
	var defaults = {
		topOffset: 0, //offset the popover by y px vertically (positive numbers are down)
		leftOffset: 0, //offset the popover by x px horizontally (positive numbers are to the right)
		title: false, //heading, false for none
		content: false, //content of the popover,
		url: false, //set to an url to load content via ajax
		classes: '', //classes to give the popover, i.e. normal, wider or large
		arrow: 'auto', //where should the arrow be placed? Auto, top, right, bottom, left or absolute (i.e. { top: 4 }, { left: 4 })
		fadeSpeed: 160, //how fast to fade out popovers when destroying or hiding
		trigger: 'click', //how to trigger the popover: click, hover or manual
		preventDefault: true, //preventDefault actions on the element on which the popover is called
		stopChildrenPropagation: true, //prevent propagation on popover children
		hideOnHTMLClick: true, //hides the popover when clicked outside of it
		anchor: false //anchor the popover to a different element
	}
	var options = {};
	var methods = {
		/**
		 * Initialization method
		 * Merges 
		 */
		init : function(params) {
			return this.each(function() {
				options = $.extend({}, defaults, params);
				
				var $this = $(this);
				var data = $this.data('popover');
				
				if(!data) {
					var popover = $('<div class="popover" />')
						.addClass(options.classes)
						.append('<div class="wrap"></div>')
						.append('<div class="arrow" />')
						.appendTo('body')
						.hide();
					
					if(options.stopChildrenPropagation)
						popover.children().bind('click.popover', function(event) {
							event.stopPropagation();
						});
					
					$this.bind('click.popover', function(event) {
						if(options.preventDefault)
							event.preventDefault();
						event.stopPropagation();
					});
					
					if(options.anchor)
						if(!options.anchor instanceof jQuery)
							options.anchor = $(options.anchor)
					
					var data = {
						target: $this,
						popover: popover,
						options: options
					};
					
					if(options.title)
						$('<div class="title" />')
							.html(options.title instanceof jQuery ? options.title.html() : options.title)
							.appendTo(popover.find('.wrap'));
					if(options.content)
						$('<div class="content" />')
							.html(options.content instanceof jQuery ? options.content.html() : options.content)
							.appendTo(popover.find('.wrap'));
					if(options.url)
						$this.popover('ajax', options.url);
					
					$(this).data('popover', data);
					
					$this.popover('reposition');
					$this.popover('setTrigger', options.trigger);
					
					if(options.hideOnHTMLClick)
						$('html').unbind('click.popover').bind('click.popover', function(event) {
							$('html').popover('fadeOutAll');
						});
				}
			});
		},
		reposition: function() {
			return this.each(function() {
				var $this = $(this);
				var data = $this.data('popover');
				
				if(data) {
					var popover = data.popover;
					var options = data.options;
					var $anchor = options.anchor ? $(options.anchor) : $this;
					
					var coordinates = $anchor.offset();
					var top = coordinates.top + $anchor.outerHeight();
					var left = coordinates.left - popover.outerWidth() / 2 + $anchor.outerWidth() / 2;
					
					popover.css({ top: top-110, left: left, marginTop: options.topOffset, marginLeft: options.leftOffset });
				}
			});
		},
		destroy: function() {
			return this.each(function() {
				var $this = $(this);
				var data = $this.data('popover');
				$this.unbind('.popover');
				$(window).unbind('.popover');
				data.popover.remove();
				$this.removeData('popover');
			});
		},
		show: function() {
			return this.each(function() {
				var $this = $(this);
				var data = $this.data('popover');
				if(data) {
					var popover = data.popover;
					$this.popover('reposition');
					popover.clearQueue().css({ zIndex: 950 }).show();
				}
			});
		},
		hide: function() {
			return this.each(function() {
				var $this = $(this);
				var data = $this.data('popover');
				if(data)
					data.popover.hide().css({ zIndex: 949 });
			});
		},
		fadeOut: function(ms) {
			return this.each(function() {
				var $this = $(this);
				var data = $this.data('popover');
				if(data) {
					var popover = data.popover;
					var options = data.options;
					popover.delay(100).css({ zIndex: 949 }).fadeOut(ms ? ms : options.fadeSpeed);
				}
			});
		},
		hideAll: function() {
			return this.each(function() {
				$('.popover').hide().css({ zIndex: 949 });
			});
		},
		fadeOutAll: function(ms) {
			return this.each(function() {
				$('.popover').css({ zIndex: 949 }).fadeOut(ms ? ms : options.fadeSpeed);
			});
		},
		setTrigger: function(trigger) {
			return this.each(function() {
				var $this = $(this);
				var data = $this.data('popover');
				if(data) {
					var popover = data.popover;
					
					if(trigger === 'click') {
						$this.bind('click.popover', function(event) {
							event.preventDefault();
							event.stopPropagation();
							$this.popover('show');
						});
						popover.unbind('click.popover').bind('click.popover', function(event) {
							event.stopPropagation();
						});
					} else {
						$this.unbind('click.popover');
						popover.unbind('click.popover')
					}
					
					if(trigger === 'hover') {
						$this.add(popover).bind('mousemove.popover', function(event) {
							$this.popover('show');
						});
						$this.add(popover).bind('mouseleave.popover', function(event) {
							$this.popover('fadeOut');
						});
					} else {
						$this.add(popover).unbind('mousemove.popover').unbind('mouseleave.popover');
					}
				}
			});
		},
		title: function(text) {
			return this.each(function() {
				var $this = $(this);
				var data = $this.data('popover');
				
				if(data) {
					var title = data.popover.find('.title');
					var wrap = data.popover.find('.wrap');
					if(title.length === 0)
						title = $('<div class="title" />').appendTo(wrap);
					title.html(text);
				}
			});
		},
		content: function(html) {
			return this.each(function() {
				var $this = $(this);
				var data = $this.data('popover');
				
				if(data) {
					var content = data.popover.find('.content');
					var wrap = data.popover.find('.wrap');
					if(content.length === 0)
						content = $('<div class="content" />').appendTo(wrap);
					content.html(html);
				}
			});
		},
		ajax: function(url, ajax_params) {
			return this.each(function() {
				var $this = $(this);
				var data = $this.data('popover');
				
				if(data) {
					var ajax_defaults = {
						url: url,
						success: function(ajax_data) {
							var content = data.popover.find('.content');
							var wrap = data.popover.find('.wrap');
							if(content.length === 0)
								content = $('<div class="content" />').appendTo(wrap);
							content.html(ajax_data);
						}
					}
					var ajax_options = $.extend({}, ajax_defaults, ajax_params);
					$.ajax(ajax_options);
				}
			});
		},
		setOption: function(option, value) {
			return this.each(function() {
				var $this = $(this);
				var data = $this.data('popover');
				
				if(data)
					data[option] = value;
			});
		}
	};

	$.fn.popover = function(method) {
		if(methods[method])
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		else if( typeof method === 'object' || !method)
			return methods.init.apply(this, arguments);
		else
			$.error('Method ' + method + ' does not exist on jQuery.popover');
	}
})(jQuery);
