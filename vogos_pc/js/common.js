$(function(){
// #ft_totop 클릭하면 최상단으로 이동
$('#ft_totop').click(function(e) {
	e.preventDefault();
	$("html, body").animate({
		scrollTop: 0
	}, 600);
});
// #side 스크롤 따라 네비게이션 이동
function scrollNav(){
	var timer;
	var cHeight = $('body').find('#container').height();
	var sideNav = $('body').find('#side');
	if(cHeight < 681) {
		sideNav.css('position', 'static');
	} else {
		var navPosition = sideNav.offset().top;
		$(window).scroll(function() {
			var wPosition = $(window).scrollTop();
			if(timer) { clearTimeout(timer); }
			timer = setTimeout(function() {
				if(navPosition < wPosition) {
					if(!sideNav.hasClass('scrolled')){
						sideNav.addClass('scrolled');
					}
				}
				if(220 > wPosition) {
					sideNav.removeClass('scrolled');
				}
			}, 100);
		}); // scroll function END
	}
}; // scrollNav END
scrollNav();

});