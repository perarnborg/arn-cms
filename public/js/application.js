var app = window.app || {};

$(document).ready(function () {
	new app.Toggle();
	app.utils = new app.Utils();
    app.modal = new app.Modal();
    app.flash = new app.Flash();
    app.loadMore = new app.LoadMore();
});

app.Utils = function() {
};

app.Utils.prototype.executeFunctionByName = function(functionName, argument) {
	var fn = window;
	var functionParts = functionName.split('.');
	for(var i = 0; i < functionParts.length; i++) {
		fn = fn[functionParts[i]];
	}
	if(typeof(fn) == 'function') {
		return fn(argument);
	}
};

app.Toggle = function() {
	this.toggleTriggerSelector = '.toggle-trigger';
	this.toggleAreaSelector = '.toggle-area';
	this.eventListeners();
};

app.Toggle.prototype.eventListeners = function() {
	var self = this;
	$(document).on('click', self.toggleTriggerSelector, function(e) {
		e.preventDefault();
		var $trigger = $(this);
		var $area = self.getArea($trigger);
		if($trigger.data('group') && !$trigger.hasClass('open')) {
			$(self.toggleTriggerSelector+'.open[data-group='+$trigger.data('group')+']').each(function() {
				$openTrigger = $(this);
				$openArea = self.getArea($openTrigger);
				$openTrigger.removeClass('open');
				$openArea.hide();
				$openArea.removeClass('open');
			});
		}
		if($area.length > 0) {
			if($trigger.hasClass('open')) {
				$trigger.removeClass('open');
				$area.slideUp(100);
				$area.removeClass('open');
			} else {
				$trigger.addClass('open');
				$area.slideDown(100);
				setTimeout(function(){
					$area.addClass('open');
				}, 100);
			}
		}
	});
};

app.Toggle.prototype.getArea = function($trigger) {
	return $trigger.data('target') ? $($trigger.data('target')) : $trigger.next(self.toggleAreaSelector);
};

app.Modal = function() {
	this.modalClassName = 'modal';
	this.modalSelector = '.'+this.modalClassName;
	this.modalContentClassName = 'modal-content';
	this.modalContentSelector = '.'+this.modalContentClassName;
	this.modalCloseClassName = 'modal-close';
	this.modalCloseSelector = '.'+this.modalCloseClassName;
	this.modalIndex = 0;
	this.eventListeners();
};

app.Modal.prototype.eventListeners = function() {
	var self = this;
	$(document).on('click', self.modalCloseSelector, function(e){
		e.preventDefault();
		var $modal = $(this).closest(self.modalSelector);
		self.closeModal($modal);
	});
};

app.Modal.prototype.openModal = function($content) {
	var content = $content.html();
	var modalId = this.modalClassName+'-'+this.modalIndex;
	$('body').append('<div class="'+this.modalClassName+'" id="'+modalId+'"><div class="'+this.modalContentClassName+'"><a href="#" class="'+this.modalCloseClassName+' hidden-text">Close</a>'+content+'</div></div>');
	var $modal = $('#'+modalId);
	$modal.fadeIn(200);
	this.modalIndex++;
};

app.Modal.prototype.closeModal = function($modal) {
	$modal.fadeOut(200);
	setTimeout(function(){$modal.remove();}, 200);
};

app.LoadMore = function() {
	this.$loadMoreButton = $('.load-more');
	if(this.$loadMoreButton.length > 0) {
		this.$window = $(window);
		this.$document = $(document);
		this.offset = 0;
		this.itemSelector = this.$loadMoreButton.data('item-selector');
		this.pageSize = this.$loadMoreButton.data('page-size');
		this.$itemWrapper = $(this.$loadMoreButton.data('item-wrapper-selector'));
		this.url = this.$loadMoreButton.data('url');
		this.itemCallback = this.$loadMoreButton.data('item-callback');
		this.infinateScroll = !Modernizr.touch;
		if(this.$itemWrapper.length) {
			if($(this.itemSelector).length < this.pageSize) {
				this.reachedEnd();
			} else {
				this.eventListeners();
			}
		}
	}
};

app.LoadMore.prototype.eventListeners = function() {
	var self = this;
	self.$loadMoreButton.click(function(e) {
		if(!self.hasReachedEnd) {
			self.loadMore();
		}
	});
	if(self.infinateScroll) {
		self.$loadMoreButton.hide();
		self.setHeights();
        self.$window.scroll(function() {
          if (!self.hasReachedEnd && !self.hasError) {
            self.checkBottom();
          }
        }).resize(function() {
            self.setHeights();
        });
    }
};

app.LoadMore.prototype.setHeights = function() {
  this.bottomBuffer = 150;
  this.winHeight = this.$window.height();
  this.docHeight = this.$document.height();
};

app.LoadMore.prototype.reachedEnd = function() {
	this.hasReachedEnd = true;
	this.$loadMoreButton.hide();
};

app.LoadMore.prototype.checkBottom = function() {
  var scrollTop = this.$window.scrollTop();
  if (scrollTop >= (this.docHeight - this.winHeight - this.bottomBuffer) && !this.isLoading && !this.hasReachedEnd) {
    this.loadMore();
  }
};

app.LoadMore.prototype.loadMore = function() {
	var self = this;
	self.offset += this.pageSize;
	var url = self.url+'?offset='+self.offset+'&pageSize='+self.pageSize;
	if(self.itemCallback) {
		url += '&format=json';
	}
	self.isLoading = true;
	self.$itemWrapper.addClass('loading');
	$.ajax({
		url: url,
		dataType: (self.itemCallback ? 'json' : 'html'),
		success: function(data) {
			self.onSuccess(data);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(jqXHR, textStatus, errorThrown);
			self.onError(errorThrown);
		},
		complete: function() {
			self.isLoading = false;
			self.$itemWrapper.removeClass('loading');
		}
	});
};

app.LoadMore.prototype.onSuccess = function(data) {
	this.hasError = false;
	if(data && data.length) {
		var html = '';
		if(this.itemCallback) {
			for(var i = 0; i < data.length; i++) {
				html += app.utils.executeFunctionByName(this.itemCallback, data[i]);
			}
		} else {
			html = data;
		}
		this.$itemWrapper.append(html);
		this.setHeights();
	} else {
		this.reachedEnd();
	}
};

app.LoadMore.prototype.onError = function(errorThrown) {
	if(errorThrown == 'Not Found') {
		// Reached end if response is 404
		this.reachedEnd();
	} else {
		this.hasError = true;
		this.offset -= this.pageSize;
		this.$loadMoreButton.show();
	}
};
