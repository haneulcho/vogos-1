// #ft_totop 클릭하면 최상단으로 이동
$(function(){
	$('#ft_totop').click(function(e) {
			e.preventDefault();
			$("html, body").animate({
					scrollTop: 0
			}, 600);
	});
	var timer;
	var navPosition = $('#side').offset().top;
	$(window).scroll(function() {
		var wPosition = $(window).scrollTop();
		if(timer) {
			clearTimeout(timer);
		}
		timer = setTimeout(function() {
			if(navPosition < wPosition) {
				if(!$('#side').hasClass('scrolled')){
					$('#side').addClass('scrolled');
				}
			}
			if(220 > wPosition) {
				$('#side').removeClass('scrolled');
			}
		}, 100);
	});
});