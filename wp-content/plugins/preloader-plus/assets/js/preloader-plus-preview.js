jQuery(function($){

	var width = 100,
	    perfData = window.performance.timing, // The PerformanceTiming interface represents timing-related performance information for the given page.
	    EstimatedTime = -(perfData.loadEventEnd - perfData.navigationStart),
	    time = parseInt((EstimatedTime/1000)%60)*100;

			var preloader = document.querySelector(".preloader-plus");
			$('body').prepend(preloader);

			var progBar = document.querySelector(".prog-bar"),
      start = 0,
      end = 70,
      duration = time,
			counter = document.getElementById("preloader-counter");

			animateValue(progBar, start, end, duration);

	function animateValue(element, start, end, duration) {

  	var range = end - start,
    	current = start,
    	increment = end > start? 1 : -1,
    	stepTime = Math.abs(Math.floor(duration / range)),
    	obj = element;

    var timer = setInterval(function() {
			if(current < end) {
				current += increment;
			}
			if (obj !== null) {
				obj.style["transition-duration"] = "0.001s";
				obj.style.width= current + "%";
			}
			if (counter !== null) {
      	counter.innerHTML = current + "%";
			}
      if ( current == end ) {
				var endLoading = setInterval( function() {
					current += increment;
					if (obj !== null) {
						obj.style.width= current + "%";
					}
					if (counter !== null) {
		      	counter.innerHTML = current + "%";
					}
					if(current == 100) {
						setTimeout( function() {
							$('body, .preloader-plus').addClass('complete');
						}, preloader_plus.animation_delay)
						clearInterval(endLoading);
					}
				}, 1)
				clearInterval(timer);
      }
    }, stepTime);
	}

});
