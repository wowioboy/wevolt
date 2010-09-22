/**
 * We use the initCallback callback
 * to assign functionality to the controls
 */
function mycarousel_initCallback(carousel) {
    jQuery('.jcarousel-control a').bind('click', function() {
        carousel.scroll(jQuery.jcarousel.intval(jQuery(this).text()));
        return false;
    });

    jQuery('.jcarousel-scroll select').bind('change', function() {
        carousel.options.scroll = jQuery.jcarousel.intval(this.options[this.selectedIndex].value);
        return false;
    });

    jQuery('#mycarousel-next').bind('click', function() {
        carousel.next();
        return false;
    });

    jQuery('#mycarousel-prev').bind('click', function() {
        carousel.prev();
        return false;
    });
};

if (siteversion == 2) {
	// Ride the carousel...
jQuery(document).ready(function() {
								
    jQuery("#mycarousel").jcarousel({
        scroll: 11,
		visible: 11,
		vertical: false,
		start: stringstart,
        
        initCallback: mycarousel_initCallback,
        // This tells jCarousel NOT to autobuild prev/next buttons
        buttonNextHTML: null,
        buttonPrevHTML: null
    });
		
});
	
} else {
// Ride the carousel...
jQuery(document).ready(function() {
								
    jQuery("#mycarousel").jcarousel({
        scroll: 10,
		visible: 10,
		vertical: true,
		start: stringstart,
        
        initCallback: mycarousel_initCallback,
        // This tells jCarousel NOT to autobuild prev/next buttons
        buttonNextHTML: null,
        buttonPrevHTML: null
    });
		
});	
	
}
