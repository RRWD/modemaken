(function($) {

	var element_to_click  = '.mm-toggle-click';

    $(element_to_click).click(function () {
        $(this).next("ul").slideToggle(400);
        $(element_to_click).toggleAttr("aria-expanded",'true', 'false');
    });

    /*!
	 * toggleAttr() jQuery plugin
	 * @link https://gist.github.com/mathiasbynens/298591
	 */
	$.fn.toggleAttr = function(attr, attr1, attr2) {
	  return this.each(function() {
	    var self = $(this);
	    if (self.attr(attr) == attr1)
	      self.attr(attr, attr2);
	    else
	      self.attr(attr, attr1);
	  });
	};


})( jQuery );

